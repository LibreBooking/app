<?php
/**
* ResDB class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-11-05
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
@define('BASE_DIR', dirname(__FILE__) . '/../..');
/**
* DBEngine class
*/
include_once('ResDB.class.php');

/**
* Provide all access to database to manage reservations
*/
class BlackoutDB extends ResDB {

	/**
	* Return all data about a given reservation
	* @param string $resid reservation id
	* @return array of all reservation data
	*/
	function get_blackout($blackoutid) {
		$return = array();
		
		$result = $this->db->getRow('SELECT * FROM ' . $this->get_table('reservations') . ' WHERE resid=?', array($blackoutid));
		$this->check_for_error($result);

		if (count($result) <= 0) {
			$this->err_msg = translate('That record could not be found.');
			return false;
		}

		return $this->cleanRow($result);
	}
	

	/**
	* Add a new reservation to the database
	* @param Object $res reservation that we are placing
	* @param boolean $is_parent if this is the parent reservation of a group of recurring reservations
	*/
	function add_blackout(&$blackout, $is_parent) {
		$id = $this->get_new_id();

		$values = array (
					$id,
					$blackout->get_machid(),
					$blackout->get_scheduleid(),
					$blackout->get_start_date(),
					$blackout->get_end_date(),
					$blackout->get_start(),
					$blackout->get_end(),
					mktime(),
					null,
					($is_parent ? $id : $blackout->get_parentid()),
					intval($blackout->is_blackout),
					$blackout->get_pending(),
					$blackout->get_summary()
				);
		
		$query = 'INSERT INTO ' . $this->get_table('reservations') . ' VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
		
		$values = array($id, $blackout->memberid, 1, 0, 1, 1, null);
		$query = 'INSERT INTO ' . $this->get_table('reservation_users') . ' VALUES(?,?,?,?,?,?,?)';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);

		unset($values, $query);
		return $id;
	}


	/**
	* Modify current reservation time
	* If this reservation is part of a recurring group, all reservations in the
	*  group will be modified that havent already passed
	* @param Object $res reservation that we are modifying
	*/
	function mod_blackout(&$blackout) {
		$values = array (
					$blackout->get_start_date(),
					$blackout->get_end_date(),
					$blackout->get_start(),
					$blackout->get_end(),
					mktime(),
					$blackout->get_summary(),
					$blackout->get_pending(),
					$blackout->get_id()
				);

		$query = 'UPDATE ' . $this->get_table('reservations')
                . ' SET '
				. ' start_date=?,'
				. ' end_date=?,'
				. ' starttime=?,'
                . ' endtime=?,'
                . ' modified=?,'
				. ' summary=?,'
				. ' is_pending=?'
                . ' WHERE resid=?';

		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}

	/**
	* Deletes a reservation from the database
	* If this reservation is part of a recurring group, all reservations
	*  in the group will be deleted that havent already passed
	* @param string $id reservation id
	* @param string $parentid id of parent reservation
	* @param boolean $del_recur whether to delete recurring reservations or not
	* @param int $date timestamp of current date
	*/
	function del_blackout($id, $parentid, $del_recur, $date) {
		$values = array($id);
		$sql = 'DELETE ru.*, r.*'
				. ' FROM ' . $this->get_table('reservation_users') . ' as ru, ' . $this->get_table('reservations') . ' as r'
				. ' WHERE ru.resid=r.resid AND ru.resid=?';

		if ($del_recur) {			// Delete all recurring reservations
			$sql .= ' OR ru.resid = r.parentid OR r.parentid = ? AND r.start_date >= ?';
			array_push($values, $parentid, $date);
		}
		$result = $this->db->query($sql, $values);
		$this->check_for_error($result);
	}
}
?>