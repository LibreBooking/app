<?php
/**
* AuthDB class
* Provides all login and registration functionality
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 03-30-06
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
include_once($basedir . '/lib/DBEngine.class.php');

/**
* Provide all database access/manipulation functionality
* @see DBEngine
*/
class AuthDB extends DBEngine {

	/**
	* Returns whether a user exists or not
	* @param string $email users email address
	* @param bool $use_logonname if we are using a logonname instead of the email address for logon
	* @return user's id or false if user does not exist
	*/
	function userExists($uname, $use_logonname = false) {
		$data = array (strtolower($uname));
		if ($use_logonname) {
			// Can be logonname or email address
			$where = '(email=? OR logon_name=?)';
			$data[] = $data[0];
		}
		else {
			// Can only be email address
			$where = '(email=?)';
		}
		$email_or_login = ($use_logonname) ? 'logon_name' : 'email';
		$result = $this->db->getRow('SELECT memberid FROM ' . $this->get_table('login') . " WHERE $where", $data);
		$this->check_for_error($result);

		return (!empty($result['memberid'])) ? $result['memberid'] : false;
	}

	/**
	* Returns whether the password associated with this username
	*  is correct or not
	* @param string $uname user name
	* @param string $pass password
	* @param bool $use_logonname if we are using a logonname instead of the email address for logon
	* @return whether password is correct or not
	*/
	function isPassword($uname, $pass, $use_logonname = false) {
		$password = $this->make_password($pass);
		$data = array (strtolower($uname), strtolower($uname), $password);
		//$email_or_login = ($use_logonname) ? 'logon_name' : 'email';
		$result = $this->db->getRow('SELECT count(*) as num FROM ' . $this->get_table('login') . " WHERE (email=? OR logon_name=?) AND password=?", $data);
		$this->check_for_error($result);

		return ($result['num'] > 0 );
	}

	/**
	* Inserts a new user into the database
	* @param array $data user information to insert
	* @return new users id
	*/
	function insertMember($data) {
		$id = $this->get_new_id();

		// Put data into a properly formatted array for insertion
		$to_insert = array();
		array_push($to_insert, $id);
		array_push($to_insert, strtolower($data['emailaddress']));
		array_push($to_insert, $this->make_password($data['password']));
		array_push($to_insert, $data['fname']);
		array_push($to_insert, $data['lname']);
		array_push($to_insert, $data['phone']);
		array_push($to_insert, $data['institution']);
		array_push($to_insert, $data['position']);
		array_push($to_insert, 'y');
		array_push($to_insert, 'y');
		array_push($to_insert, 'y');
		array_push($to_insert, 'y');
		array_push($to_insert, 'n');
		array_push($to_insert, isset($data['logon_name']) ? $data['logon_name'] : null);	// Push the logon name if we are using it
		array_push($to_insert, 0);	// is_admin
		array_push($to_insert, $data['lang']);
		array_push($to_insert, $data['timezone']);

		$q = $this->db->prepare('INSERT INTO ' . $this->get_table('login') . ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$result = $this->db->execute($q, $to_insert);
		$this->check_for_error($result);

		return $id;
	}

	/**
	* Updates user data
	* @param string $userid id of user to update
	* @param array $data array of new data
	*/
	function update_user($userid, $data) {
		$to_insert = array();

		array_push($to_insert, strtolower($data['emailaddress']));
		array_push($to_insert, $data['fname']);
		array_push($to_insert, $data['lname']);
		array_push($to_insert, $data['phone']);
		array_push($to_insert, $data['institution']);
		array_push($to_insert, $data['position']);
		array_push($to_insert, isset($data['logon_name']) ? $data['logon_name'] : null);	// Push the logon name if we are using it
		array_push($to_insert, $data['timezone']);

		$sql = 'UPDATE ' . $this->get_table('login')
			. ' SET email=?,'
			. ' fname=?,'
			. ' lname=?,'
			. ' phone=?,'
			. ' institution=?,'
			. ' position=?,'
			. ' logon_name=?,'
			. ' timezone=?';

		if (isset($data['password']) && !empty($data['password'])) {	// If they are changing passwords
			$sql .= ', password=?';
			array_push($to_insert, $this->make_password($data['password']));
		}

		array_push($to_insert, $userid);

		$sql .= ' WHERE memberid=?';

		$q = $this->db->prepare($sql);
		$result = $this->db->execute($q, $to_insert);
		$this->check_for_error($result);
	}


    /**
	* Checks to see if User information in DB is synched with LDAP Info
	* @param string $id user to check
	* @param array $ldap array of user's LDAP information
	* @author FCCC
	*/
	function check_updates( $id, $ldap ) {

		$result = $this->db->getRow('SELECT email, fname, lname, phone FROM ' . $this->get_table('login') . ' WHERE memberid=?', array($id));
		$this->check_for_error($result);

        if( $result['email'] != $ldap['emailaddress'] ) {
			return true;
		}
		else if( $result['fname'] != $ldap['fname'] ) {
            return true;
       	}
		else if( $result['lname'] != $ldap['lname'] ) {
           return true;
       	}
		else if( $result['phone'] != $ldap['phone'] ) {
			return true;
        }

        return false;
	}

	/**
	* Checks to make sure the user has a valid ID stored in a cookie
	* @param string $id id to check
	* @return whether the id is valid
	*/
	function verifyID($id) {
		$result = $this->db->getRow('SELECT count(*) as num FROM ' . $this->get_table('login') . ' WHERE memberid=?', array($id));
		$this->check_for_error($result);

		return ($result['num'] > 0 );
	}

	/**
	* Gives full resource permissions to a user upon registration
	* @param string $id id of user to auto assign
	*/
	function autoassign($id) {
		$sql = 'INSERT INTO ' . $this->get_table('permission') . ' (memberid, machid) SELECT "' . $id . '", machid FROM ' . $this->get_table('resources') . ' WHERE autoassign=1';

		$q = $this->db->prepare($sql);
		$result = $this->db->execute($q);
		$this->check_for_error($result);
	}
}
?>