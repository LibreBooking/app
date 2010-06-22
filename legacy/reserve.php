<?php
/**
* Interface form for placing/modifying/viewing a reservation
* This file will present a form for a user to
*  make a new reservation or modify/delete an old one.
* It will also allow other users to view this reservation.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 08-08-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Resource.class.php');
include_once('lib/Template.class.php');
include_once('lib/helpers/ReservationHelper.class.php');
include_once('lib/Utility.class.php');

$timer = new Timer();
$timer->start();

$is_blackout = (isset($_GET['is_blackout']) && ($_GET['is_blackout'] == '1'));

if ($is_blackout) {
	// Make sure user is logged in
	if (!Auth::is_logged_in()) {
		Auth::print_login_msg();
	}

	include_once('lib/Blackout.class.php');
	$Class = 'Blackout';
	$_POST['minres'] = $_POST['maxRes'] = null;
}
else {

	include_once('lib/Reservation.class.php');
	$Class = 'Reservation';
}

if ((!isset($_GET['read_only']) || !$_GET['read_only']) && $conf['app']['readOnlyDetails']) {
	// Make sure user is logged in
	if (!Auth::is_logged_in()) {
		Auth::print_login_msg();
	}
}

$t = new Template();

if (isset($_POST['btnSubmit']) && strstr($_SERVER['HTTP_REFERER'], $_SERVER['PHP_SELF'])) {
	$t->set_title(translate("Processing $Class"));
	$t->printHTMLHeader();
	$t->startMain();

	process_reservation($_POST['fn']);
}
else {
	$res_info = getResInfo();
	$t->set_title($res_info['title']);
    $t->printHTMLHeader();
    $t->startMain();
    present_reservation($res_info['resid']);
}

// End main table
$t->endMain();

$timer->stop();
$timer->print_comment();

// Print HTML footer
$t->printHTMLFooter();

/**
* Processes a reservation request (add/del/edit)
* @param string $fn function to perform
*/
function process_reservation($fn) {
	$success = false;
	global $Class;
	$is_pending = (isset($_POST['pending']) && $_POST['pending']);

	if (isset($_POST['start_date'])) {			// Parse the POST-ed starting and ending dates
		$start_date = eval('return mktime(0,0,0, \'' . str_replace(INTERNAL_DATE_SEPERATOR, '\',\'', $_POST['start_date']) . '\');');
		$end_date = eval('return mktime(0,0,0, \'' . str_replace(INTERNAL_DATE_SEPERATOR, '\',\'', $_POST['end_date']) . '\');');
	}

	if (isset($_POST['resid']))
		$res = new $Class($_POST['resid'], false, $is_pending);
	else if (isset($_GET['resid']))
		$res = new $Class($_GET['resid'], false, $is_pending);
	else {
		// New reservation
		$res = new $Class(null, false, $is_pending);
		if ($_POST['interval'] != 'none') {		// Check for reservation repeation
			if ($start_date == $end_date) {
				$res->is_repeat = true;
				$days = isset($_POST['repeat_day']) ? $_POST['repeat_day'] : NULL;
				$week_num = isset($_POST['week_number']) ? $_POST['week_number'] : NULL;
				$repeat = CmnFns::get_repeat_dates($start_date, $_POST['interval'], $days, $_POST['repeat_until'], $_POST['frequency'], $week_num);
			}
			else {
				// Cannot repeat multi-day reservations
				$repeat = array($start_date);
				$res->is_repeat = false;
			}
		}
		else {
			$repeat = array($start_date);
			$res->is_repeat = false;
		}
	}

	$cur_user = new User(Auth::getCurrentID());
	$res->adminMode = Auth::isAdmin() || $cur_user->get_isadmin() || ($fn != 'create' && $cur_user->is_group_admin($res->user->get_groupids()));

	if ($fn == 'create' || $fn == 'modify') {
		$helper = new ReservationHelper();
		$util = new Utility();

		$orig = (isset($_POST['orig_invited_users']) && count($_POST['orig_invited_users']) > 0) ? $_POST['orig_invited_users'] : array();
		$invited = (isset($_POST['invited_users'])) ? $_POST['invited_users'] : array();
		$removed = (isset($_POST['removed_users'])) ? $_POST['removed_users'] : array();

		$users_to_remove = $helper->getRowsForRemoval($orig, $removed, $invited);
		$users_to_invite = $helper->getRowsForInvitation($orig, $invited);
		$unchanged_users = $helper->getUnchangedUsers($orig, $invited);

		$orig_resources = (isset($_POST['orig_resources']) && count($_POST['orig_resources']) > 0) ? $_POST['orig_resources'] : array();
		$selected_resources =  (isset($_POST['selected_resources']) && count($_POST['selected_resources']) > 0) ? $_POST['selected_resources'] : array();

		$resources_to_add = $util->getAddedItems($orig_resources, $selected_resources);
		$resources_to_remove = $util->getRemovedItems($orig_resources, $selected_resources);

		$res->user 		= new User($_POST['memberid']);
		$res->start_date= $start_date;
		$res->end_date 	= $end_date;
		$res->start		= $_POST['starttime'];
		$res->end		= $_POST['endtime'];

		$res->summary	= stripslashes($_POST['summary']);
		$res->allow_participation = (int)isset($_POST['allow_participation']);
		$res->allow_anon_participation = (int)isset($_POST['allow_anon_participation']);
		$res->reminderid = isset($_POST['reminderid']) ? $_POST['reminderid'] : null;
		$res->reminder_minutes_prior = isset($_POST['reminder_minutes_prior']) ? intval($_POST['reminder_minutes_prior']) : 0;
	}

	if ($fn == 'create') {
		$res->resource = new Resource($_POST['machid']);
		$res->scheduleid= $_POST['scheduleid'];
		$res->repeat = $repeat;
		$res->add_res($users_to_invite, $resources_to_add);
	}
	else if ($fn == 'modify') {
		$res->summary = str_replace("\n", '', $_POST['summary']);
		$res->mod_res($users_to_invite, $users_to_remove, $unchanged_users, $resources_to_add, $resources_to_remove, isset($_POST['del']), isset($_POST['mod_recur']));
	}
	else if ($fn == 'delete') {
		$res->del_res(isset($_POST['mod_recur']));
	}
	else if ($fn == 'approve') {
		$res->approve_res(isset($_POST['mod_recur']));
	}
}

