<?php
/**
* Handles all database functions for reminders
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-26-06
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';

include_once($basedir . '/lib/DBEngine.class.php');

/**
* Provide all access to database to manage reservations
*/
class ReminderDB extends DBEngine {
	
	/**
	* Gets all reminders to load the reminders at or before the given datetime
	* @param int $max_date a date
	* @return array of data to load reservation objects
	*/
	function getReminders($max_date) {
		$return = array();
		
		$query = 'SELECT
					rs.resid, rs.starttime, rs.endtime, rs.start_date, rs.end_date,
					r.name, r.location, r.machid,
					l.email, l.memberid, l.lang,
					rem.reminderid
				FROM ' . $this->get_table(TBL_REMINDERS) . ' rem INNER JOIN '
				. $this->get_table(TBL_RESERVATIONS) . ' rs ON rem.resid = rs.resid INNER JOIN '
				. $this->get_table(TBL_RESOURCES) . ' r ON rs.machid = r.machid INNER JOIN '
				. $this->get_table(TBL_LOGIN) . ' l ON rem.memberid = l.memberid'
				. ' WHERE rem.reminder_time <= ?';

		$result = $this->db->query($query, array($max_date));
		$this->check_for_error($result);
		
		while ($rs = $result->fetchRow()) {
			$return[] = $this->_buildReminder($this->cleanRow($rs));
		}
		
		$result->free();	
		return $return;
	}
	
	/**
	* Saves a reminder to the database
	* @param Reminder $reminder the populated reminder object to save
	*/
	function save(&$reminder) {
		$reminder->id = $this->get_new_id();
		$values = array($reminder->id, $reminder->memberid, $reminder->resid, $reminder->reminder_time);
		$query = 'INSERT INTO ' . $this->get_table(TBL_REMINDERS) . ' VALUES (?,?,?,?)';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
	
	/**
	* Updates an existing reminder in the database
	* @param Reminder $reminder the populated reminder object to save
	*/
	function update(&$reminder) {
		$values = array($reminder->reminder_time, $reminder->memberid, $reminder->resid);
		$query = 'UPDATE ' . $this->get_table(TBL_REMINDERS) . ' SET reminder_time = ? WHERE memberid = ? AND resid = ?';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
	
	/**
	* Deletes an existing reminder from the database
	* @param string $memberid member id of the reminder owner
	* @param string $resid reservation id of the reminder owner
	*/
	function delete($memberid, $resid) {
		$values = array($memberid, $resid);
		$query = 'DELETE FROM ' . $this->get_table(TBL_REMINDERS) . ' WHERE memberid = ? AND resid = ?';
		$q = $this->db->prepare($query);
		$result = $this->db->execute($q, $values);
		$this->check_for_error($result);
	}
	
	/**
	* Builds a Reminder object from the database row
	* @param array $row row of data to populate the object with
	* @return populated Reminder object
	*/
	function _buildReminder($row) {
		$reminder = new Reminder();
		$reminder->id = $row['reminderid'];
		$reminder->resid = $row['resid'];
		$reminder->start_time = intval($row['starttime']);
		$reminder->end_time = intval($row['endtime']);
		$reminder->start_date = intval($row['start_date']);
		$reminder->end_date = intval($row['end_date']);
		$reminder->resource_name = $row['name'];
		$reminder->location = $row['location'];
		$reminder->machid = $row['machid'];
		$reminder->email = $row['email'];
		$reminder->memberid = $row['memberid'];
		$reminder->lang = $row['lang'];
		
		return $reminder;
	}
}
?>