<?php
/**
* Statistics page
* Print out visual statistics of many different aspects
*  of the application
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-11-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Template.class.php');
include_once('lib/Stats.class.php');

$timer = new Timer();
$timer->start();

$stats = new Stats();

$t = new Template(translate('phpScheduleIt Statistics'));
$t->printHTMLHeader();

// Make sure this is the admin
if (!Auth::isAdmin()) {
    CmnFns::do_error_box(translate('This is only accessable to the administrator') . '<br />'
        . '<a href="ctrlpnl.php">' . translate('Back to My Control Panel') . '</a>');
}

$t->printWelcome();
$t->startMain();

$scheduleid = isset($_GET['scheduleid']) ? $_GET['scheduleid'] : null;

if (!$stats->set_schedule($scheduleid)) {
	$stats->print_schedule_error();
}
else {
	$stats->load_schedule();

	print_schedule_list($stats->get_schedule_list(), $stats->scheduleid);

	$stats->init();

	ob_start();		// There is a lot of HTML being printed, so buffer the output

	print_quick_stats($stats);

	print_system_stats($stats);

	$stats->set_stats(MONTH);
	$stats->print_stats();

	$stats->set_stats(DAY_OF_WEEK);
	$stats->print_stats();

	$stats->set_stats(DAY_OF_MONTH);
	$stats->print_stats();

	$stats->set_stats(STARTTIME);
	$stats->print_stats();

	$stats->set_stats(ENDTIME);
	$stats->print_stats();

	$stats->set_stats(RESOURCE);
	$stats->print_stats();

	$stats->set_stats(USER);
	$stats->print_stats();

	ob_end_flush();	// Print the buffered HTML to the browser
}
$t->endMain();

$timer->stop();
$timer->print_comment();

$t->printHTMLFooter();	// Print HTML footer

?>