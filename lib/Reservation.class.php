<?php
/**
* Reservation class
* Provides access to reservation data
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 06-11-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

require_once($basedir . '/lib/db/ResDB.class.php');
require_once($basedir . '/lib/User.class.php');
require_once($basedir . '/lib/Resource.class.php');
require_once($basedir . '/lib/PHPMailer.class.php');
require_once($basedir . '/lib/Reminder.class.php');
require_once($basedir . '/templates/reserve.template.php');


class Reservation {
	var $id 		= null;				//	Properties
	var $start_date	= null;				//
	var $end_date	= null;				//
	var $start	 	= null;				//
	var $end	 	= null;				//
	var $resource 	= null;				//
	var $user		= null;				//
	var $resources = array();			//
	var $created 	= null;				//
	var $modified 	= null;				//
	var $type 		= null;				//
	var $is_repeat	= false;			//
	var $repeat		= null;				//
	var $minres		= null;				//
	var $maxRes		= null;				//
	var $parentid	= null;				//
	var $is_blackout= false;			//
	var $is_pending = false;			//
	var $summary	= null;				//
	var $scheduleid	= null;				//
	var $sched		= null;				//
	var $users		= null;				//
	var $allow_participation = 0;		//
	var $allow_anon_participation = 0;	//
	var $reminderid	= null;				//
	var $invited_users = array();
	var $participating_users = array();	

	var $errors     = array();
	var $word		= null;
	var $adminMode  = false;
	var $is_participant = false;
	var $reminder_minutes_prior = 0;

	var $db;

	/**
	* Reservation constructor
	* Sets id (if applicable)
	* Sets the reservation action type
	* Sets the database reference
	* @param string $id id of reservation to load
	* @param bool $is_blackout if this is a blackout or not
	* @param bool $is_pending if this is a pending reservation or not
	* @param string $scheduleid id of the schedule this belongs to
	*/
	function Reservation($id = null, $is_blackout = false, $is_pending = false, $scheduleid = null) {
		$this->db = new ResDB();

		if (!empty($id)) {
			$this->id = $id;
			$this->load_by_id();
		}
		else {
			$this->is_blackout = $is_blackout;
			$this->is_pending = $is_pending;
			$this->scheduleid = $scheduleid;
		}

		$this->word = $is_blackout ? 'blackout' : 'reservation';
		$this->sched = $this->db->get_schedule_data($this->scheduleid);
	}

	/**
	* Loads all reservation properties from the database
	* @param none
	*/
	function load_by_id() {
		$res = $this->db->get_reservation($this->id, Auth::getCurrentID());	// Get values from DB

		if (!$res) {	// Quit if reservation doesnt exist
			CmnFns::do_error_box($this->db->get_err());
		}

		$this->start_date = $res['start_date'];
		$this->end_date	= $res['end_date'];
		$this->start	= $res['starttime'];
		$this->end		= $res['endtime'];
		$this->resource = new Resource($res['machid']);
		$this->created	= $res['created'];
		$this->modified = $res['modified'];
		$this->parentid = $res['parentid'];
		$this->summary	= htmlspecialchars($res['summary']);
		$this->scheduleid	= $res['scheduleid'];
		$this->is_blackout	= $res['is_blackout'];
		$this->is_pending	= $res['is_pending'];
		$this->allow_participation = $res['allow_participation'];
		$this->allow_anon_participation = $res['allow_anon_participation'];
		$this->is_participant = $res['participantid'] != null;
		$reminder = new Reminder($res['reminderid']);
		$reminder->set_reminder_time($res['reminder_time']);
		$this->reminderid = $res['reminderid'];
		$this->reminder_minutes_prior = $reminder->getMinutuesPrior($this);

		$this->users = $this->db->get_res_users($this->id);

		// Store the memberid of the owner
		for ($i = 0; $i < count($this->users); $i++) {
			if ($this->users[$i]['owner'] == 1) {
				$this->user = new User($this->users[$i]['memberid']);
			}
			else if ($this->users[$i]['invited'] == 1) {
				$this->invited_users[] = $this->users[$i];
			}
			else {
				$this->participating_users[] = $this->users[$i];
			}
		}

		$this->resources = $this->db->get_sup_resources($this->id);
	}

	/**
	* Deletes the current reservation from the database
	* If this is a recurring reservation, it may delete all reservations in group
	* @param boolean $del_recur whether to delete all recurring reservations in this group
	*/
	function del_res($del_recur) {
		$this->type = RES_TYPE_DELETE;

		$this->is_repeat = $del_recur;

		$this->check_perms();					// Make sure they are who they claim to be

		$users_to_inform = array();				// Notify all users that this reservation is being deleted
		for ($i = 0; $i < count($this->users); $i++) {
			$users_to_inform[] = $this->users[$i]['email'];
		}

		$this->db->del_res($this->id, $this->parentid, $del_recur, mktime(0,0,0), $this->user->userid);

		if (!$this->is_blackout)		// Mail the user if they want to be notified
			$this->send_email('e_del', null, $users_to_inform);

		CmnFns::write_log($this->word . ' ' . $this->id . ' deleted.', $this->user->get_id(), $_SERVER['REMOTE_ADDR']);
		if ($this->is_repeat)
			CmnFns::write_log('All ' . $this->word . 's associated with ' . $this->id . ' (having parentid ' . $this->parentid . ') were also deleted', $this->memberid, $_SERVER['REMOTE_ADDR']);
		$this->print_success('deleted');
	}

	/**
	* Add a new reservation to the database
	*  after verifying that user has permission
	*  and the time is available
	* @param array $users_to_invite array of users to invite to this reservation
	* @param array $resources_to_add array of additional resources to add to this reservation
	*/
	function add_res($users_to_invite = array(), $resources_to_add = array()) {
		$this->type     = RES_TYPE_ADD;
		$repeat = $this->repeat;

		$orig_start_date = $this->start_date;		// Store the original dates because they will be changed if we repeat
		$orig_end_date = $this->end_date;
		$accept_code = $this->db->get_new_id();

		$dates = array();
		$tmp_valid = false;

		if (!$this->is_blackout) {
			$this->check_perms();			// Only need to check once
			$this->check_min_max();
		}

		if ($this->check_startdate()) {
			$this->check_times();			// Check valid times
		}

		if ($this->has_errors()) {			// Print any errors generated above and kill app
			$this->print_all_errors(true);
		}

		$reminder = new Reminder();
		$reminder->setDB(new ReminderDB());

		$is_parent = $this->is_repeat;		// First valid reservation will be parentid (no parentid if solo reservation)

		for ($i = 0; $i < count($repeat); $i++) {
			$this->start_date = $repeat[$i];
			if ($this->is_repeat) {
				// End date will always be the same as the start date for recurring reservations
				$this->end_date = $this->start_date;
			}
			if ($i == 0) $tmp_date = $this->start_date;			// Store the first date to use in the email
			$is_valid = $this->check_res($resources_to_add);

			if ($is_valid) {
				$tmp_valid = true;								// Only one recurring needs to work
				$this->id = $this->db->add_res($this, $is_parent, $users_to_invite, $resources_to_add, $accept_code);
				if ($this->reminder_minutes_prior != 0) {
					$reminder->save($this, $this->reminder_minutes_prior); 		// Add the reminder
				}
				if (!$is_parent) {
					array_push($dates, $this->start_date);		// Add recurring dates (first date isnt recurring)
				}
				else {
					$this->parentid = $this->id;				// The first reservation is the parent id
				}
				CmnFns::write_log($this->word . ' ' . $this->id . ' added.  machid:' . $this->resource->get_property('machid') .', dates:' . $this->start_date . ' - ' . $this->end_date . ', start:' . $this->start . ', end:' . $this->end, $this->user->get_id(), $_SERVER['REMOTE_ADDR']);
			}
			$is_parent = false;									// Parent has already been stored
		}

		if ($this->has_errors())					// Print any errors generated when adding the reservations
			$this->print_all_errors(!$this->is_repeat);

		$this->start_date = $tmp_date;				// Restore first date for use in email
		if ($this->is_repeat) array_unshift($dates, $this->start_date);		// Add to list of successful dates

		sort($dates);

		// Restore original reservation dates
		$this->start_date = $orig_start_date;
		$this->end_date = $orig_end_date;

		if (!$this->is_blackout) {		// Notify the user if they want (only 1 email)
			$this->sched = $this->db->get_schedule_data($this->scheduleid);
			$this->send_email('e_add', $dates);
		}

		// Send out invites, if needed
		if (!$this->is_pending && count($users_to_invite) > 0) {
			$this->invite_users($users_to_invite, $dates, $accept_code);
		}

		if (!$this->is_repeat || $tmp_valid)
			$this->print_success('created', $dates);
	}

	/**
	* Modifies a current reservation, setting new start and end times or deleting it
	* @param array $all_invited_users array of all invited users to be used for DB insertion
	* @param array $users_to_invite array of newly invited users to be used for invitation emails
	* @param array $users_to_remove array of users that will be removed from invitation/participating in this reservation
	* @param array $unchanged_users array of users who have no status change at all
	* @param array $resources_to_add array of additional resources to add to this reservation
	* @param array $resources_to_remove array of additional resources to remove from this reservation
	* @param bool $del whether to delete it or not
	* @param boolean $mod_recur whether to modify all recurring reservations in this group
	*/
	function mod_res($users_to_invite, $users_to_remove, $unchanged_users, $resources_to_add, $resources_to_remove, $del, $mod_recur) {
		$recurs = array();
		$valid_resids = array();
		$this->type = RES_TYPE_MODIFY;

		$orig_start_date = $this->start_date;		// Store the original dates because they will be changed if we repeat
		$orig_end_date = $this->end_date;

		$accept_code = $this->db->get_new_id();

		if ($del) {									// First, check if this should be deleted
			$this->del_res($mod_recur, mktime(0,0,0));
			return;
		}

		if (!$this->is_blackout) {
			$this->check_perms();					// Check permissions
			$this->check_min_max();		// Check min/max reservation times
		}

		if ($this->check_startdate()) {
			$this->check_times();			// Check valid times
		}

		$this->is_repeat = $mod_recur;	// If the mod_recur flag is set, it must be a recurring reservation
		$dates = array();

		// First, modify the current reservation
		if ($this->has_errors()) {			// Print any errors generated above and kill app
			$this->print_all_errors(true);
		}

		$reminder = new Reminder();
		$reminder->setDB(new ReminderDB());

		$tmp_valid = false;
		
		$this->is_pending = $this->resource->get_property('approval');
		
		if ($this->is_repeat) {				// Check and place all recurring reservations
			$recurs = $this->db->get_recur_ids($this->parentid, mktime(0,0,0));

			for ($i = 0; $i < count($recurs); $i++) {
				$this->id = $recurs[$i]['resid'];		// Load reservation data
				$this->start_date = $recurs[$i]['start_date'];
				if ($this->is_repeat) {
					// End date will always be the same as the start date for recurring reservations
					$this->end_date = $this->start_date;
				}
				$is_valid = $this->check_res($resources_to_add);			// Check overlap (dont kill)

				if ($is_valid) {
					$tmp_valid = true;						// Only one recurring needs to pass
					$this->db->mod_res($this, $users_to_invite, $users_to_remove, $resources_to_add, $resources_to_remove, $accept_code);		// And place the reservation

					if (!empty($this->reminderid)) {
						$reminder->update($this, $this->reminder_minutes_prior);
					}
					else if ($this->reminder_minutes_prior != 0 && empty($this->reminderid)) {
						$reminder->save($this, $this->reminder_minutes_prior);
					}

					$dates[] = $this->start_date;
					$valid_resids[] = $this->id;
					CmnFns::write_log($this->word . ' ' . $this->id . ' modified.  machid:' . $this->get_machid() .', dates:' . $this->start_date . ' - ' . $this->end_date . ', start:' . $this->start . ', end:' . $this->end, $this->memberid, $_SERVER['REMOTE_ADDR']);
				}
			}
		}
		else {
			if ($this->check_res($resources_to_add)) {															// Check overlap
				$this->db->mod_res($this, $users_to_invite, $users_to_remove, $resources_to_add, $resources_to_remove, $accept_code);		// And place the reservation

				if (!empty($this->reminderid)) {
					$reminder->update($this, $this->reminder_minutes_prior);
				}
				else if ($this->reminder_minutes_prior != 0 && empty($this->reminderid)) {
					$reminder->save($this, $this->reminder_minutes_prior);
				}

				$dates[] = $this->start_date;
				$valid_resids[] = $this->id;
			}
		}

		// Restore original reservation dates
		$this->start_date = $orig_start_date;
		$this->end_date = $orig_end_date;

		if ($this->has_errors())		// Print any errors generated when adding the reservations
			$this->print_all_errors(!$this->is_repeat);

		if (!$this->is_blackout) {		// Notify the user if they want
			$this->send_email('e_mod', null, $unchanged_users);
		}

		// Send out invites, if needed
		if (!$this->is_pending && count($users_to_invite) > 0) {
			$this->invite_users($users_to_invite, $dates, $accept_code);
		}

		if (!$this->is_pending && count($users_to_remove) > 0) {
			$this->remove_users_email($users_to_remove, $dates);
		}

		if (!$this->is_repeat || $tmp_valid)
			$this->print_success('modified', $dates);
	}

    /**
	* Approves reservation and sends out an email to the owner
	* Any reservation invitations are sent at this point
	* @param bool $mod_recur if we should update all reservations in this group
	*/
	function approve_res($mod_recur) {
		$this->type = RES_TYPE_APPROVE;
		
		$this->is_repeat = $mod_recur;

		$this->db->approve_res($this, $mod_recur);
		$where = 'WHERE resid = ?';
		$values = array($this->id);
		if ($mod_recur) {
			$where .= ' OR parentid = ?';
			array_push($values, $this->parentid);
		}

		$dates = array();
		$ds = $this->db->get_table_data('reservations', array('start_date'), array('start_date'), null, null, $where, $values);
		for ($d = 0; $d < count($ds); $d++) {
			$dates[] = $ds[$d]['start_date'];
		}
		
		$this->send_email('e_app', $dates);

		// Send out invites, if needed
		if (count($this->users) > 0) {
			$accept_code = $this->db->get_new_id();
			$userinfo = array();
			for ($i = 0; $i < count($this->users); $i++) {
				if ($this->users[$i]['owner'] != 1) {
					$userinfo[] = $this->users[$i]['memberid'] . '|' . $this->users[$i]['email'];
				}
			}
			if (!empty($userinfo)) {
				$this->invite_users($userinfo, $dates, $accept_code);
			}
		}
		$this->print_success('approved', $dates);
	}

	/**
	* Prints a message nofiying the user that their reservation was placed
	* @param string $verb action word of what kind of reservation process just occcured
	* @param array $dates dates that were added or modified.  Deletions are not printed.
	*/
	function print_success($verb, $dates = array()) {
		echo '<script language="JavaScript" type="text/javascript">' . "\n"
			. 'window.opener.document.location.href = window.opener.document.URL;' . "\n"
			. '</script>';
		$date_text = '';
		for ($i = 0; $i < count($dates); $i++) {
			$date_text .= Time::formatReservationDate($dates[$i], $this->start) . '<br/>';
		}
		CmnFns::do_message_box(translate('Your ' . $this->word . ' was successfully ' . $verb)
					. (($this->type != 'd') ? ' ' . translate('for the follwing dates') . '<br /><br />' : '.')
					. $date_text . '<br/><br/>'
					. '<a href="javascript: window.close();">' . translate('Close') . '</a>'
					, 'width: 90%;');
	}

	/**
	* Verify that the starting date has not already passed
	* @return if the starting date is valid
	*/
	function check_startdate() {
		if ($this->adminMode) { return true; }

		$dates_valid = true;

		$min_notice = $this->resource->get_property('min_notice_time');
		$max_notice = $this->resource->get_property('max_notice_time');
		
		$date_vals = getdate();		
		$month = $date_vals['mon'];
		$day = $date_vals['mday'];
		$hour = $date_vals['hours'];
		$min = $date_vals['minutes'];

		$min_days = intval($min_notice / 24);
		$min_time = ((intval($min_notice % 24) + $hour) * 60) + $min;
		$min_date = mktime(0,0,0, $month, $day + $min_days);			
		
		if ( ($this->start_date < $min_date) ||
			 ($this->start_date == $min_date && $this->start < $min_time) )
		{
			$dates_valid = false;
			$this->add_error( translate('This resource cannot be reserved less than x hours in advance', array($min_notice)) );
		}

		if ($max_notice != 0 && $dates_valid) {
			// Only need to check this if the min notice check passed
			$max_days = intval($max_notice / 24);
			$max_time = ((intval($max_notice % 24) + $hour) * 60) + $min;

			$max_date = mktime(0,0,0, $month, $day + $max_days);

			if ( ($this->start_date > $max_date) ||
				 ($this->start_date == $max_date && $this->start > $max_time) )
			{
				$dates_valid = false;
				$this->add_error( translate('This resource cannot be reserved more than x hours in advance', array($max_notice)) );
			}
		}

		return $dates_valid;
	}

	/**
	* Verify that the user selected appropriate times and dates
	* @return if the times and dates selected are all valid
	*/
	function check_times() {
		$is_valid = ( (intval($this->start_date) < intval($this->end_date)) || ( intval($this->start_date) == intval($this->end_date) ) && (intval($this->start) < intval($this->end)) );
		// It is valid if the start date is less than or equal to the end date or (if the dates are equal), the start time is less than the end time
		if (!$is_valid) {
			$this->add_error(translate('Start time must be less than end time') . '<br /><br />'
					. translate('Current start time is') . ' ' . Time::formatDateTime($this->start_date + 60 * $this->start) . '<br />'
					. translate('Current end time is') . ' ' . Time::formatDateTime($this->end_date + 60 * $this->end) );
		}
		return $is_valid;
	}

	/**
	* Check to make sure that the reservation falls within the specified reservation length
	* @param int $min minimum reservation length
	* @param int $max maximum reservation length
	* @return if the time is valid
	*/
	function check_min_max() {
		$min = $this->resource->get_property('minres');
		$max = $this->resource->get_property('maxRes');
		if ($this->start_date < $this->end_date) {  return true; }	// Cannot have a min/max for multi-day reservations

		$this_length = ( $this->end - $this->start);
		$is_valid = ($this_length >= ($min)) && (($this_length) <= ($max));
		if (!$is_valid)
			$this->add_error(translate('Reservation length does not fall within this resource\'s allowed length.') . '<br /><br >'
					. translate('Your reservation is') . ' ' . Time::minutes_to_hours($this_length) . '<br />'
					. translate('Minimum reservation length') . ' ' . Time::minutes_to_hours($min). '<br />'
					. translate('Maximum reservation length') . ' ' . Time::minutes_to_hours($max)
					);
		return $is_valid;
	}

	/**
	* Checks to see if a time is already reserved
	* @return whether the time is reserved or not
	*/
	function check_res($resources_to_add) {
		$is_valid = $add_valid = true;

		$reserved = $this->db->checkAdditionalResources($this, $resources_to_add);
		$add_valid = (count($reserved) <= 0);
		if (!$add_valid) {
			for ($i = 0; $i < count($reserved); $i++) {
				$this->add_error(translate('Additional resource is reserved', array($reserved[$i]['name'], $reserved[$i]['number_available'])));
			}
		}
		else {
			$is_valid = !($this->db->check_res($this));
		}
		if (!$is_valid) {
			$this->add_error(translate('reserved or unavailable', array(Time::formatDateTime($this->start_date + (60*$this->start)), Time::formatDateTime($this->end_date + (60*$this->end)))));
		}
		return $is_valid && $add_valid;
	}

	/**
	* Check if a user has permission to use a resource
	* @param bool whether to kill the app if the user does not have permission
	* @return whether user has permission to use resource
	*/
	function check_perms($kill = true) {
		if ($this->adminMode)                    // Admin always has permission
		   return true;

		if ((Auth::getCurrentID() == null) || ($this->user->get_id() != Auth::getCurrentID())) {
		   $has_perm = false;                    // Check user is allowed to modify this reservation
		}
		else {
		   $has_perm = $this->user->has_perm($this->resource->get_property('machid')); // Get user permissions
		}

		if (!$has_perm)
		   CmnFns::do_error_box(
				   translate('You do not have permission to use this resource.')
				   , 'width: 90%;'
				   , $kill);

		return $has_perm;
	}

	/**
	* Prints out the reservation table
	* @param none
	*/
	function print_res() {
		global $conf;

		$is_private = $conf['app']['privacyMode'] && !$this->adminMode;

		$day_has_passed = !$this->check_startdate();

		if (!$this->adminMode && !$this->is_blackout && $day_has_passed )  {
			$this->type = RES_TYPE_VIEW;
		}
		
		if (Auth::getCurrentID() != $this->user->get_id() && !$this->adminMode) { $this->type = RES_TYPE_VIEW; };

		$rs = $this->resource->properties;
		if ($this->type == RES_TYPE_ADD && $rs['approval'] == 1) {
			$this->is_pending = true;		// On the initial add, make sure that the is_pending flag is correct
		}

		$is_owner = (($this->user->get_id() == Auth::getCurrentID() || $this->adminMode) && $this->type != RES_TYPE_VIEW);

		print_title($rs['name']);
		begin_reserve_form($this->type == RES_TYPE_ADD, $this->is_blackout);
		begin_container();
		print_basic_panel($this, $rs, $is_private);		// Contains resource/user info, time select, summary, repeat boxes

		if ($this->is_blackout || $is_private) {
			print_users_panel($this, array(), null, '', false, false);	// No advanced for either case
			print_additional_tab($this, array(), null, false, false);
		}
		else {
			$this->user->get_id();

			$all_users = ($is_owner) ? $this->db->get_non_participating_users($this->id, Auth::getCurrentID()) : array();
			print_users_panel($this, $all_users, $is_owner, $rs['max_participants'], true, $day_has_passed);

			$all_resources = ($is_owner) ? $this->db->get_non_participating_resources($this->id) : array();
			print_additional_tab($this, $all_resources, $is_owner, true);
		}

		end_container();
		print_buttons_and_hidden($this);
		end_reserve_form();
		print_jscalendar_setup($this, $rs);

		if ((bool)$this->allow_anon_participation || (bool)$this->allow_participation) {
			print_join_form_tags();
		}
	}

	/**
	* Sends an email notification to the user
	* This function sends an email notifiying the user
	* of creation/modification/deletion of a reservation
	* @param string $type type of modification made to the reservation
	* @param array $repeat_dates array of dates reserved on
	* @param array $users_to_inform array of emails to CC about the reservation mod
	* @global $conf
	*/
	function send_email($type, $repeat_dates = null, $users_to_inform = null) {
		global $conf;

		// Dont bother if nobody wants email
		if (!$this->user->wants_email($type) && !$conf['app']['emailAdmin']) {
			return;
		}

		// Email addresses
		$adminemail = $this->sched['adminemail'];
		$techEmail  = $conf['app']['techEmail'];
		$url        = CmnFns::getScriptURL();

		// Format date
		$start_date   = Time::formatReservationDate($this->start_date, $this->start);
		$end_date	  = Time::formatReservationDate($this->end_date, $this->end);
		$start  = Time::formatTime($this->get_start());
		$end    = Time::formatTime($this->get_end());

		$defs = array(
				translate('Reservation #'),
				translate('Start Date'),
				translate('End Date'),
				translate('Resource'),
				translate('Start Time'),
				translate('End Time'),
				translate('Location'),
				translate('Contact')
				);

		switch ($type) {
			case 'e_add' : $mod = 'created';
			break;
			case 'e_mod' : $mod = 'modified';
			break;
			case 'e_del' : $mod = 'deleted';
			break;
			case 'e_app' : $mod = 'approved';
			break;
		}

		$to     = $this->user->get_email();		// Who to mail to
		$subject= translate("Reservation $mod for", array($start_date));
		$uname  = $this->user->get_fname();

		$location = $this->resource->properties['location'];
		$phone    = $this->resource->properties['rphone'];
		$name     = $this->resource->properties['name'];
		$location = !empty($location) ? $location : translate('N/A');
		$phone    = !empty($phone) ? $phone : translate('N/A');

        if ($mod == 'approved') {
            $text = translate_email('reservation_activity_7', $uname, $this->id, $start_date, $start, $end_date, $end, $name, $location, translate($mod));
        }
		else {
            $text = translate_email('reservation_activity_1', $uname, translate($mod), $this->id, $start_date, $start, $end_date, $end, $name, $location, translate($mod));
        }

		if ($this->is_repeat && count($repeat_dates) > 1) {
			// Start at index = 1 because at index 0 is the parent date
			$text .= translate_email('reservation_activity_2');
			for ($d = 1; $d < count($repeat_dates); $d++) {
				$text .= Time::formatDate($repeat_dates[$d]) . "\r\n<br/>";
			}
			$text .= "\r\n<br/>";
		}

		if ($type != 'e_add' && $this->is_repeat) {
			$text .= translate_email('reservation_activity_3', translate($mod));
		}

		if (!empty($this->summary)) {
			$text .= stripslashes(translate_email('reservation_activity_4', ($this->summary)));
		}

		$text .= translate_email('reservation_activity_5', $adminemail, $phone, $conf['app']['title'], $url, $url);

		if (!empty($techEmail)) $text .= translate_email('reservation_activity_6', $techEmail, $techEmail);

		if ($this->user->wants_html()) {
			$msg = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
	<!--
	body {
		font-size: 11px;
    	font-family: Verdana, Arial, Helvetica, sans-serif;
		background-color: #F0F0F0;
	}
	a {
		color: #104E8B;
		text-decoration: none;
	}
	a:hover {
		color: #474747;
		text-decoration: underline;
	}
	table tr.header td {
		padding-top: 2px;
		padding-botton: 2px;
		background-color: #CCCCCC;
		color: #000000;
		font-weight: bold;
		font-size: 10px;
		padding-left: 10px;
		padding-right: 10px;
		border-bottom: solid 1px #000000;
	}
	table tr.values td {
		border-bottom: solid 1px #000000;
		padding-left: 10px;
		padding-right: 10px;
		font-size: 10px;
	}
	-->
	</style>
</head>

<body>

$text

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="header">
    <td>{$defs[0]}</td>
    <td>{$defs[1]}</td>
    <td>{$defs[2]}</td>
    <td>{$defs[3]}</td>
    <td>{$defs[4]}</td>
    <td>{$defs[5]}</td>
    <td>{$defs[6]}</td>
	<td>{$defs[7]}</td>
  </tr>
  <tr class="values">
    <td>$this->id</td>
    <td>$start_date</td>
	<td>$end_date</td>
    <td>$name</td>
    <td>$start</td>
    <td>$end</td>
    <td>$location</td>
    <td>$phone</td>
  </tr>
</table>
  </body>
</html>
EOT;
		}
		else {
			$text = strip_tags($text);		// Strip out HTML tags
			$msg = $text;

			$fields = array (	// array[x] = [0] => title, [1] => field value, [2] => length
						array($defs[0], $this->id, ((strlen($this->id) < strlen($defs[0])) ? strlen($defs[0]) : strlen($this->id))),
						array($defs[1], $start_date, ((strlen($start_date) < strlen($defs[1])) ? strlen($defs[1]) : strlen($start_date))),
						array($defs[2], $end_date, ((strlen($end_date) < strlen($defs[2])) ? strlen($defs[2]) : strlen($end_date))),
						array($defs[3], $name, ((strlen($name) < strlen($defs[3])) ? strlen($defs[3]) : strlen($name))),
						array($defs[4], $start, ((strlen($start) < strlen($defs[4])) ? strlen($defs[4]) : strlen($start))),
						array($defs[5], $end, ((strlen($end) < strlen($defs[5])) ? strlen($defs[5]) : strlen($end))),
						array($defs[6], $location, ((strlen($location) < strlen($defs[6])) ? strlen($defs[6]) : strlen($location))),
						array($defs[7], $phone, ((strlen($phone) < strlen($defs[7])) ? strlen($defs[7]) : strlen($phone)))
						);
			$total_width = 0;

			foreach ($fields as $a) {	// Create total width by adding all width fields plus the '| ' that occurs before every cell and ' ' after
				$total_width += (2 + $a[2] + 1);
			}
			$total_width++;		// Final '|'

			$divider = '+' . str_repeat('-', $total_width - 2) . '+'; 		// Row dividers

			$msg .= $divider . "\n";
			$msg .= '| ' . translate("Reservation $mod") . (str_repeat(' ', $total_width - strlen(translate("Reservation $mod")) - 4)) . " |\n";
			$msg .= $divider . "\n";
			foreach ($fields as $a) {		// Repeat printing all title fields, plus enough spaces for padding
				$msg .= "| $a[0]" . (str_repeat(' ', $a[2] - strlen($a[0]) + 1));
			}
			$msg .= "|\n";					// Close the row
			$msg .= $divider . "\n";
			foreach ($fields as $a) {		// Repeat printing all field values, plus enough spaces for padding
				$msg .= "| $a[1]" . (str_repeat(' ', $a[2] - strlen($a[1]) + 1));
			}
			$msg .= "|\n";					// Close the row
			$msg .= $divider . "\n";
		}

		$send = false;

		// Send email using PHPMailer
		$mailer = new PHPMailer();
		$mailer->ClearAllRecipients();

		if ($this->user->wants_email($type)) {
			$send = true;
			$mailer->AddAddress($to, $uname);

			if ($conf['app']['emailAdmin']) {
				// Add the admin to the CC if they want it
				$mailer->AddBCC($adminemail, translate('Administrator'));
			}
		}
		else if ($conf['app']['emailAdmin']) {
			$send = true;
			$mailer->AddAddress($adminemail, translate('Administrator'));
		}

		if (!empty($users_to_inform)) {
			foreach ($users_to_inform as $idx => $email) {
				$mailer->AddCC($email);
			}
		}

		$mailer->From = $adminemail;
		$mailer->FromName = $conf['app']['title'];
		$mailer->Subject = $subject;
		$mailer->Body = $msg;
		$mailer->IsHTML($this->user->wants_html());

		if ($send) {
			$mailer->Send();
		}

		$headers = null;
		unset($headers, $msg, $fields);
	}

	/**
	* Sends an email to all invited users with a link to accept or deny the reservation
	* @param array $userinfo array of users to invite
	* @param array $dates array of dates for this reservation
	* @param string $accept_code the acceptance code to be used in the email
	*/
	function invite_users($userinfo, $dates, $accept_code) {
		global $conf;
		$mailer = new PHPMailer();

		$mailer->From = $this->user->get_email();
		$mailer->FromName = $this->user->get_name();
		$mailer->Subject = $conf['app']['title'] . ' ' . translate('Reservation Invitation');
		$mailer->IsHTML(false);

		$url = CmnFns::getScriptURL();

		// Format dates
		$start_date   = Time::formatDate($this->start_date);
		$end_date	  = Time::formatDate($this->end_date);
		$start  = Time::formatTime($this->get_start());
		$end    = Time::formatTime($this->get_end());

		$dates_text = '';
		for ($d = 1; $d < count($dates); $d++) {
			$dates_text .= Time::formatDate($dates) . ",";
		}
		
		foreach ($userinfo as $memberid => $email) {
			$accept_url = $url . "/manage_invites.php?id={$this->id}&memberid=$memberid&accept_code=$accept_code&action=" . INVITE_ACCEPT;
			$decline_url= $url . "/manage_invites.php?id={$this->id}&memberid=$memberid&accept_code=$accept_code&action=" . INVITE_DECLINE;

			$mailer->ClearAllRecipients();
			$mailer->AddAddress($email);
			$mailer->Body = translate_email('reservation_invite', $this->user->get_name(), $this->resource->properties['name'], $start_date, $start, $end_date, $end, $this->summary, $dates_text, $accept_url, $decline_url, $conf['app']['title'], $url);
			$mailer->Send();
		}
	}

	/**
	* Send an email informing the users they have been dropped from the reservation
	* @param array $emails array of email addresses
	* @param array $dates that have been dropped
	*/
	function remove_users_email($emails, $dates) {
		global $conf;
		$mailer = new PHPMailer();

		$mailer->From = $this->user->get_email();
		$mailer->FromName = $this->user->get_name();
		$mailer->Subject = $conf['app']['title'] . ' ' . translate('Reservation Participation Change');
		$mailer->IsHTML(false);

		$url        = CmnFns::getScriptURL();

		// Format dates
		$start_date   = Time::formatDate($this->start_date);
		$end_date	  = Time::formatDate($this->end_date);
		$start  = Time::formatTime($this->get_start());
		$end    = Time::formatTime($this->get_end());

		$dates_text = '';
		for ($d = 1; $d < count($dates); $d++)
			$dates_text .= Time::formatDate($dates) . ",";

		foreach ($emails as $email) {
			$mailer->ClearAllRecipients();
			$mailer->AddAddress($email);
			$mailer->Body = translate_email('reservation_removal', $this->resource->properties['name'], $start_date, $start, $end_date, $end, $this->summary, $dates_text);
			$mailer->Send();
		}
	}

	/**
	* This function updates a users reservation status
	* This can accept/decline a reservation for a user
	* @param string $memberid id of the member to change the status for
	* @param string $action action code to perform
	* @param bool $update_all if this action applies to all reservations in the group
	* @param int $max_participants the maximum number of participants for this reservation
	*/
	function update_users($memberid, $action, $update_all, $max_participants = 0) {
		$failed = array();
		switch ($action) {
			case INVITE_ACCEPT :
				$failed = $this->db->confirm_user($memberid, $this->id, $this->parentid, $update_all, $max_participants);
				break;
			case INVITE_DECLINE :
				$this->db->remove_user($memberid, $this->id, $this->parentid, $update_all);
				break;
			default :
				return false;
				//break;
		}
		return $failed;
	}

	/**
	* Adds a user to a reservation as a participant
	* @param string $memberid id of the user to add
	* @param string $resid id of the reservation this user is being added to
	* @param string $accept_code accept code for the user to be able to participate
	*/
	function add_participant($memberid, $accept_code) {
		$this->db->add_participant($memberid, $this->id, $accept_code);
	}

	/**
	* Returns the type of this reservation
	* @param none
	* @return string the 1 char reservation type
	*/
	function get_type() {
		return $this->type;
	}

	/**
	* Returns the ID of this reservation
	* @param none
	* @return string this reservations id
	*/
	function get_id() {
		return $this->id;
	}

	/**
	* Returns the start time of this reservation
	* @param none
	* @return int start time (in minutes)
	*/
	function get_start() {
		return $this->start;
	}

	/**
	* Returns the end time of this reservation
	* @param none
	* @return int ending time (in minutes)
	*/
	function get_end() {
		return $this->end;
	}

	/**
	* Returns the timestamp for this reservation's date
	* @param none
	* @return int reservation timestamp
	*/
	function get_date() {
		return $this->start_date;
	}

	/**
	* Returns the created timestamp of this reservation
	* @param none
	* @return int created timestamp
	*/
	function get_created() {
		return $this->created;
	}

	/**
	* Returns the modified timestamp of this reservation
	* @param none
	* @return int modified timestamp
	*/
	function get_modified() {
		return $this->modified;
	}

	/**
	* Returns the resource id of this reservation
	* @param none
	* @return string resource id
	*/
	function get_machid() {
		return $this->resource->get_property('machid');
	}

    /**
	* Returns the resource id of this reservation
	* @param none
	* @return string resource id
	*/
	function get_pending() {
		return intval($this->is_pending);
	}

	/**
	* Returns the member id of this reservation
	* @param none
	* @return string memberid
	*/
	function get_memberid() {
		return $this->user->get_id();
	}

	/**
	* Returns the User object for this reservation
	* @param none
	* @return User object for this reservation
	*/
	function &get_user() {
		return $this->user;
	}

	/**
	* Returns the id of the parent reservation
	* This will only be set if this is a recurring reservation
	*  and is not the first of the set
	* @param none
	* @return string parentid
	*/
	function get_parentid() {
		return $this->parentid;
	}

	/**
	* Returns the summary for this reservation
	* @param none
	* @return string summary
	*/
	function get_summary() {
		return $this->summary;
	}

	/**
	* Returns the scheduleid for this reservation
	* @param none
	* @return string scheduleid
	*/
	function get_scheduleid() {
		return $this->scheduleid;
	}

	/**
	* Returns this reservations start date
	* @param none
	* @return int timestamp for this reservations start date
	*/
	function get_start_date() {
		return $this->start_date;
	}

	/**
	* Returns this reservations end date
	* @param none
	* @return int timestamp for this reservations end date
	*/
	function get_end_date() {
		return $this->end_date;
	}

	/**
	 * @param none
	 * @return if participation is allowed for this reservation
	 */
	function get_allow_participation() {
		return $this->allow_participation;
	}

	/**
	 * @param none
	 * @return if anonymous participation is allowed for this reservation
	 */
	function get_allow_anon_participation() {
		return $this->allow_anon_participation;
	}

	/**
	* Returns if this reservation is repeating or not
	* @param none
	* @return bool if this is a repeating reservation
	*/
	function is_repeat() {
		return ($this->parentid != null);
	}

	/**
	* Whether there were errors processing this reservation or not
	* @param none
	* @return if there were errors or not processing this reservation
	*/
	function has_errors() {
		return count($this->errors) > 0;
	}

	/**
	* Add an error message to the array of errors
	* @param string $msg message to add
	*/
	function add_error($msg) {
		array_push($this->errors, $msg);
	}

	/**
	* Return the last error message generated
	* @param none
	* @return the last error message
	*/
	function get_last_error() {
		if ($this->has_errors())
			return $this->errors[count($this->errors)-1];
		else
			return null;
	}

	/**
	* Prints out all the error messages in an error box
	* @param boolean $kill whether to kill the app after printing messages
	*/
	function print_all_errors($kill) {
		if ($this->has_errors()) {
			$div = '<hr size="1"/>';
			CmnFns::do_error_box(
				'<a href="javascript: history.back();">' . translate('Please go back and correct any errors.') . '</a><br /><br />' . join($div, $this->errors) . '<br /><br /><a href="javascript: history.back();">' . translate('Please go back and correct any errors.') . '</a>'
				, 'width: 90%;'
				, $kill);
			}
	}

	/**
	* Sets the reservation type
	* @param string type to set the reservation to
	*/
	function set_type($type) {
		$this->type = isset($type) ? substr($type, 0, 1) : null;
	}
}
?>