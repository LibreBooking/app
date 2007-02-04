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
include_once('lib/Group.class.php');
include_once('lib/User.class.php');
include_once('lib/Utility.class.php');
include_once('templates/usergroup.template.php');

$t = new Template(translate('Manage Groups'));

$t->printHTMLHeader();
$t->startMain();

if (!isset($_POST['submit'])) {
	$user = new User($_GET['memberid']);
	$cur_user = new User();
	$cur_user->userid = Auth::getCurrentID();
	
	if ( !Auth::isAdmin() && !$cur_user->is_group_admin($user->get_groupids()) ) {
		CmnFns::do_error_box(translate('This is only accessable to the administrator'));
		die();
	}
	
	print_edit((bool)$_GET['edit'] && Auth::isAdmin(), $user);
}
else {
	if ( !Auth::isAdmin() ) {
		CmnFns::do_error_box(translate('This is only accessable to the administrator'));
		die();
	}

	$to_add = isset($_POST['add_groups']) ? $_POST['add_groups'] : array();
	update_groups($_POST['memberid'], $to_add);
}

$t->endMain();
$t->printHTMLFooter();

/**
* Prints out the display/edit UI to add/remove groups for this user
* @param string $memberid id of the member to to change groups for
*/
function print_edit($edit, &$user) {
	$group = new Group(new GroupDB());
	
	$non_user_groups = $group->getGroups($user->get_id());
	$user_groups = $user->groups;
	
	begin_table($user->get_name());
	
	if ($edit) {
		print_groups_to_add($non_user_groups);		
		print_move_buttons();
		print_groups_to_remove($user_groups);
		print_save_button($user->get_id());
	}
	else {
		print_groups_to_view($user_groups);
	}
	
	end_table();
}

/**
* Update the groups for this user
* @param none
*/
function update_groups($memberid, $to_add) {
	$util = new Utility();
	
	$user = new User($memberid);
	$orig = array_keys($user->groups);
	
	$groups_to_add = $util->getAddedItems($orig, $to_add);
	$groups_to_remove = $util->getRemovedItems($orig, $to_add);
	
	$user->add_groups($groups_to_add);
	$user->remove_groups($groups_to_remove);
	
	close_window();
}
?>