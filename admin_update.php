<?php
/**
* Provides interface for making all administrative database changes
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 05-07-06
* @package Admin
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/Template.class.php');
include_once('lib/Admin.class.php');
include_once('lib/User.class.php');

$fn = isset($_POST['fn']) ? $_POST['fn'] : (isset($_GET['fn']) ? $_GET['fn'] : '');	// Set function

$user = new User(Auth::getCurrentID());

if (!validate_function($user, $fn)) {
    CmnFns::do_error_box(translate('This is only accessable to the administrator') . '<br />'
        . '<a href="ctrlpnl.php">' . translate('Back to My Control Panel') . '</a>');
}

$db = new AdminDB();

$tools = array (
				'deleteUsers' => 'del_users',

				'addResource'	=> 'add_resource',
				'editResource'	=> 'edit_resource',
				'delResource'	=> 'del_resource',
				'togResource'	=> 'tog_resource',

				'editPerms' =>	'edit_perms',

				'resetPass' => 'reset_password',

				'addSchedule'	=> 'add_schedule',
				'editSchedule'	=> 'edit_schedule',
				'delSchedule'	=> 'del_schedule',
				'dfltSchedule'	=> 'set_default_schedule',

				'addAnnouncement'	=> 'add_announcement',
				'editAnnouncement'	=> 'edit_announcement',
				'delAnnouncement'	=> 'del_announcement',

				'adminToggle' => 'toggle_admin',

				'addAdditionalResource' => 'add_additional_resource',
				'editAdditionalResource' => 'edit_additional_resource',
				'delAddResource' => 'del_additional_resource',

				'addGroup' => 'add_group',
				'editGroup' => 'edit_group',
				'delGroup' => 'del_group',

				'addLocation' => 'add_location',
				'editLocation' => 'edit_location',
				'delLocation' => 'del_location'
				 );

if (!isset($tools[$fn]) && !isset($tools[$fn])) {		// Validate tool
	CmnFns::do_error_box(translate('Could not determine tool')
		. '<br/><a href="ctrlpnl.php">' . translate('Back to My Control Panel') . '</a>');
	die();
}
else {
	if (isset($tools[$fn])) {
		eval($tools[$fn] . '();');
	}
}


/**
* Return if the user can access the update page
* @param User $user the user to evaluate
* @param string $function the requested function
* @return if the user can access the update page
*/
function validate_function(&$user, $function) {
	if (Auth::isAdmin() || $user->is_admin()) {
		return true;
	}

	if ( $function == 'editPerms' || $function == 'resetPass' ) {
		return $user->is_group_admin();
	}

	return false;
}


/**
* Adds a schedule to the database
* @param none
*/
function add_schedule() {
	global $db;
	global $conf;

	$schedule = check_schedule_data(CmnFns::cleanPostVals());
	$id = $db->add_schedule($schedule);

	CmnFns::write_log('Schedule added. ' . $schedule['scheduletitle'], $_SESSION['sessionID']);
	print_success();
}

