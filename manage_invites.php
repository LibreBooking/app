<?php
/**
* Interface form for accepting/declining reservations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-15-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Template.class.php');
include_once('lib/Reservation.class.php');
include_once('lib/Resource.class.php');

$t = new Template(translate('Manage Invites'));

if (Auth::is_logged_in() && (isset($_POST['y']) || isset($_POST['n'])) ) {
	CmnFns::redirect('ctrlpnl.php', 1, false);
}

$t->printHTMLHeader();

if (Auth::is_logged_in()) {
	$t->printWelcome();
}
$t->startMain();

if (isset($_POST['y'])) {
	// Process the reservation 
	if (isset($_GET['id']) && isset($_GET['memberid']) && isset($_GET['action'])) {
		global $conf;
		$memberid = $_GET['memberid'];
		$resid = $_GET['id'];
		$action = $_GET['action'];
		$accept_code = $_GET['accept_code'];
		
		// Get the user
		$user = new User($memberid);
		if ($user == null) {
			// User not found, look in the anon table
			$user = new AnonymousUser($memberid);
			if ($user == null) {
				// Still not found...
				CmnFns::do_error_box(translate('Sorry, we could not find that user in the database.'), '', false);
			}
		}
		else {
			// Get the Reservation
			$res = new Reservation($resid);
			$resource = new Resource();
			$max_participants = $resource->get_property('max_participants', $res->get_machid());
			
			// If the total number of users (minus the owner) already participating is less than the max, let this user participate
			if ( $action == INVITE_DECLINE || ($max_participants == '' || count($res->participating_users) < $max_participants) ) {
	
				$found_user = false;
				$owner_id = false;
				for ($i = 0; $i < count($res->users); $i++) {
					if ($res->users[$i]['memberid'] == $memberid && $res->users[$i]['accept_code'] == $accept_code) { $found_user = true; }
					if ($res->users[$i]['owner'] == 1) { $owner_id = $res->users[$i]['memberid']; }
				}
		
				// We have to have found both this user in the invite list and the reservation owner or else it makes no sense to participate
				if ($found_user && $owner_id !== false) {
					$translate_index = 'reservation ' . (($action == INVITE_ACCEPT) ? 'accepted' : 'declined');
					// Update the invite record
					$failed = $res->update_users($memberid, $action, isset($_POST['update_all']), $max_participants);
					if (is_array($failed) && $failed !== false) {
						// Let the owner know the user accepted/declined
						$owner = new User($owner_id);
						
						$mailer = new PHPMailer();		
						$mailer->From = $conf['app']['adminEmail'];
						$mailer->FromName = $conf['app']['title'];
						$mailer->Subject =  translate($translate_index, array($user->get_name(), Time::formatDate($res->start_date)));
						$mailer->IsHTML(false);
						
						$mailer->AddAddress($owner->get_email());
						$mailer->Body = translate($translate_index, array($user->get_name(), Time::formatDate($res->start_date)));
						$mailer->Send();
						
						if (count($failed) > 0) {
							echo '<p>' . translate('You are not participating on the following reservation dates because they are at full capacity.') . '</p>';
							for ($i = 0; $i < count($failed); $i++) {
								echo '<p>' . Time::formatDate($failed[$i]['start_date']) . '</p>';
							}
						}
						
						$msg = '';
						$msg .= translate($translate_index, array($user->get_name(), Time::formatDate($res->start_date))) . '<br/>';
						if (Auth::is_logged_in()) {
							$msg .= Link::getLink('ctrlpnl.php', translate('Return to My Control Panel'));
						}	
						else {
							$msg .= Link::getLink('index.php', translate('Login to manage all of your invitiations'));
						}
						
						CmnFns::do_message_box($msg);
					}	
				}
				else {
					CmnFns::do_error_box(translate('That record could not be found.'), '', false);
				}
			}
			else {
				CmnFns::do_error_box(translate('That reservation is at full capacity.'), '', false);
			}
		}
	}
	else {
		CmnFns::do_error_box(translate('No invite was selected'), '', false);
	}
}
else if (isset($_POST['n'])) {
	if (Auth::is_logged_in()) {
		$msg = Link::getLink('ctrlpnl.php', translate('Return to My Control Panel'));
	}	
	else {
		$msg = Link::getLink('index.php', translate('Login to manage all of your invitiations'));
	}
	CmnFns::do_message_box($msg);
}
else {
	$resid = $_GET['id'];
	$action = $_GET['action'];
	$res = new Reservation($resid);
	$resource = new Resource();
	$max_participants = $resource->get_property('max_participants', $res->get_machid());

	// If the total number of users (minus the owner) already participating is less than the max, let this user participate
	if ( $action == INVITE_DECLINE || ($max_participants == '' || count($res->participating_users) < $max_participants) ) {
		$msg = '<h5>' . translate('Confirm reservation participation') . '</h5><br/>';
		$word = ($_GET['action'] == INVITE_ACCEPT) ? 'Accept' : 'Decline';
		$msg .= '<input type="submit" class="button" name="y" value="' . translate($word) . '"/>';
		$msg .= ' ';
		$msg .= '<input type="submit" class="button" name="n" value="' . translate('Cancel') . '"/>';
		if ($res->is_repeat()) {
			$msg .= '<br/><input type="checkbox" name="update_all" value="yes"/> '. translate('Do for all reservations in the group?');
		}
		echo '<form name="inv_mgmt" action="' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '" method="post">';
		CmnFns::do_message_box($msg);
		echo '</form>';
	}
	else {
		CmnFns::do_error_box(translate('That reservation is at full capacity.'), '', false);
	}
}

// End main table
$t->endMain();

// Print HTML footer
$t->printHTMLFooter();
?>