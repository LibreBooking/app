<?php
/**
* DB functions to provide ability to search for reservations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-22-06
* @package phpScheduleIt.ReservationSearch
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
require_once($basedir . '/lib/db/ResDB.class.php');
require_once($basedir . '/lib/ReservationResult.class.php');

class ReservationSearchDb extends ResDB
{	
	function getReservations($userid, $start, $end) {
		$return = array();
		$values = array($userid, $userid);
		
		$query = 'SELECT r.*, rem.reminder_time, rem.reminderid, ru.* FROM ' . $this->get_table(TBL_RESERVATIONS) . ' r'
			. ' INNER JOIN ' . $this->get_table(TBL_RESERVATION_USERS) . ' ru ON r.resid = ru.resid'
			. ' LEFT JOIN ' . $this->get_table(TBL_REMINDERS) . ' rem ON r.resid = rem.resid AND rem.memberid = ?'
			. ' WHERE ru.memberid = ? AND ru.invited = 0';
		
		if ($start != null) {
			$values[] = $start->date;
			$values[] = $start->date;
			$values[] = $start->time;			
			$query .= ' AND (r.start_date >= ? OR (r.start_date = ? AND r.starttime >= ?))';						
		}
		
		if ($end != null) {
			$values[] = $end->date;
			$values[] = $end->date;
			$values[] = $end->time;
			$query .= ' AND (r.end_date <= ? OR (r.end_date = ? AND r.endtime <= ?))';
		}
		
		$result = $this->db->query($query, $values);
		$this->check_for_error($result);
				
		while ($rs = $result->fetchRow()) {
			$res = new ReservationResult();
			
			$res->id = $rs['resid'];
			$res->start_date = $rs['start_date'];
			$res->end_date = $rs['end_date'];
			$res->start = $rs['starttime'];
			$res->end = $rs['endtime'];
			$res->resource = new Resource($rs['machid']);
			$res->resource->db = null;
			$res->created = $rs['created'];
			$res->modified = $rs['modified'];
			$res->parentid = $rs['parentid'];
			$res->summary = $rs['summary'];
			$res->scheduleid = $rs['scheduleid'];
			$res->is_pending = $rs['is_pending'];
			$res->is_participant = $rs['owner'] == 0;
			
			$reminder = new Reminder($rs['reminderid']);
			$reminder->set_reminder_time($rs['reminder_time']);
			$res->reminderid = $rs['reminderid'];
			$res->reminder_minutes_prior = $reminder->getMinutuesPrior($res);
	
			$users = $this->get_res_users($res->id);
			for ($i = 0; $i < count($users); $i++) {
				if ($users[$i]['owner'] == 1) {
					$res->user = new User($users[$i]['memberid']);
					$res->user->db = null;
					break;
				}
				else {
					$res->users[] = $users[$i];
				}
			}
			
			$res->resources = $this->get_sup_resources($res->id);
			
			$return[] = $res;
		}
		
		$result->free();
		
		return $return;
	}
}
?>