<?php
/**
* Functionality to send email reminders to users
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-26-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

require_once($basedir . '/lib/db/ReminderDB.class.php');

class Reminder
{
	var $db = null;
	
	var $id = null;
	var $memberid = null;
	var $resid = null;
	var $reminder_time = 0;
	
	// Values needed for emails
	var $start_time = 0;
	var $end_time = 0;
	var $start_date = 0;
	var $end_date = 0;
	var $resource_name = '';
	var $location = '';
	var $machid = '';
	var $email = '';	
	var $lang = '';	
	
	// Values needed for reservation
	var $minutes_prior = 0;

	function Reminder($id = null) {
		$this->id = $id;
	}
	
	/**
	* Sets the database connection to use
	* @param $db ReminderDB the initialized database connection
	*/
	function setDB(&$db) {
		$this->db =& $db;
	}
	
	/**
	* Gets an array of reminders populated with email values up to the given date
	* @param int $max_date a properly formatted reminder time
	* @return array list of Reminders with populated values needed for email notifications
	*/
	function getReminders($max_date) {
		return $this->db->getReminders($max_date);
	}
	
	/**
	* Delete a list of reminders from the database
	* @param array $reminder_ids list of reminder ids to delete
	*/
	function deleteReminders($reminder_ids = array()) {
		$this->db->deleteRecords(TBL_REMINDERS, 'reminderid', $reminder_ids);
	}
	
	/**
	* Delete a reminder by reservation id and member id
	* @param string $resid reservation id
	* @param string $memeberid member id
	*/
	function deleteReminder($resid, $memberid) {
		$this->db->deleteReminder($resid, $memberid);
	}
	
	/**
	* Populates and saves a reminder with needed database values for a reminder this many minutes before the reservation
	* @param Reservation $res the reservation that the reminder is for
	* @param int $number_of_minutes the number of minutes before the reservation to send the reminder
	*/
	function save(&$res, $number_of_minutes) {
		$this->resid = $res->id;
		$this->memberid = $res->user->userid;
		$this->reminder_time = $this->_calculateReminderTime($res->start_date, $res->start, $number_of_minutes);
		$this->db->save($this);
	}
	
	/**
	* Populates and updates a reminder with needed database values for a reminder this many minutes before the reservation
	* @param Reservation $res the reservation that the reminder is for
	* @param int $number_of_minutes the number of minutes before the reservation to send the reminder
	*/
	function update(&$res, $number_of_minutes) {
		if ($number_of_minutes == 0) {
			$this->deleteReminder($res->id, $res->user->userid);
		}
		$this->resid = $res->id;
		$this->memberid = $res->user->userid;
		$this->reminder_time = $this->_calculateReminderTime($res->start_date, $res->start, $number_of_minutes);
		$this->db->update($this);
	}
	
	/**
	* Gets the number of minutes prior to this reservation start date and time
	* @param Reservation $res the reservation to calculate the time for
	* @return returns the number of minutes prior to this reservation for this reminder
	*/
	function getMinutuesPrior(&$res) {
		if ($this->reminder_time == 0) {
			return 0;
		}
		
		$minutes = 0;
		$date_part = getdate($res->start_date);
		$res_datetime = mktime(($res->start/60), ($res->start%60), 0, $date_part['mon'], $date_part['mday'], $date_part['year']);
		
		$year = substr($this->reminder_time, 0, 4);
		$mon = substr($this->reminder_time, 4, 2);
		$day = substr($this->reminder_time, 6, 2);
		$hour = substr($this->reminder_time, 8, 2);
		$min = substr($this->reminder_time, 10, 2);
		$rem_datetime = mktime($hour, $min, 0, $mon, $day, $year);

		return ($res_datetime - $this->toDateTime()) / 60;
	}
	
	/**
	* Calcluates the reminder time on this start date and time
	* @param int $start_date the reservation start date
	* @param int $start_time the reservation start time
	* @param int $number_of_minutes before this reservation to get reminder time for
	* @return int the calculated reminder time
	*/
	function _calculateReminderTime($start_date, $start_time, $number_of_minutes) {
		$date_part = getdate($start_date);
		return date(REMINDER_DATE_FORMAT, mktime( ($start_time/60), (($start_time%60) - $number_of_minutes), 0, $date_part['mon'], $date_part['mday'], $date_part['year']));
	}
	
	/**
	* Returns UNIX timestamp representation of this reminder
	* @param none
	* @return int UNIX timestamp representation of this reminder
	*/
	function toDateTime() {
		$year = substr($this->reminder_time, 0, 4);
		$mon = substr($this->reminder_time, 4, 2);
		$day = substr($this->reminder_time, 6, 2);
		$hour = substr($this->reminder_time, 8, 2);
		$min = substr($this->reminder_time, 10, 2);
		return mktime($hour, $min, 0, $mon, $day, $year);
	}
	
	/**
	* Setter function for reminder_time
	* @param mixed the reminder_time value
	*/
	function set_reminder_time($time) {
		$this->reminder_time = empty($time) ? 0 : $time;
	}
}
?>