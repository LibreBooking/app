<?php
/**
* MyCalendar class
* This file contians the API functions for displaying
*  reservation data in a particular format for a resource
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 04-08-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
@define('BASE_DIR', dirname(__FILE__) . '/..');

include_once('MyCalendar.class.php');
include_once('db/ResCalendarDB.class.php');
include_once(BASE_DIR . '/templates/rescalendar.template.php');

class ResCalendar extends MyCalendar {
	var $machid;
	var $scheduleid;
	var $type;
	var $resources;
	var $schedules;
	
	var $starttime;
	var $endtime;
	var $timespan;
	
	var $name;
	var $isresource;
	
	/**
	* Sets up initial variable values
	* @param string $userid id of the calendar user
	* @param int MyCalendarType type for this calendar
	* @param int $actualDate todays date
	*/
	function ResCalendar($userid = null, $type = null, $actualDate = null, $machid = null, $scheduleid = null) {
		$this->machid = $machid;
		$this->scheduleid = $scheduleid;

		$this->db = new ResCalendarDB();
		parent::MyCalendar($userid, $type, $actualDate, false);
		
		$this->resources = $this->db->get_resources();		// Used to provide a pull down to change resources
		$this->schedules = $this->db->get_schedules();		// Used in resource pull down and to determine start/end/interval times
		
		if ($this->machid == null && $this->scheduleid == null) {
			$this->scheduleid = $this->resources[0]['scheduleid'];
		}
		$this->isresource = ($this->scheduleid == null);
		
		if ($this->isresource && $this->machid == null) {
			$this->machid = $this->resources[0]['machid'];	// If we dont have a machid from the querystring, take the first one in the list
			$this->scheduleid = $this->resources[0]['scheduleid'];
		}
		else if (!$this->isresource && $this->scheduleid == null) {
			$this->scheduleid = $this->schedules[0]['scheduleid'];
		}
		else if ($this->isresource && $this->machid != null) {
			// Set the scheduleid for this machid
			for ($i = 0; $i < count($this->resources); $i++) {
				if ($this->resources[$i]['machid'] == $this->machid) {
					$this->scheduleid = $this->resources[$i]['scheduleid'];
					$this->name = $this->resources[$i]['name'];
					break;
				}
			}
		}
		else if (!$this->isresource && $this->scheduleid != null) {
			for ($i = 0; $i < count($this->schedules); $i++) {
				if ($this->schedules[$i]['scheduleid'] == $this->scheduleid) {
					$this->name = $this->schedules[$i]['scheduletitle'];
					break;
				}
			}
		}
		
		if ($this->type !=  MYCALENDARTYPE_MONTH) {
			// Set the schedule properties (only needed for the day/week views
			for ($i = 0; $i < count($this->schedules); $i++) {
				if ($this->schedules[$i]['scheduleid'] == $this->scheduleid) {
					$this->starttime = $this->schedules[$i]['daystart'];
					$this->endtime   = $this->schedules[$i]['dayend'];
					$this->timespan  = $this->schedules[$i]['timespan'];
					break;
				}
			}
		}
		
		$this->load_reservations();
	}
	
	/**
	* Calls the appropriate function to load the reservations fitting this calendar data
	* @param none
	*/
	function load_reservations() {		
		global $conf;
		$firstResDate = $this->firstDate;
		$lastResDate = $this->lastDate;
		if ($this->type == MYCALENDARTYPE_MONTH) {
			$datestamp = $this->firstDate;
			$date_vars = explode(' ',date('d m Y t w W',$datestamp));
			$last_month_num_days = date('t', mktime(0,0,0, $date_vars[1]-1, $date_vars[0], $date_vars[2]));
			$week_start = $conf['app']['calFirstDay'];
			$firstWeekDay = (7 + (date('w', $datestamp) - $week_start)) % 7;
			$lastWeekDay = date('w',$this->lastDate) + 1;
			$firstResDate = mktime(0,0,0, $date_vars[1]-1, ($last_month_num_days - $firstWeekDay) + 1, $date_vars[2]);
			$lastResDate = mktime(0,0,0, $date_vars[1]+1, (7 + $week_start - $lastWeekDay) % 7, $date_vars[2]);
		}
		
		$this->reservations = $this->db->get_all_reservations($firstResDate - SECONDS_IN_DAY, $lastResDate + SECONDS_IN_DAY, (($this->isresource) ? $this->machid : $this->scheduleid), $this->isresource, $firstResDate, $lastResDate);	
	}
	
	/**
	* Prints the given calendar out based on type
	* @param none
	*/
	function print_calendar() {
		global $conf;
		
		$is_private = $conf['app']['privacyMode'] && !Auth::isAdmin();
		
		if ($this->type != MYCALENDARTYPE_SIGNUP) {
		
			$paramname = $this->isresource ? 'machid' : 'scheduleid';
			$paramvalue = $this->isresource ? $this->machid : $this->scheduleid;
			$prefix = $this->isresource ? 'm' : 's';
			
			$this->print_calendars("changeResCalendar(%d,%d,%d,$this->type,'$prefix|$paramvalue')");
					
			print_date_span($this->firstDate, $this->lastDate, $this->type, array($paramname), array($paramvalue), $this->name);
			print_view_links($this->actualDate, $this->type, array($paramname), array($paramvalue));
			
			print_resource_jump_link($this->resources, $this->schedules, $this->machid, $this->scheduleid, $this->actualDate, $this->type, $this->isresource);
			
			switch ($this->type) {
				case MYCALENDARTYPE_DAY :
				case MYCALENDARTYPE_WEEK :
					if ($this->isresource) {
						print_day_resource_reservations($this->reservations, $this->firstDate, $this->totalDays, $this->scheduleid, $this->starttime, $this->endtime, $this->timespan, $is_private);
					}
					else {
						print_day_reservations($this->reservations, $this->firstDate, $this->totalDays, false, $is_private);
					}
					break;
				case MYCALENDARTYPE_MONTH :
					print_month_reservations($this->reservations, $this->firstDate, array('fname', 'lname'), false, $is_private);
			}
			
			print_details_div();
		}
		else {
			print_signup_sheet($this->reservations, $this->firstDate, 1, $this->starttime, $this->endtime, $this->timespan, $this->name, $is_private);		
		}
	}
}
?>