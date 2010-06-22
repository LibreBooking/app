<?php
/**
* View a printable signup sheet for a specific resource
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 01-24-05
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

// Print HTML headers
echo "<?xml version=\"1.0\" encoding=\"$charset\"?" . ">\n";
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $languages[$lang][2]?>" lang="<?php echo $languages[$lang][2]?>">
	<head>
	<title>
	<?php echo translate('Signup View')?>
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>" />
	<script language="JavaScript" type="text/javascript" src="functions.js"></script>
	<style type="text/css">
	@import url(css.css);
	</style>
	</head>
	<body>

<?php
$type = MYCALENDARTYPE_SIGNUP;
$machid = isset($_GET['machid']) ? $_GET['machid'] : null;

$calendar = new ResCalendar(Auth::getCurrentID(), $type, get_calendar_actual_date(), $machid);

$calendar->print_calendar();

list($e_sec, $e_msec) = explode(' ', microtime());		// End execution timer
$tot = ((float)$e_sec + (float)$e_msec) - ((float)$s_sec + (float)$s_msec);
echo '<!--Schedule printout time: ' . sprintf('%.16f', $tot) . ' seconds-->';
// Print HTML footer
?>
	<p align="center"><a href="http://phpscheduleit.sourceforge.net">phpScheduleIt v<?php echo $conf['app']['version']?></a></p>
	</body>
	</html>
<?php

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
		$date_split = explode('-', date('m-d-Y'));
	}
	
	return mktime(0,0,0, $date_split[0], $date_split[1], $date_split[2]);	
}
?>