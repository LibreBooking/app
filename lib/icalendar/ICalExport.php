<?php
/**
* Exports a list of Reservations formatted for iCalendar
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-24-06
* @package phpScheduleIt.iCalendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
require_once($basedir . '/lib/interfaces/IReservationExport.php');
require_once($basedir . '/lib/helpers/StringBuilder.class.php');

class ICalExport extends IReservationExport
{
	function ICalExport(&$reservations) {
		$this->_reservations = $reservations;
		$this->_formatter = new ICalReservationFormatter();
	}

	function _parse() {
		$builder = new StringBuilder();
		
		for ($i = 0; $i < count($this->_reservations); $i++) {
			$this->_formatter->setReservation($this->_reservations[$i]);
			$builder->append($this->_formatter->format());
		}

		return $builder->toString();
	}

	function toString() {
		$builder = new StringBuilder();
		$builder->append($this->getHeader());
		$builder->append($this->_parse());
		$builder->append($this->getFooter());
		
		return $builder->toString();
	}
	
	function getHeader() {
		global $conf;
		return "BEGIN:VCALENDAR\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nPRODID:-//phpScheduleIt//{$conf['app']['version']}//EN\r\nX-WR-CALNAME;VALUE=TEXT:phpScheduleIt\r\nVERSION:2.0\r\n";
	}
	
	function getFooter() {
		return "END:VCALENDAR";
	}
}
?>