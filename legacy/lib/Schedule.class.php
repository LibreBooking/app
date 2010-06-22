<?php
/**
* Scheduler class
* This file contians the scheduler application where
*  users have an interface for reserving resources,
*  viewing other reservations and modifying their own.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 02-04-07
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Base directory of application
*/
$basedir = dirname(__FILE__) . '/..';
include_once($basedir . '/lib/db/ScheduleDB.class.php');
include_once($basedir . '/lib/Calendar.class.php');
include_once($basedir . '/lib/Summary.class.php');
include_once($basedir . '/templates/schedule.template.php');

class Schedule
{	
	private $_id;
	private $_name;
	private $_isDefault;
	private $_startTime;
	private $_endTime;
	private $_weekdayStart;
	private $_adminId;
	private $_daysVisible;
	
	public function __construct($id, $name, $isDefault, $startTime, $endTime, $weekdayStart, $adminId, $daysVisible)
	{
		$this->_id = $id;
	}
	
	public function GetId()
	{
		return $this->_id;
	}
	
	public function SetId($value)
	{
		$this->_id = $value;
	}
	
	public function GetName()
	{
		return $this->_name;
	}
	
	public function SetName($value)
	{
		$this->_name = $value;
	}
	
	public function GetIsDefault()
	{
		return $this->_isDefault;
	}
	
	public function SetIsDefault($value)
	{
		$this->_isDefault = $value;
	}
	
	public function GetStartTime()
	{
		return $this->_startTime;
	}
	
	public function SetStartTime($value)
	{
		$this->_startTime = $value;
	}
	
	public function GetEndTime()
	{
		return $this->_endTime;
	}
	
	public function SetEndTime($value)
	{
		$this->_endTime = $value;
	}
	
	public function GetWeekdayStart()
	{
		return $this->_weekdayStart;
	}
	
	public function SetWeekdayStart($value)
	{
		$this->_weekdayStart = $value;
	}
	
	public function GetAdminId()
	{
		return $this->_adminId;
	}
	
	public function SetAdminId($value)
	{
		$this->_adminId = $value;
	}
	
	public function GetDaysVisible()
	{
		return $this->_daysVisible;
	}
	
