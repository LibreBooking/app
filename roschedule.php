<?php
/**
* Read only view of the schedule
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-25-04
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

$t = new Template(translate('Online Scheduler [Read-only Mode]'));
$s = new Schedule((isset($_GET['scheduleid']) ? $_GET['scheduleid'] : null), READ_ONLY);

// Print HTML headers
$t->printHTMLHeader();

CmnFns::do_message_box('<a href="index.php">' . translate('Login to view details and place reservations') . '</a>');

// Begin main table
$t->startMain();

$s->print_schedule();

// Print out links to jump to new date
$s->print_jump_links();

CmnFns::do_message_box('<a href="index.php">' . translate('Login to view details and place reservations') . '</a>');

// End main table
$t->endMain();

list($e_sec, $e_msec) = explode(' ', microtime());		// End execution timer
$tot = ((float)$e_sec + (float)$e_msec) - ((float)$s_sec + (float)$s_msec);
echo '<!--Schedule printout time: ' . sprintf('%.16f', $tot) . ' seconds-->';
// Print HTML footer
$t->printHTMLFooter();
?>