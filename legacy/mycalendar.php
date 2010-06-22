<?php
/**
* All specific views of the calendar will be available from this file
*  such as day/week/month view
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-08-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
include_once('lib/Template.class.php');
include_once('lib/MyCalendar.class.php');

$timer = new Timer();
$timer->start();

// Check that the user is logged in
if (!Auth::is_logged_in()) {
    Auth::print_login_msg();
}

$t = new Template(translate('My Calendar'));

// Print HTML headers
$t->printHTMLHeader();

// Print welcome box
$t->printWelcome();

// Begin main table
$t->startMain();

$type = isset($_GET['view']) ? $_GET['view'] : MYCALENDARTYPE_DAY;

$calendar = new MyCalendar(Auth::getCurrentID(), $type, get_calendar_actual_date());

$calendar->print_calendar();

// End main table
$t->endMain();

$timer->stop();
$timer->print_comment();

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