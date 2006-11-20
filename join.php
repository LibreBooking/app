<?php
/**
* Handles the self activation for users joining a reservation
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-17-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__);
include_once($basedir . '/lib/Template.class.php');
include_once($basedir . '/lib/Reservation.class.php');
include_once($basedir . '/lib/AnonymousUser.class.php');

$t = new Template(translate('Join Reservation'));
$t->printHTMLHeader();
$t->startMain();

$resid = htmlspecialchars($_POST['h_join_resid']);
$userid = htmlspecialchars($_POST['h_join_userid']);
$fname = htmlspecialchars(trim($_POST['h_join_fname']));
$lname = htmlspecialchars(trim($_POST['h_join_lname']));
$email_address = htmlspecialchars(trim($_POST['h_join_email']));
$join_all = isset($_POST['join_parentid']);

$found_user = false;

// Get the Reservation
$res = new Reservation($resid);

if ($res != null && !empty($resid)) {
	$found_user = findUser($userid);
	
	// Validate data
	if (validate_data($userid, $fname, $lname, $email) == '') {
		$user = new User();
		// Load get the userid or create one if the data is ok
		// First see if we have a user with this email address
		if ( ($userid == $user->get_id_by_email($email)) != false ) {
			// Invite the user we found in the database
			$user = new User($userid);
			$userid = $user->get_id();
			$found_user = true;
		}
		else if ( ($userid == AnonymousUser::get_id_by_email($email)) != false ) {
			// There is an anonymous user with this email already, update info
			$a_user = new AnonymousUser($userid);
			$a_user->fname = $fname;
			$a_user->lname = $lname;
			$a_user->email = $email_address;
			$a_user->save();
			
			// Create temporary User object for inviting them			
			$user = new User();
			$user->userid = $userid;
			$user->fname = $fname;
			$user->lname = $lname;
			$user->email = $email_address;
			$found_user = true;
		}
		else {
			// Create the anonymous user
			$a_user = AnonymousUser::getNewUser();
			$a_user->fname = $fname;
			$a_user->lname = $lname;
			$a_user->email = $email_address;
			$a_user->save();
			
			$user = new User();
			$user->userid = $userid;
			$user->fname = $fname;
			$user->lname = $lname;
			$user->email = $email_address;
			$found_user = true;
		}
		if ($found_user) {
			$participating = false;
			// See if the user is already in the participation list
			for ($i = 0; $i < count($res->users); $i++) {
				if ($res->users[$i]['memberid'] == $userid) {
					$participating = true;
					break;
				}
			}
			if (!$participating) {	
				$accept_code = $res->db->get_new_id();
				// Add the user to the invite list in the db
				$res->add_participant($userid, $accept_code);
				// Send the invite email
				$info[$userid] = $user->email;
				$res->invite_users($info, array(), $accept_code);
			}
			else {
				CmnFns::do_error_box(translate('You are already invited to this reservation. Please follow participation instructions previously sent to your email.'), '', false);
			}
		}
		else {
			CmnFns::do_error_box(translate('Sorry, we could not find that user in the database.'), '', false);		
		}
	}
	else {
		CmnFns::do_error_box(translate('Please go back and correct any errors.'), '', false);
	}
}
else {
	CmnFns::do_error_box(translate('That record could not be found.'), '', false);
}

echo '<p align="center"><a href="javascript:close();">' . translate('Close') . '</a></p>';

$t->endMain();
$t->printHTMLFooter();


function findUser($userid) {
	$found_user = false;
	
	if (!empty($userid)) {	
		$user = new User($userid);
		if ($user != null) {
			$userid = $user->get_id();
			$fname = $user->get_fname();
			$lname = $user->get_lname();
			$email_address = $user->get_email();
			$found_user = true;
		}
		else {
			$found_user = false;
		}
	}
	
	return $found_user;
}


/**
* Makes sure that the data entered is ok
* @param string $userid
* @param string $fname
* @param string $lname
* @param string $email
* @return message if the data is valid or not
*/
function validate_data($userid, $fname, $lname, $email) {
	$msg = '';
	if ($userid == '') {
		if (empty($fname)) {
			$msg .= translate('First name is required.') . '<br/>';
		}
		if (empty($lname)) {
			$msg .= translate('Last name is required.') . '<br/>';
		}
		if (empty($email) || !preg_match("/^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/", $email)) {
			$msg .= translate('Valid email address is required.');
		}
	}
	
	return $msg;
}
?>