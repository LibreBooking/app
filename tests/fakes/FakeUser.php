<?php
@define('BASE_DIR', dirname(__FILE__) . '/..');
require_once(BASE_DIR . '/lib/User.class.php');

class FakeUser extends User
{
	var $userid = 'fakeid';
	var $email = 'test@email.com';
	var $fname = 'fake';
	var $lname = 'name';
	var $phone;
  	var $inst;
  	var $position;
	var $perms = null;
	var $emails;
	var $logon_name;
	var $is_admin;
	var $groups = null;
	var $lang;

	var $is_valid = false;
	var $err_msg = null;
	var $db;
	
	function FakeUser() {
	
	}
}
?>