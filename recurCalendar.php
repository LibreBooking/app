<?php
/**
* Create a new Calendar object and print it
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-25-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Calendar class
*/
include_once('lib/Calendar.class.php');
/**
* Template class
*/
include_once('lib/Template.class.php');



$t = new Template(translate('Choose Date'));

$t->printHTMLHeader();
$t->startMain();
?>
<div align="center" style="margin: 0px; width: 100%;">
<?php
// Create Calendar
if (isset($_GET['m']) && isset($_GET['y'])) {
	$myCal = new Calendar(false, $_GET['m'], $_GET['y']);
	$myCal->javascript = "selectRecurDate(%d,%d,%d,%d);";
	// Print calendar
	$myCal->printCalendar();
	$myCal->printJumpForm();
}
else {
	$myCal = new Calendar(true);
	$myCal->javascript = "selectRecurDate(%d,%d,%d,%d);";
	$myCal->printCalendar();
}
?>
</div>
<?php
$t->endMain();
?>
	</body>
</html>