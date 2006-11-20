<?php
/**
* Formats a Reservation for vCalendar
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-24-06
* @package phpScheduleIt.vCalendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
require_once($basedir . '/lib/icalendar/ICalReservationFormatter.php');

class VCalReservationFormatter extends ICalReservationFormatter
{
	var $_reservation;

	function VCalReservationFormatter() {

	}

	function setReservation(&$reservation) {
		$this->_reservation = $reservation;
	}

	function formatOwner() {
		$builder = new StringBuilder();

		$builder->append("ATTENDEE;ROLE=OWNER:{$this->_reservation->user->email}\r\n");

		return $builder->toString();
	}

	function formatParticipants() {
		$builder = new StringBuilder();

		for ($i = 0; $i < count($this->_reservation->users); $i++) {
			$builder->append("ATTENDEE;ROLE=ATTENDEE:{$this->_reservation->users[$i]['email']}\r\n");
		}

		return $builder->toString();
	}

	function formatReminder() {
		$builder = new StringBuilder();

		if ($this->_reservation->reminder_minutes_prior != 0) {
			$reminder_time = $this->_reservation->start + ($this->_reservation->start * 60) - ($this->_reservation->reminder_minutes_prior * 60);
			$adjusted = Time::getAdjustedTime($reminder_time);
			$builder->append( sprintf(
							"DALARM:%sT%sZ\r\n",
							date('Ymd', $adjusted),
							date('His', $adjusted)
							));
		}

		return $builder->toString();
	}
}
?>