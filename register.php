<?php
/**
* This file prints out a registration or edit profile form
* It will fill in fields if they are available (editing)
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-30-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Include Template class
*/
include_once('lib/Template.class.php');

// Auth included in Template.php
$auth = new Auth();
$t = new Template();
$curUser = new User(Auth::getCurrentID());

$edit = isset($_GET['edit']) && (bool)$_GET['edit'];
$id = null;

if ( isset($_GET['memberid']) && !empty($_GET['memberid']) ) {
	$id = $_GET['memberid'];
}

if ( isset($_SESSION['sessionID']) && !empty($_SESSION['sessionID']) ) {
	if ($id == null) {
		// No id was passed in, so use the current user's id
		$id = $_SESSION['sessionID'];
	}
}

$msg = '';
$show_form = true;

// Check login status
if ($edit && !Auth::is_logged_in()) {
	$auth->print_login_msg(true);
	$auth->clean();			// Clean out any lingering sessions
}
else if ( !$edit && !(bool)$conf['app']['allowSelfRegistration'] ) {
	$isAdmin = ($curUser->is_group_admin(array($id)) || Auth::isAdmin());
	if ( !$isAdmin ) {
		// Only the administrator can create users
		CmnFns::do_error_box(translate('This is only accessable to the administrator'), '', true);
	}
}

// If we are editing and have not yet submitted an update
if ($edit && !isset($_POST['update'])) {
	$user = new User($id);
	$data = $user->get_user_data();
	$data['emailaddress'] = $data['email'];		// Needed to be the same as the form
}
else {
	$data = CmnFns::cleanPostVals();
}

if (isset($_POST['register'])) {	// New registration
	$data['lang'] = determine_language();
	$adminCreated = (Auth::is_logged_in() && Auth::isAdmin());
	$msg = $auth->do_register_user($data, $adminCreated);
	$show_form = false;
}
else if (isset($_POST['update'])) {	// Update registration
	$adminUpdate = ( ($curUser->get_id() != $id) && (Auth::isAdmin() || $curUser->is_group_admin(array($id))) );
	$msg = $auth->do_edit_user($data, $adminUpdate);
	$show_form = false;
}

// Print HTML headers
$t->printHTMLHeader();

$t->set_title(($edit) ? translate('Modify My Profile') : translate('Register'));

// Print the welcome banner if they are logged in
if ($edit || !(bool)$conf['app']['allowSelfRegistration'])
	$t->printWelcome();

// Begin main table
$t->startMain();

// Either this is a fresh view or there was an error, so show the form
if ($show_form || $msg != '') {
	if (!isset($data['timezone'])) { $data['timezone'] = $conf['app']['timezone']; }
	$auth->print_register_form($edit, $data, $msg, $id);
}

// The registration/edit went fine, print the message
if ($msg == '' && $show_form == false) {
	$auth->print_success_box();
}

// End main table
$t->endMain();

// Print HTML footer
$t->printHTMLFooter();
?>