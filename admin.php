<?php
/**
* This file provides the interface for all administrative tasks
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-23-06
* @package Admin
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Template.class.php');
include_once('lib/Admin.class.php');

$admin = new Admin(trim($_GET['tool']));
$admin->user = new User(Auth::getCurrentID());
if (!$admin->user->get_isadmin()) { $admin->user->is_admin = Auth::isAdmin(); }

$t = new Template(translate('System Administration'));

$t->printHTMLHeader();

// Make sure this is the admin
if (!$admin->isUserAllowed()) {
    CmnFns::do_error_box(translate('This is only accessable to the administrator') . '<br />'
        . '<a href="ctrlpnl.php">' . translate('Back to My Control Panel') . '</a>');
}

$t->printWelcome();
$t->startMain();

if (!$admin->is_error()) {
	$admin->execute();
}
else {
	CmnFns::do_error_box($admin->get_error_msg());
}

$t->endMain();
$t->printHTMLFooter();
?>