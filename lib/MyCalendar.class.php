<?php
/**
* MyCalendar class
* This file contians the API functions for displaying
*  reservation data in a particular format for a user
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 01-28-07
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

@define('BASE_DIR', dirname(__FILE__) . '/..');
include_once(BASE_DIR . '/lib/db/MyCalendarDB.class.php');
include_once('Calendar.class.php');
include_once(BASE_DIR . '/templates/mycalendar.template.php');

class MyCalendar {
	var $db;

	var $userid;
	var $type;

	var $actualDate;
	var $firstDate;
	var $lastDate;
	var $date_vars;
	var $totalDays;

	/**
	* Sets up initial variable values
	* @param string $userid id of the calendar user
	* @param int MyCalendarType type for this calendar
	* @param int $actualDate todays date
	*/
	function MyCalendar($userid, $type = null, $actualDate = null, $load_reservations = true) {
		$this->userid = ($userid == null) ? Auth::getCurrentID() : $userid;
		$this->type = ($type == null) ? MYCALENDARTYPE_DAY : $type;

		$this->actualDate = $actualDate;
		$this->determine_first_date();
		$this->init_date_vars();

		if ($load_reservations) {
			$this->db = new MyCalendarDB();
			$this->load_reservations();
		}
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
			$date_vars = explode(' ',date('d m Y t w W', $datestamp));
			$last_month_num_days = date('t', mktime(0,0,0, $date_vars[1]-1, $date_vars[0], $date_vars[2]));
			$week_start = $conf['app']['calFirstDay'];
			$firstWeekDay = (7 + (date('w', $datestamp) - $week_start)) % 7;
			$lastWeekDay = date('w',$this->lastDate) + 1;
			$firstResDate = mktime(0,0,0, $date_vars[1]-1, ($last_month_num_days - $firstWeekDay) + 1, $date_vars[2]);
			$lastResDate = mktime(0,0,0, $date_vars[1]+1, ((7 + $week_start - $lastWeekDay) % 7), $date_vars[2]);
		}

		$this->reservations = $this->db->get_all_reservations($firstResDate-SECONDS_IN_DAY, $lastResDate+SECONDS_IN_DAY, $this->userid, $firstResDate, $lastResDate);
	}

	/**
	* Prints the given calendar out based on type
	* @param none
	*/
	function print_calendar() {
		$this->print_calendars("changeMyCal(%d,%d,%d,{$this->type})");

		print_date_span($this->firstDate, $this->lastDate, $this->type);
		print_view_links($this->actualDate, $this->type);

		switch ($this->type) {
			case MYCALENDARTYPE_DAY :
			case MYCALENDARTYPE_WEEK :
				print_day_reservations($this->reservations, $this->firstDate, $this->totalDays);
				break;
			case MYCALENDARTYPE_MONTH :
				print_month_reservations($this->reservations, $this->firstDate);
		}

		print_details_div();
	}

	/**
	* Create previous/current/next month calendars and print the proper ones
	* @param string $javascript javascript string to assign to the calendars
	*/
	function print_calendars($javascript) {
		list($month, $year) = explode('-', date('m-Y', $this->actualDate));
		$prev = new Calendar(false, $month -1, $year);
		$curr = new Calendar(false, $month, $year);
		$next = new Calendar(false, $month + 1, $year);

		$prev->javascript = $curr->javascript = $next->javascript = $javascript;

		if ($this->type == MYCALENDARTYPE_MONTH) { $curr = null; }	// No need to print out the current month if we are in month view

		print_calendars($prev, $next, $curr);
	}

	/**
	* Determines the first date of the calender based on values passed in the querystring
	* @param MyCalendarType $type type of calendar
	* @return datestamp of the first date to print out
	*/
	function determine_first_date() {
		global $conf;
		$tmpdate = null;
		$first_date = null;

		$date_split = explode('-', date('m-d-Y', $this->actualDate));

		if ($this->type == MYCALENDARTYPE_MONTH) { $date_split[1] = 1; } // For month view, we need to set the first day

		$tmpdate = mktime(0,0,0, $date_split[0], $date_split[1], $date_split[2]);	// Store the calculated first date

		if ($this->type == MYCALENDARTYPE_WEEK) {
			$day_of_week = (7 + (date('w', $tmpdate) - $conf['app']['calFirstDay'])) % 7;
			$first_date = mktime(0,0,0, $date_split[0], $date_split[1]-$day_of_week, $date_split[2]);
		}
		else {
			$first_date = $tmpdate;
		}

		$this->firstDate = $first_date;
	}

	/**
	* Initialize all date variables for start/end dates
	* @param none
	*/
	function init_date_vars() {

		$fdate = getdate($this->firstDate);		// Array of all first date info

		if ($this->type == MYCALENDARTYPE_WEEK) {
			$this->totalDays = 7;
			$this->lastDate = mktime(0,0,0, $fdate['mon'], $fdate['mday'] + $this->totalDays - 1, $fdate['year']);
		}
		else if ($this->type == MYCALENDARTYPE_MONTH) {
			$this->totalDays = date('t', $this->firstDate);
			$this->lastDate = mktime(0,0,0, $fdate['mon'], $fdate['mday'] + $this->totalDays - 1, $fdate['year']);
		}
		else {
			$this->totalDays = 1;
			$this->lastDate = $this->firstDate;
		}

		$ldate = getdate($this->lastDate);

		$this->date_vars['first_date'] = $fdate;
		$this->date_vars['last_date']  = $ldate;
	}
}
?>