<?php
/**
* Interface for formatting a reservation object
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-13-06
* @package Interfaces
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

class IReservationFormatter
{
	// http://en.wikipedia.org/wiki/RFC2445_Syntax_Reference
	// http://www.imc.org/pdi/pdiproddev.html
	
	/**
	* Sets the current reservation object to be formatted
	* @param Reservation $reservation the reservation object to format
	* @return the reservation as a formatted string
	*/
	function setReservation(&$reservation) {
		die ('Not implemented');
	}
	
	/**
	* Formats the current reservation
	* @return the reservation as a formatted string
	*/
	function format() {
		die ('Not implemented');
	}

	function formatSettings() {
		die ('Not implemented');
	}

	function formatOwner() {
		die ('Not implemented');
	}

	function formatParticipants() {
		die ('Not implemented');
	}

	function formatSummary() {
		die ('Not implemented');
	}

	function formatReminder() {
		die ('Not implemented');
	}

	function formatResources() {
		die ('Not implemented');
	}
}
?>