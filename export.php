<?php
/**
* Interface form for managing user/group relationships
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-23-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Template.class.php');
include_once('templates/export.template.php');

$t = new Template(translate('Export'));

$t->printHTMLHeader();
$t->printWelcome();
$t->startMain();


print_export_table();
print_jscalendar_setup();

$t->endMain();
$t->printHTMLFooter();
?>