	public function SetDaysVisible($value)
	{
		$this->_daysVisible = $value;
	}
	
}Schedule {

    var $_date = array();
    var $machids = array();
    var $res = array();
    var $blackouts = array();
    var $db;
    var $user;
    var $scheduleType;
    var $scheduleid;
    var $viewdays;
    var $startDay;
    var $endDay;
    var $timespan;
    var $weekStartDay;
    var $showsummary;
    var $title;
    var $admin;
    var $isValid = false;

    /**
    * Sets up initial variable values
    * @param constant $scheduleType type of schedule to print out
    */
    function Schedule($scheduleid, $scheduleType = ALL) {
        $this->scheduleid = $scheduleid;
        $this->scheduleType = $scheduleType;                // Set schedule type

        $this->db = new ScheduleDB($scheduleid, $scheduleType);            // Set database class

        if ($scheduleid == null) {
            $this->scheduleid = $this->db->get_default_id();
            $this->db->scheduleid = $this->scheduleid;
        }

        $this->isValid = $this->db->check_scheduleid($this->scheduleid);

        if ($this->isValid) {
            $data = $this->db->get_schedule_data($this->scheduleid);
            $this->viewdays = $data['viewdays'];
            $this->startDay = $data['daystart'];
            $this->endDay     = $data['dayend'];
            $this->timespan    = $data['timespan'];
            $this->weekdaystart = $data['weekdaystart'];
            $this->showsummary = $data['showsummary'];
            $this->title    = $data['scheduletitle'];
            $this->admin    = $data['adminemail'];

            if ($scheduleType == READ_ONLY) {
                $this->user = new User();
			}
            else {
                $this->user = new User(Auth::getCurrentID());    // Set User class
			}

            $this->_date = $this->get_date_vars();        // Get all date info we need
            $this->machids = $this->db->get_mach_ids($this->scheduleid);    // Get all resource info
            $machids = array();
            if($this->machids !== false) {
                foreach($this->machids as $mach) {
                    $machids[] = $mach['machid'];
                }
            }
            $this->res = $this->db->get_all_res($this->_date['firstDayTs'], $this->_date['lastDayTs'], $machids, $this->user->get_id());
        }
    }

    /**
    * Prints the actual schedule by calling all necessary class
    *  and schedule template functions
    * @param none
    */
    function print_schedule() {
        global $conf;

        print_date_span($this->_date, $this->title);

        print_schedule_list($this->db->get_schedule_list(), $this->scheduleid);

        $this->print_calendars();

        if ($this->scheduleType == ALL)
            print_color_key();

        // Break first day we are viewing into an array of date pieces
        $temp_date = getdate($this->_date['firstDayTs']);
        $hour_header = get_hour_header($this->get_time_array(), $this->startDay, $this->endDay, $this->timespan);    // Get the headers (same for all tables)

        // Repeat this for each day we need to show
        for ($dayCount = 0; $dayCount < $this->viewdays; $dayCount++) {
            // Timestamp for whatever day we are currently viewing
            $this->_date['current'] = mktime(0,0,0, $temp_date['mon'], $temp_date['mday'] + $dayCount, $temp_date['year']);
            start_day_table($this->get_display_date(), $hour_header);    // Start the table for this day
            $this->print_reservations();    // Print reservations for this day
            end_day_table();                // End the table for this day
        }
        print_summary_div();

    }

    /**
    * Prints out 3 calendars (prev month, this month, next month) at the top of the schedule
    * @param none
    */
    function print_calendars() {
        $prev = new Calendar(false, $this->_date['month'] -1, $this->_date['year']);
        $curr = new Calendar(false, $this->_date['month'], $this->_date['year']);
        $next = new Calendar(false, $this->_date['month'] + 1, $this->_date['year']);
        $prev->scheduleid = $curr->scheduleid = $next->scheduleid = $this->scheduleid;

        print_calendars($prev, $curr, $next);
    }

	/**
	* Whether the reservation link is shown/clickable
	* @param bool $viewable_date if the date is viewable
	* @param array $current_record the currently iterated machid record
	* @return if this reservation link is available to view
	*/
    function canShowReservation($viewable_date, $current_record) {
		if (Auth::isAdmin()) {
			return true;
		}

		$is_active = ($current_record['status'] == 'a');
		$has_permission = $this->user->has_perm($current_record['machid']);
		
		return ( $viewable_date && $is_active && $has_permission );
    }

	/**
	* Whether the reservation link is shown/clickable on this date
	* @param int $current_date the current datestamp
	* @param int $min_notice the minimum number of notice hours for the current resource
	* @param int $max_notice the maximum number of notice hours for the current resource
	* @return if this reservation link is available to view
	*/
    function isViewableDate($current_date, $min_notice, $max_notice) {
		$min_days = intval($min_notice / 24);

		$min_date = mktime(0,0,0, date('m'), date('d') + $min_days);
		
		if ($current_date < $min_date)
		{
			return false;
		}

		if ($max_notice != 0) {
			$max_days = intval($max_notice / 24);
	
			$max_date = mktime(0,0,0, date('m'), date('d') + $max_days);
	
			if ($current_date > $max_date)
			{
				return false;
			}
		}

		return true;
    }
	
    /**
    * Print out the reservations for each resource on each day
    * @param none
    */
    function print_reservations() {
        global $conf;

        if (!$this->machids)
            return;
        $current_date = $this->_date['current'];        // Store current_date so we dont have to access the array every time

        // Repeat this whole process for each resource in the database
        for ($count = 0; $count < count($this->machids); $count++) {
            $prevTime = $this->startDay;        // Previous time holder
            $totCol = intval(($this->endDay - $this->startDay) / $this->timespan);    // Total columns holder
			$cur_resource = $this->machids[$count];

            // Store info about this current resource in local vars
            $id = $cur_resource['machid'];
            $name = $cur_resource['name'];
            $status = $cur_resource['status'];
            $approval = $cur_resource['approval'];

            $shown = false;        // Default resource visiblilty to not shown
			$viewable_date = $this->isViewableDate($current_date, $cur_resource['min_notice_time'], $cur_resource['max_notice_time']);

            // If the date has not passed, resource is active and user has permission,
            //  or the user is the admin allow reservations to be made
            $shown = $this->canShowReservation($viewable_date, $cur_resource);

            $color = 'cellColor' . ($count%2);
            print_name_cell($current_date, $id, $name, $shown, $this->scheduleType == BLACKOUT_ONLY, $this->scheduleid, $approval, $color);

            $index = $id;
            if (isset($this->res[$index])) {
                for ($i = 0; $i < count($this->res[$index]); $i++) {
                    $rs = $this->res[$index][$i];
                    // If it doesnt start sometime today, end sometime today, or surround today, just skip over it
                    if (
                        !(($rs['start_date'] >= $current_date && $rs['start_date'] <= $current_date)
                        || ($rs['end_date'] >= $current_date && $rs['end_date'] <= $current_date)
                        || ($rs['start_date'] <= $current_date && $rs['end_date'] >= $current_date))
                       ) {
                        continue;
                    }

                    // Just skip the reservation if the ending date/time is todays start time
                    if ($rs['end_date'] == $current_date && $rs['endtime'] == $this->startDay) { continue; }

                    // If the reservation starts before or ends after todays date, just pretend it ends today so it shows correctly
                    if ($rs['start_date'] < $current_date) {
                        $rs['starttime'] = $this->startDay;
                    }
                    if ($rs['end_date'] > $current_date) {
                        $rs['endtime'] = $this->endDay;
                    }

                    // Print out row of reservations
                    $thisStart = $rs['starttime'];
                    $thisEnd = $rs['endtime'];

                    if ($thisStart < $this->startDay && $thisEnd > $this->startDay)
                        $thisStart = $this->startDay;
                    else if ($thisStart < $this->startDay && $thisEnd <= $this->startDay)
                        continue;    // Ignore reservation, its off the schedule

                    if ($thisStart < $this->endDay && $thisEnd > $this->endDay)
                        $thisEnd = $this->endDay;
                    else if ($thisStart >= $this->endDay && $thisEnd > $this->startDay)
                        continue;    // Ignore reservation, its off the schedule

                    $colspan = intval(($thisEnd - $thisStart) / $this->timespan);

                    $this->move_to_starting_col($rs, $thisStart, $prevTime, $this->timespan, $id, $current_date, $shown, $color);

                    if ($rs['is_blackout'] == 1)
                        $this->write_blackout($rs, $colspan);
                    else
                        $this->write_reservation($rs, $colspan, $viewable_date);

                    // Set prevTime to this reservation's ending time
                    $prevTime = $thisEnd;
                }
            }

            $this->finish_row($this->endDay, $prevTime, $this->timespan, $id, $current_date, $shown, $color);
        }
    }

    /**
    * Return the formatted and timezone adjusted date
    * @param int $ts time stamp for date to format
    * @return formatted date
    */
    function get_display_date() {
		return Time::formatReservationDate($this->_date['current'], $this->startDay, null, 'schedule_daily');
    }

    /**
    * Sets up all date variables needed in the scheduler
    * @param none
    * @return array of all needed date variables
    */
    function get_date_vars() {
        $default = false;

        $dv = array();

        // For Back, Current, Next Week clicked links
        //    pull values into an array month,day,year
        $indate = (isset($_GET['date'])) ? explode('-',$_GET['date']) : '';

        // Set date values if a date has been passed in (these will always be set to a valid date)
        if ( !empty($indate) || isset($_POST['jumpForm']) ) {
            $dv['month']  = (isset($_POST['jumpMonth'])) ? date('m', mktime(0,0,0,$_POST['jumpMonth'],1)) : date('m', mktime(0,0,0,$indate[0],1));
            $dv['day']    = (isset($_POST['jumpDay'])) ? date('d', mktime(0,0,0,$dv['month'], $_POST['jumpDay'])) : date('d', mktime(0,0,0, $dv['month'], $indate[1]));
            $dv['year']   = (isset($_POST['jumpYear'])) ? date('Y', mktime(0,0,0, $dv['month'], $dv['day'], $_POST['jumpYear'])) : date('Y', mktime(0,0,0, $dv['month'], $dv['day'], $indate[2]));
        }
        else {
            // Else set values to user defined starting day of week
            $d = getdate();
            $dv['month']  = $d['mon'];
            $dv['day']    = $d['mday'];
            $dv['year']   = $d['year'];
            $default = true;
        }

        // Make timestamp for today's date
        $dv['todayTs'] = mktime(0,0,0, $dv['month'], $dv['day'], $dv['year']);

        // Get proper starting day
        $dayNo = date('w', $dv['todayTs']);

        if ($default)
            $dv['day'] = $dv['day'] - ($dayNo - $this->weekdaystart);        // Make sure week starts on correct day

        // If default view and first day has passed, move up one week
        //if ($default && (date(mktime(0,0,0,$dv['month'], $dv['day'] + $this->viewdays, $dv['year'])) <= mktime(0,0,0)))
        //    $dv['day'] += 7;

        $dv['firstDayTs'] = mktime(0,0,0, $dv['month'], $dv['day'], $dv['year']);
		$date_parts = getdate();

        // Make timestamp for last date
        // by adding # of days to view minus the day of the week to $day
        $dv['lastDayTs'] = mktime(0,0,0, $dv['month'], ($dv['day'] + $this->viewdays - 1), $dv['year']);
        $dv['current'] = $dv['firstDayTs'];

        return $dv;
    }


    /**
    * Get associative array of available times and rowspans
    * This function computes and returns an associative array
    * containing a timezone adjusted time value and it's rowspan value as
    * $array[time] => rowspan
    * @param none
    * @return array of time value and it's associated rowspan value
    * @global $conf
    */
    function get_time_array() {
        global $conf;

        $startDay = $startingTime = $this->startDay;
        $endDay   = $endingTime   = $this->endDay;
        $interval = $this->timespan;
        $timeHash = array();

        // Compute the available times
        $prevTime = $startDay;

        if ( (($startDay % 60) != 0) && ($interval < 60) ) {
            $time = Time::formatTime($startDay);
            $timeHash[$time] = intval((60-($startDay%60))/$interval);
            $prevTime += $interval*$timeHash[$time];
        }

        while ($prevTime < $endingTime) {
            if ($interval < 60) {
                $time = Time::formatTime($prevTime);
                $timeHash[$time] = intval(60 / $interval);
                $prevTime += 60;        // Always increment by 1 hour
            }
            else {
                $colspan = 1;                // Colspan is always 1
                $time = Time::formatTime($prevTime);
                $timeHash[$time] = $colspan;
                $prevTime += $interval;
            }
        }
        return $timeHash;
    }

    /**
    * Print out links to jump to new dates
    * @param none
    */
    function print_jump_links() {
        global $conf;
        print_jump_links($this->_date['firstDayTs'], $this->viewdays, ($this->viewdays != 7));
    }

    /**
    * Return color_select for given reservation
    * @param array $rs array of reservation information
    */
    function get_reservation_colorstr($rs) {
        global $conf;

        $is_mine = false;
		$is_participant = false;
        $is_past = false;
        $color_select = 'other_res';        // Default color (if anything else is true, it will be changed)

		if ($this->scheduleType != READ_ONLY) {
            if ($rs['owner'] == 1) {
                $is_mine = true;
                $color_select = 'my_res';
            }
			else if ($rs['participantid'] != null && $rs['owner'] == 0) {
				$is_participant = true;
				$color_select = 'participant_res';
			}
        }

        if (mktime(0,0,0) > $this->_date['current']) {        // If todays date is still before or on the day of this reservation
            $is_past = true;
			if ($is_mine) {
				 $color_select = 'my_past_res';
			}
			else if ($is_participant) {
				$color_select = 'participant_past_res';
			}
			else {
				$color_select ='other_past_res';
			}
        }

        if ( $rs['is_pending'] ) {
            $color_select = 'pending';
        }

        return $color_select;
    }

    /**
    * Calculates and calls the template function to print out leading columns
	* @param array $rs array of reservation information
    * @param int $start starting time of reservation
    * @param int $prev previous ending reservation time
    * @param int $span time span for reservations
    * @param string $machid id of the resource on this table row
    * @param int $ts timestamp for the reservation start date
    * @param bool $clickable if this row's cells can be clicked to start a reservation
	* @param string $color class of column background
    */
    function move_to_starting_col($rs, $start, $prev, $span, $machid, $ts, $clickable, $color) {
        global $conf;
        $cols = (($start-$prev) / $span) - 1;
		
		 print_blank_cols($cols, $prev, $span, $ts, $machid, $this->scheduleid, $this->scheduleType, $clickable, $color);
    }

    /**
    * Calculates and calls template function to print out trailing columns
    * @param int $end ending time of day
    * @param int $prev previous ending reservation time
    * @param int $span time span for reservations
    * @param string $machid id of the resource on this table row
    * @param int $ts timestamp for the reservation start date
    * @param bool $clickable if this row's cells can be clicked to start a reservation
	* @param string $color class of column background
    */
    function finish_row($end, $prev, $span, $machid, $ts, $clickable, $color) {
        global $conf;
        $cols = (($end-$prev) / $span) - 1;
		
		print_blank_cols($cols, $prev, $span, $ts, $machid, $this->scheduleid, $this->scheduleType, $clickable, $color);
        print_closing_tr();
    }

    /**
    * Calls template function to write out the reservation cell
    * @param array $rs array of reservation information
    * @param int $colspan column span value
	* @param bool $viewable_date if the date is clickable/viewable
    */
    function write_reservation($rs, $colspan, $viewable_date) {
        global $conf;

		/// !!! CLEAN THIS UP !!! ///
        $is_mine = false;
        $is_past = false;
		$is_private = $conf['app']['privacyMode'] && !Auth::isAdmin();
        $color_select = $this->get_reservation_colorstr($rs);

        if ($this->scheduleType != READ_ONLY) {
            if ($rs['memberid'] == $_SESSION['sessionID']) {
                $is_mine = true;
            }
        }

		$summary = new Summary($rs['summary']);
		if ((bool)$conf['app']['prefixNameOnSummary']) {
			$summary->user_name = "{$rs['fname']} {$rs['lname']}";
		}

        // If this is the user who made the reservation or the admin,
        //  and time has not passed, allow them to edit it
        //  else only allow view
        $mod_view = ( ($is_mine && $viewable_date) || Auth::isAdmin()) ? 'm' : 'v';    // To use in javascript edit/view box
        $showsummary = (($this->scheduleType != READ_ONLY || ($this->scheduleType == READ_ONLY && $conf['app']['readOnlySummary'])) && $this->showsummary && !$is_private);
        $viewable = ($this->scheduleType != READ_ONLY || ($this->scheduleType == READ_ONLY && $conf['app']['readOnlyDetails']));
        $summary->visible = $showsummary;
		
		$is_pending = Auth::isAdmin() ? 0 : $rs['is_pending'];

		write_reservation($colspan, $color_select, $mod_view, $rs['resid'], $summary, $viewable, $this->scheduleType == READ_ONLY, $is_pending);
    }

    /**
    * Calls template function to write out the blackout cell
    * @param array $rs array of reservation information
    * @param int $colspan column span value
    */
    function write_blackout($rs, $colspan) {
        global $conf;
		$is_private = $conf['app']['privacyMode'] && !Auth::isAdmin();
        $showsummary = (($this->scheduleType != READ_ONLY || ($this->scheduleType == READ_ONLY && $conf['app']['readOnlySummary'])) && $this->showsummary && !$is_private);
		
        $summary = new Summary($rs['summary']);
        $summary->visible = $showsummary;
        
        write_blackout($colspan, Auth::isAdmin(), $rs['resid'], $summary,  $showsummary);
    }

    /**
    * Prints out an error message for the user
    * @param none
    */
    function print_error() {
        CmnFns::do_error_box(translate('That schedule is not available.') . '<br/><a href="javascript: history.back();">' . translate('Back') . '</a>', '', false);
    }
}
?>