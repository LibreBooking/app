<?php
/**
* Exports a list of Reservations formatted for vCalendar
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-31-06
* @package phpScheduleIt.vCalendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
require_once($basedir . '/lib/icalendar/ICalExport.php');

class VCalExport extends ICalExport
{
	function VCalExport(&$reservations) {
		$this->_reservations = $reservations;
		$this->_formatter = new VCalReservationFormatter();
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
		return "BEGIN:VCALENDAR\r\n\r\nPRODID:-//phpScheduleIt//{$conf['app']['version']}//EN\r\nVERSION:1.0\r\n";
	}
}
?>