/**
* Prints out reservation info depending on what parameters
*  were passed in through the query string
* @param none
*/
function present_reservation($resid) {
	global $Class;

	// Get info about this reservation
	$res = new $Class($resid, false, false, $_GET['scheduleid']);
	// Load the properties
	if ($resid == null) {
		$res->resource = new Resource($_GET['machid']);
		$res->start_date = $_GET['start_date'];
		$res->end_date = $_GET['start_date'];
		$res->user = new User(Auth::getCurrentID());
		$res->is_pending = $_GET['pending'];
		$res->start = $_GET['starttime'];
		$res->end = $_GET['endtime'];
	}

	$cur_user = new User(Auth::getCurrentID());
	$res->adminMode = Auth::isAdmin() || $cur_user->get_isadmin() || $cur_user->is_group_admin($res->user->get_groupids() );
	$res->set_type($_GET['type']);
	$res->print_res();
}


/**
* Return array of data from query string about this reservation
*  or about a new reservation being created
* @param none
*/
function getResInfo() {
	$res_info = array();
	global $Class;

	// Determine title and set needed variables
	$res_info['type'] = $_GET['type'];
	switch($res_info['type']) {
		case RES_TYPE_ADD :
			$res_info['title'] = "New $Class";
			$res_info['resid']	= null;
			break;
		case RES_TYPE_MODIFY :
			$res_info['title'] = "Modify $Class";
			$res_info['resid'] = $_GET['resid'];
			break;
		case RES_TYPE_DELETE :
			$res_info['title'] = "Delete $Class";
			$res_info['resid'] = $_GET['resid'];
			break;
        case RES_TYPE_APPROVE :
			$res_info['title'] = "Approve $Class";
			$res_info['resid'] = $_GET['resid'];
			break;
        default : $res_info['title'] = "View $Class";
			$res_info['resid'] = $_GET['resid'];
			break;
	}

	return $res_info;
}
?>