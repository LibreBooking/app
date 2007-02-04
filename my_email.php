<?php
/**
* Manage email contacts from this page
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 09-22-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Template class
*/
include_once('lib/Template.class.php');
/**
* Template functions
*/
include_once('templates/my_email.template.php');

// Make sure user is logged in
if (!Auth::is_logged_in()) {
    Auth::print_login_msg();
}

$t = new Template(translate('Manage My Email Contacts'));

$user = new User($_SESSION['sessionID']);

$t->printHTMLHeader();
$t->printWelcome();
$t->startMain();

if (!isset($_POST['submit'])) {
	print_email_contacts($user);
}
else {
	manage_emails();
	print_success();
}

$t->endMain();
$t->printHTMLFooter();

/**
* Manages the user's email contacts
* @param none
*/
function manage_emails() {
	global $user;

	$user->set_emails($_POST['e_add'], $_POST['e_mod'], $_POST['e_del'], $_POST['e_app'], $_POST['e_html']);
}
?>