/**
* Edits schedule data
* @param none
*/
function edit_schedule() {
	global $db;

	$schedule = check_schedule_data(CmnFns::cleanPostVals());
	$db->edit_schedule($schedule);

	CmnFns::write_log('Schedule edited. ' . $schedule['scheduletitle'] . ' ' . $schedule['scheduleid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Deletes a list of resources
* @param none
*/
function del_schedule() {
	global $db;

	$scheduleid = $_POST['scheduleid'];

	// Make sure machids are checked
	if (empty($scheduleid))
		print_fail(translate('You did not select any schedules to delete.'));

	$db->del_schedule($scheduleid);
	CmnFns::write_log('Schedules deleted. ' . join(', ', $scheduleid), $_SESSION['sessionID']);
	print_success();
}

function set_default_schedule() {
	global $db;

	$db->set_default_schedule($_POST['scheduleid']);
	CmnFns::write_log('Default schedule changed to ' . $_POST['scheduleid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Adds an announcement to the database
* @param none
*/
function add_announcement() {
	global $db;
	global $conf;

	$announcement = check_announcement_data(CmnFns::cleanPostVals());
	$id = $db->add_announcement($announcement);

	CmnFns::write_log('Announcement added. ' . $announcement['announcement'], $_SESSION['sessionID']);
	print_success();
}

/**
* Edits announcement data
* @param none
*/
function edit_announcement() {
	global $db;

	$announcement = check_announcement_data(CmnFns::cleanPostVals());
	$db->edit_announcement($announcement);

	CmnFns::write_log('Announcement edited. ' . $announcement['announcement'] . ' ' . $announcement['announcementid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Deletes a list of announcements
* @param none
*/
function del_announcement() {
	global $db;

	$announcementid = $_POST['announcementid'];

	// Make sure machids are checked
	if (empty($announcementid))
		print_fail('You did not select any announcements to delete.');

	$db->del_announcement($announcementid);
	CmnFns::write_log('Announcements deleted. ' . join(', ', $announcementid), $_SESSION['sessionID']);
	print_success();
}

/**
* Deletes a list of users from the database
* @param none
*/
function del_users() {
	global $db;

	// Make sure memberids are checked
	if (empty($_POST['memberid']))
		print_fail(translate('You did not select any members to delete.') . '<br />');

	$db->del_users($_POST['memberid']);
	CmnFns::write_log('Users deleted. ' . join(', ', $_POST['memberid']), $_SESSION['sessionID']);
	print_success();
}

/**
* Adds a resource to the database
* @param none
*/
function add_resource() {
	global $db;
	global $conf;

	$resource = check_resource_data(CmnFns::cleanPostVals());
	$id = $db->add_resource($resource);

	if (isset($resource['autoassign']))		// Automatically give all users permission to reserve this resource
		$db->autoassign($id);

	CmnFns::write_log('Resource added. ' . $resource['name'], $_SESSION['sessionID']);
	print_success();
}

/**
* Edits resource data
* @param none
*/
function edit_resource() {
	global $db;

	$resource = check_resource_data(CmnFns::cleanPostVals());
	$db->edit_resource($resource);

	if (isset($resource['autoassign']))		// Automatically give all users permission to reserve this resource
		$db->autoassign($resource['machid']);

	CmnFns::write_log('Resource edited. ' . $resource['name'] . ' ' . $resource['machid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Deletes a list of resources
* @param none
*/
function del_resource() {
	global $db;

	// Make sure machids are checked
	if (empty($_POST['machid']))
		print_fail(translate('You did not select any resources to delete.'));

	$db->del_resource($_POST['machid']);
	CmnFns::write_log('Resources deleted. ' . join(', ', $_POST['machid']), $_SESSION['sessionID']);
	print_success();
}

/**
* Adds a location to the database
* @param none
*/
function add_location() {
	global $db;
	global $conf;

	$location = check_location_data(CmnFns::cleanPostVals());
	$id = $db->add_location($location);

	CmnFns::write_log('Location added. ' . $location['street1'], $_SESSION['sessionID']);
	print_success();
}

/**
* Edits location data
* @param none
*/
function edit_location() {
	global $db;

	$location = check_location_data(CmnFns::cleanPostVals());
	$db->edit_location($location);

	CmnFns::write_log('Location edited. ' . $location['name'] . ' ' . $location['machid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Deletes a list of locations
* @param none
*/
function del_location() {
	global $db;

	// Make sure machids are checked
	if (empty($_POST['locid']))
		print_fail(translate('You did not select any locations to delete.'));

	$db->del_location($_POST['locid']);
	CmnFns::write_log('Locations deleted. ' . join(', ', $_POST['locid']), $_SESSION['sessionID']);
	print_success();
}

/**
* Toggles a resource active/inactive
* @param none
*/
function tog_resource() {
	global $db;

	$db->tog_resource($_GET['machid'], $_GET['status']);
	CmnFns::write_log('Resource ' . $_GET['machid'] . ' toggled on/off.', $_SESSION['sessionID']);
	print_success();
}

/**
* Edit user permissions for what resources they can reserve
* @param none
*/
function edit_perms() {
	global $db;

	$db->clear_perms($_POST['memberid']);
	$db->set_perms($_POST['memberid'], isset($_POST['machid']) ? $_POST['machid'] : array());
	CmnFns::write_log('Permissions changed for user ' . $_POST['memberid'], $_SESSION['sessionID']);

	if (isset($_POST['notify_user']))
		send_perms_email($_POST['memberid']);

	print_success();
}

/**
* Sends a notification email to the user that thier permissions have been updated
* @param string $memberid id of member
* @param array $machids array of resource ids that the user now has permission on
*/
function send_perms_email($memberid) {
	global $conf;

	$adminemail = $conf['app']['adminEmail'];
	$appTitle = $conf['app']['title'];

	$user = new User($memberid);
	$perms = $user->get_perms();

	$subject = $appTitle . ' ' . translate('Permissions Updated');
	$msg = $user->get_fname() . ",\r\n"
			. translate('Your permissions have been updated', array($appTitle)) . "\r\n\r\n";
	$msg .= (empty($perms)) ? translate('You now do not have permission to use any resources.') . "\r\n" : translate('You now have permission to use the following resources') . "\r\n";
	foreach ($perms as $val)
		$msg .= $val . "\r\n";	// Add each resource name

	$msg .= "\r\n" . translate('Please contact with any questions.', array($adminemail));

	$mailer = new PHPMailer();
	$mailer->AddAddress($user->get_email(), $user->get_name());
	$mailer->From = $adminemail;
	$mailer->FromName = $conf['app']['title'];
	$mailer->Subject = $subject;
	$mailer->Body = $msg;
	$mailer->Send();
}

/**
* Reset the password for a user
* @param none
*/
function reset_password() {
	global $db;
	global $conf;

	$data = CmnFns::cleanPostVals();

	$password = empty( $data['password'] ) ? $conf['app']['defaultPassword'] : stripslashes($data['password']);
	$db->reset_password($data['memberid'], $password);

	if (isset($data['notify_user']))
		send_pwdreset_email($data['memberid'], $password);

	CmnFns::write_log('Password reset by admin for user ' . $_POST['memberid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Send a notification email that the password has been reset
* @param string $memberid id of member
* @param string $password new password for user
*/
function send_pwdreset_email($memberid, $password) {
	global $conf;

	$adminemail = $conf['app']['adminEmail'];
	$appTitle = $conf['app']['title'];

	$user = new User($memberid);

	$subject = $appTitle . ' ' . translate('Password Reset');
	$msg = $user->get_fname() . ",\r\n"
			. translate_email('password_reset', $appTitle, $password, $appTitle, CmnFns::getScriptURL(), $adminemail);

	$mailer = new PHPMailer();
	$mailer->AddAddress($user->get_email(), $user->get_name());
	$mailer->From = $adminemail;
	$mailer->FromName = $conf['app']['title'];
	$mailer->Subject = $subject;
	$mailer->Body = $msg;
	$mailer->Send();
}

/**
* Changes a users 'is_admin' status to give or take away admin privleges
* @param none
*/
function toggle_admin() {
	global $db;

	$is_admin = 0;

	if (isset($_GET['status']) && $_GET['status'] == 1) { $is_admin = 1; }

	$db->change_admin_status($_GET['memberid'], $is_admin);

	CmnFns::write_log('Admin status chagned for user: ' . $_GET['memberid'], $_SESSION['sessionID']);
	print_success();
}

/**
* Adds a new record to the additional_resources table, if valid data
* @param none
*/
function add_additional_resource() {
	global $db;

	$data = check_additional_resource_data(CmnFns::cleanPostVals());
	$id = $db->add_additional_resource($data['name'], $data['number_available']);
	print_success();
}

/**
* Updates an existing additional_resource record, if valid data
* @param none
*/
function edit_additional_resource() {
	global $db;

	$data = check_additional_resource_data(CmnFns::cleanPostVals());
	$db->edit_additional_resource($data['resourceid'], $data['name'], $data['number_available']);
	print_success();
}

/**
* Deletes a list of additional resources
* @param none
*/
function del_additional_resource() {
	global $db;

	// Make sure machids are checked
	if (empty($_POST['resourceid']))
		print_fail(translate('You did not select anything to delete.'));

	$db->del_additional_resource($_POST['resourceid']);
	print_success();
}

/**
* Adds a new group to the database
* @param none
*/
function add_group() {
	global $db;

	$data = check_group_data(CmnFns::cleanPostVals());
	$db->add_group($data['group_name']);
	print_success();
}

/**
* Edits an existing group in the database and sets the admin
* @param none
*/
function edit_group() {
	global $db;

	$data = check_group_data(CmnFns::cleanPostVals());
	$db->edit_group($data['groupid'], $data['group_name'], $data['group_admin']);
	print_success();
}

/**
* Deletes a list of groups from the database and removes the user associations
* @param none
*/
function del_group() {
	global $db;

	// Make sure machids are checked
	if (empty($_POST['groupid']))
		print_fail(translate('You did not select anything to delete.'));

	$db->del_group($_POST['groupid']);
	print_success();
}

/// VALIDATAION ///

/**
* Validates schedule data
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_schedule_data($data) {
	$rs = array();
	$msg = array();

	if (empty($data['scheduletitle']))
		array_push($msg, translate('Schedule title is required.'));
	else
		$rs['scheduletitle'] = $data['scheduletitle'];

	if (intval($data['daystart']) >= intval($data['dayend']))
		array_push($msg, translate('Invalid start/end times'));
	else {
		$rs['daystart']	= intval($data['daystart']);
		$rs['dayend']	= intval($data['dayend']);
	}

	$rs['weekdaystart']	= intval($data['weekdaystart']);
	$rs['timespan'] = intval($data['timespan']);
	$rs['ishidden'] = intval($data['ishidden']);
	$rs['showsummary'] = intval($data['showsummary']);

	if (empty($data['viewdays']) || $data['viewdays'] <= 0)
		array_push($msg, translate('View days is required'));
	else
		$rs['viewdays'] = intval($data['viewdays']);

	if (empty($data['adminemail']))
		array_push($msg, translate('Admin email is required'));
	else
		$rs['adminemail']	= $data['adminemail'];

	if (isset($data['scheduleid']))
		$rs['scheduleid'] = $data['scheduleid'];

	if (!empty($msg))
		print_fail($msg, $data);

	return $rs;
}

/**
* Validates announcement data
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_announcement_data($data) {
	$rs = array();
	$msg = array();

	if (empty($data['announcement']))
		array_push($msg, translate('Announcement text is required.'));
	else
		$rs['announcement'] = $data['announcement'];

	if (empty($data['number']) || !is_numeric($data['number']) || $data['number'] < 0)
		array_push($msg, translate('Announcement number is required.'));
	else
		$rs['number'] = intval($data['number']);

	if (isset($data['announcementid']))
		$rs['announcementid'] = $data['announcementid'];

	$start_hour = $end_hour = $start_minute = $end_minute = 0;
	if (isset($data['use_start_time'])) {
		// Validate the starting hour
		if (!isset($data['start_hour']) || empty($data['start_hour']) || intval($data['start_hour']) < 0 || (intval($data['start_hour']) == 12 && $data['start_ampm'] == 'am')) {
			$start_hour = 0;
		}
		else if (intval($data['start_hour']) > 23) {
			$start_hour = 23;
		}
		else if (intval($data['start_hour']) < 12 && $data['start_ampm'] == 'pm') {
			$start_hour = intval($data['start_hour']) + 12;
		}
		else {
			$start_hour = intval($data['start_hour']);
		}
		// Validate the starting minute
		if (!isset($data['start_min']) || empty($data['start_min']) || intval($data['start_min']) < 0) {
			$start_minute = 0;
		}
		else if (intval($data['start_min']) > 59) {
			$start_minute = 59;
		}
		else {
			$start_minute = intval($data['start_min']);
		}
	}
	if (isset($data['use_end_time'])) {
		// Validate the ending hour
		if (!isset($data['end_hour']) || empty($data['end_hour']) || intval($data['end_hour']) < 0 || (intval($data['end_hour']) == 12 && $data['end_ampm'] == 'am')) {
			$end_hour = 0;
		}
		else if (intval($data['end_hour']) > 23) {
			$end_hour = 23;
		}
		else if (intval($data['end_hour']) < 12 && $data['end_ampm'] == 'pm') {
			$end_hour = intval($data['end_hour']) + 12;
		}
		else {
			$end_hour = intval($data['end_hour']);
		}
		// Validate the ending minute
		if (!isset($data['end_min']) || empty($data['end_min']) || intval($data['end_min']) < 0) {
			$end_minute = 0;
		}
		else if (intval($data['end_min']) > 59) {
			$end_minute = 59;
		}
		else {
			$end_minute = intval($data['end_min']);
		}
	}

	// Complete the starting/ending time values
	if (isset($data['use_start_time'])) {
		$start_date_vals = split(INTERNAL_DATE_SEPERATOR, $data['start_date']);
		$starting_time = mktime($start_hour, $start_minute, 0, $start_date_vals[0], $start_date_vals[1], $start_date_vals[2]);
	}
	else {
		$starting_time = null;
	}
	if (isset($data['use_end_time'])) {
		$end_date_vals = split(INTERNAL_DATE_SEPERATOR, $data['end_date']);
		$ending_time = mktime($end_hour, $end_minute, 0, $end_date_vals[0], $end_date_vals[1], $end_date_vals[2]);
	}
	else {
		$ending_time = null;
	}

	$rs['start_datetime'] = $starting_time;
	$rs['end_datetime'] = $ending_time;

	if (!empty($msg))
		print_fail($msg, $data);

	return $rs;
}

/**
* Validates resource data
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_resource_data($data) {
	$rs = array();
	$msg = array();

	if (isset($data['allow_multi'])) {
		$minres = 0;
		$maxRes = 1440;
	}
	else {
		$minres = intval($data['minH'] * 60 + $data['minM']);
		$maxRes = intval($data['maxH'] * 60 + $data['maxM']);
	}
	$data['minres']	= $minres;
	$data['maxres']	= $maxRes;

	if (empty($data['name'])) {
		$msg[] = translate('Resource name is required.');
	}
	else {
		$rs['name'] = $data['name'];
	}

	if (empty($data['scheduleid'])) {
		$msg[] = translate('Valid schedule must be selected');
	}
	else {
		$rs['scheduleid'] = $data['scheduleid'];
	}

	if (intval($minres) > intval($maxRes)) {
		$msg[] = translate('Minimum reservation length must be less than or equal to maximum reservation length.');
	}
	else {
		$rs['minres']	= $minres;
		$rs['maxres']	= $maxRes;
	}

	$rs['rphone']	= $data['rphone'];
	if (empty($data['locid'])) {
		$rs['locid'] = 0;
	}
	else {
		$rs['locid'] = $data['locid'];
	}
	$rs['notes']	= $data['notes'];

	if (isset($data['autoassign'])) {
		$rs['autoassign'] = $data['autoassign'];
	}

    if (isset($data['approval'])) {
		$rs['approval'] = $data['approval'];
	}

	if (isset($data['allow_multi'])) {
		$rs['allow_multi'] = $data['allow_multi'];
	}

	if (isset($data['machid'])) {
		$rs['machid'] = $data['machid'];
	}

	if ($data['max_participants'] != '') {
		$rs['max_participants'] = abs(intval($data['max_participants']));
	}
	else {
		$rs['max_participants'] = null;
	}

	if (trim($data['min_notice_time']) != '') {
		$rs['min_notice_time'] = abs(intval($data['min_notice_time']));
	}
	else {
		$msg[] = translate('Minimum booking notice is required.');
	}

	if (trim($data['max_notice_time']) != '') {
		$rs['max_notice_time'] = abs(intval($data['max_notice_time']));
	}
	else {
		$msg[] = translate('Maximum booking notice is required.');
	}

	if (!empty($msg)) {
		print_fail($msg, $data);
	}

	return $rs;
}

/**
* Validates location data
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_location_data($data) {
	$rs = array();
	$msg = array();

	if (empty($data['street1'])) {
		$msg[] = translate('Street1 value is required.');
	}
	else {
		$rs['street1'] = $data['street1'];
	}

	$rs['street2']	= $data['street2'];
	$rs['city']	= $data['city'];
	$rs['state']	= $data['state'];
	$rs['zip']	= $data['zip'];
	$rs['country']	= $data['country'];

	if (isset($data['locid'])) {
		$rs['locid'] = $data['locid'];
	}

	if (!empty($msg)) {
		print_fail($msg, $data);
	}

	return $rs;
}

/**
* Ensures that the additional resource data is valid
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_additional_resource_data($data) {
	$rs = array();
	$msg = array();

	if (empty($data['name']))
		array_push($msg, translate('Resource name is required.'));
	else
		$rs['name'] = $data['name'];

	if ($data['number_available'] != '') {
		$rs['number_available'] = abs(intval($data['number_available']));
	}
	else {
		$rs['number_available'] = -1;
	}

	if (isset($data['resourceid']))
		$rs['resourceid'] = $data['resourceid'];

	if (!empty($msg)) {
		print_fail($msg, $data);
	}

	return $rs;
}

/**
* Ensures that the group data is valid
* Throws an error if it is not valid
* @param array $data array of data to validate
* @return validated data
*/
function check_group_data($data) {
	$rs = array();
	$msg = array();

	if (empty($data['group_name']))
		array_push($msg, translate('Group name is required.'));
	else
		$rs['group_name'] = $data['group_name'];

	$rs['group_admin'] = $data['group_admin'];

	if (isset($data['groupid'])) {
		$rs['groupid'] = $data['groupid'];
	}

	if (!empty($msg)) {
		print_fail($msg, $data);
	}

	return $rs;
}

/// END VALIDATION ///

/**
* Prints a page with a message notifying the admin of a successful update
* @param none
*/
function print_success() {
	// Get the name/value of anything that was currently being edited
	// This will then be flitered out of the link back so that item will not show up in the edit box
	$return = (!empty($_POST['get'])) ? preg_replace('/&' . $_POST['get'] . '=[\d\w]*/', '', $_SERVER['HTTP_REFERER']) : $_SERVER['HTTP_REFERER'];
	header("Refresh: 2; URL=$return");		// Auto send back after 2 seconds
	$t = new Template(translate('Successful update'));
	$t->printHTMLHeader();
	$t->printWelcome();
	$t->startMain();
	CmnFns::do_message_box(translate('Your request was processed successfully.') . '<br />'
				. '<a href="' . $return. '">' . translate('Go back to system administration') . '</a><br />'
				. translate('Or wait to be automatically redirected there.'));
	$t->endMain();
	$t->printHTMLFooter();
	die;
}


/**
* Prints a page notifiying the admin that the requirest failed.
* It will also assign the data passed in to a session variable
*  so it can be reinserted into the form that it came from
* @param string or array $msg message(s) to print to user
* @param array $data array of data to post back into the form
*/
function print_fail($msg, $data = null) {
	if (!is_array($msg))
		$msg = array ($msg);

	if (!empty($data)) {
		$_SESSION['post'] = $data;
	}

	$t = new Template(translate('Update failed!'));
	$t->printHTMLHeader();
	$t->printWelcome();
	$t->startMain();
	CmnFns::do_error_box(translate('There were problems processing your request.') . '<br /><br />'
			. '- ' . join('<br />- ', $msg) . '<br />'
			. '<br /><a href="' . $_SERVER['HTTP_REFERER'] . '">' . translate('Please go back and correct any errors.') . '</a>');
	$t->endMain();
	$t->printHTMLFooter();
	die;
}
?>