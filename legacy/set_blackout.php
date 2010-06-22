<?php
/**
* Interface form for placing/modifying/viewing a blackout
* This file will present a form for a user to
*  make a new blackout or modify/delete an old one.
* It will also allow other users to view this blackout.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-22-04
* @package phpScheduleIt
*/
/**
* Template class
*/
include_once('lib/Template.class.php');
/**
* Reservation class
*/
include_once('lib/Blackout.class.php');


// Check that the admin is logged in
if (!Auth::isAdmin()) {
    CmnFns::do_error_box('This section is only available to the administrator.<br />'
        . '<a href="ctrlpnl.php">Back to My Control Panel</a>');
}

$t = new Template();

if (isset($_POST['submit']) && strstr($_SERVER['HTTP_REFERER'], $_SERVER['PHP_SELF'])) {
	$t->set_title('Processing Blackout');
	$t->printHTMLHeader();
	$t->startMain();

	process_blackout($_POST['fn']);
}
else {
	$blackout_info = getBlackoutInfo();
	$t->set_title($blackout_info['title']);
	$t->printHTMLHeader();
	$t->startMain();

	present_blackout($blackout_info['resid']);
}

// End main table
$t->endMain();

// Print HTML footer
$t->printHTMLFooter();

/**
* Processes a reservation request (add/del/edit)
* @param string $fn function to perform
*/
function process_blackout($fn) {
	$success = false;

	if (isset($_POST['resid']))
		$res = new Blackout($_POST['resid']);
	else if (isset($_GET['resid']))
		$res = new Blackout($_GET['resid']);
	else {
		$res = new Blackout();
		if (isset($_POST['repeat_day'])) {		// Check for reservation repeation
			$res->is_repeat = true;
			$repeat = get_repeat_dates($_POST['ts'], $_POST['repeat_day'], $_POST['duration']);
		}
		else
			$repeat = array($_POST['ts']);
	}

	if ($fn == 'create')
		$res->add_blackout($_POST['machid'], $_POST['starttime'], $_POST['endtime'], $repeat, $_POST['summary']);
	else if ($fn == 'modify')
		$res->mod_blackout($_POST['starttime'], $_POST['endtime'], isset($_POST['del']), isset($_POST['mod_recur']), $_POST['summary']);
	else if ($fn == 'delete')
		$res->del_blackout(isset($_POST['mod_recur']));
}

/**
* Prints out reservation info depending on what parameters
*  were passed in through the query string
* @param none
*/
function present_blackout($blackoutid) {
	// Get info about this reservation
	$blackout = new Blackout($blackoutid);
	$blackout->print_res();
}


/**
* Return array of data from query string about this reservation
*  or about a new reservation being created
* @param none
*/
function getBlackoutInfo() {
	$blackout_info = array();

	// Determine title and set needed variables
	$blackout_info['type'] = $_GET['type'];
	switch($blackout_info['type']) {
		case 'r' :
			$blackout_info['title'] = 'New Blackout';
			$blackout_info['resid']	= null;
			break;
		case 'm' :
			$blackout_info['title'] = 'Modify Blackout';
			$blackout_info['resid'] = $_GET['resid'];
			break;
		case 'd' :
			$blackout_info['title'] = 'Delete Blackout';
			$blackout_info['resid'] = $_GET['resid'];
			break;
	}

	return $blackout_info;
}

/**
* Returns an array of all timestamps for repeat reservations
* @param int $res_date initial reservation date
* @param array $days_to_repeat days of week to repeat reservation
* @param int $duration weeks to repeat reservation for
* @return array of timestamps of reservations
*/
function get_repeat_dates($blackout_date, $days_to_repeat, $duration) {
	$day_of_week = date('w', $blackout_date);		// Day of week for initial reservation

	$blackout_dates = array($blackout_date);
	$date_vals = getdate($blackout_date);

	// Repeat for all weeks
	$additional_days = 0;
	for ($repeat_week = 0; $repeat_week < $duration; $repeat_week++) {		// Repeat for duration
		for ($i = 0; $i < count($days_to_repeat); $i++) {					// Repeat for all days selected
			$days_between = ($days_to_repeat[$i] - $day_of_week) + $additional_days;
			// If the day of week is less than reservation day of week, move ahead one week
			if ($days_to_repeat[$i] <= $day_of_week) {
				$days_between += 7;
			}
			$blackout_date = mktime(0,0,0, $date_vals['mon'], $date_vals['mday'] + $days_between);
			array_push($blackout_dates, $blackout_date);
		}
		$additional_days += 7;	// Move ahead one week
	}

	return $blackout_dates;
}
?>