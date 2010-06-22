<?php
/**
* All specific views of an individual resource calendar will be available from this file
*  such as day/week/month view
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-08-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
list($s_sec, $s_msec) = explode(' ', microtime());	// Start execution timer
/**
* Include Template class
*/
include_once('lib/Template.class.php');
/**
* Include scheduler-specific output functions
*/
include_once('lib/ResCalendar.class.php');

// Check that the user is logged in
if (!Auth::is_logged_in()) {
    Auth::print_login_msg();
}

$t = new Template(translate('Resource Calendar'));

// Print HTML headers
$t->printHTMLHeader();

// Print welcome box
$t->printWelcome();

// Begin main table
$t->startMain();

$type = isset($_GET['view']) ? $_GET['view'] : MYCALENDARTYPE_DAY;
$machid = isset($_GET['machid']) ? $_GET['machid'] : null;
$scheduleid = isset($_GET['scheduleid']) ? $_GET['scheduleid'] : null;

$calendar = new ResCalendar(Auth::getCurrentID(), $type, get_calendar_actual_date(), $machid, $scheduleid);

$calendar->print_calendar();

// End main table
$t->endMain();

list($e_sec, $e_msec) = explode(' ', microtime());		// End execution timer
$tot = ((float)$e_sec + (float)$e_msec) - ((float)$s_sec + (float)$s_msec);
echo '<!--Schedule printout time: ' . sprintf('%.16f', $tot) . ' seconds-->';
// Print HTML footer
$t->printHTMLFooter();


/**
* Sets the 'actualDate' field of the MyCalendar object
* @param none
* @return datestamp of the viewed date
*/
function get_calendar_actual_date() {
	if (isset($_GET['date'])) {
		$date_split = explode('-', $_GET['date']);
	}
	else {
		$date_split = explode('-', date('m-d-Y', Time::getAdjustedTime(mktime(), date('H') * 60)));
	}
	
	return mktime(0,0,0, $date_split[0], $date_split[1], $date_split[2]);	
}
?>