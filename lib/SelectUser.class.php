<?php
/**
* SelectUser class
* Allow searching and selection of a user
* Perform user specified function when selected
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 07-08-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
@define('BASE_DIR', dirname(__FILE__) . '/..');
/**
* Include AdminDB class
*/
include_once('db/AdminDB.class.php');
/**
* Include SelectUser template files
*/
include_once(BASE_DIR . '/templates/selectuser.template.php');

class SelectUser {
	var $db;
	
	var $fname;
	var $lname;
	var $pager;
	var $users;
	
	var $javascript = '';
	
	/**
	* Sets up initial variable values
	*/
	function SelectUser($fname = '', $lname = '') {
		$orders = array('lname', 'fname', 'email');
		$this->db = new AdminDB();
		$this->pager = new Pager(0, 10);
		$this->pager->setViewLimitSelect(false);

		if (!empty($fname) || !empty($lname)) {
			$num = $this->db->get_num_user_recs($fname, $lname);
			$this->pager->setTotRecords($num);
			$this->users = $this->db->search_users($this->pager, $orders, $fname, $lname);	
		}
		else {
			$num = $this->db->get_num_admin_recs('login');	// Get number of records
			$this->pager->setTotRecords($num);					
			$this->users = $this->db->get_all_admin_data($this->pager, 'login', $orders, true);
		}
	}
	
	function printUserTable() {
		print_user_list($this->pager, $this->users, $this->db->get_err(), $this->javascript);
		$this->pager->text_style = 'font-size:11px;';
		$this->pager->printPages();
	}
}
?>