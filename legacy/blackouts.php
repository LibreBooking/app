<?php
/**
* Blackout Scheduler Application
* Manage blackout times from this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-24-04
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
include_once('lib/Schedule.class.php');

$t = new Template(translate('Manage Blackout Times'));
$s = new Schedule((isset($_GET['scheduleid']) ? $_GET['scheduleid'] : null), BLACKOUT_ONLY);

// Print HTML headers
$t->printHTMLHeader();

// Check that the admin is logged in
if (!Auth::isAdmin()) {
    CmnFns::do_error_box(translate('This is only accessable to the administrator') . '<br />'
        . '<a href="ctrlpnl.php">' . translate('Back to My Control Panel') . '</a>');
}

// Print welcome box
$t->printWelcome();

// Begin main table
$t->startMain();

$s->print_schedule();

// Print out links to jump to new date
$s->print_jump_links();

// End main table
$t->endMain();

list($e_sec, $e_msec) = explode(' ', microtime());		// End execution timer
$tot = ((float)$e_sec + (float)$e_msec) - ((float)$s_sec + (float)$s_msec);
echo '<!--Schedule printout time: ' . sprintf('%.16f', $tot) . ' seconds-->';
// Print HTML footer
$t->printHTMLFooter();
?>