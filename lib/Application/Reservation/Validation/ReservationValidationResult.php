<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class ReservationValidationResult implements IReservationValidationResult
{
	private $_canBeSaved;
	private $_errors;
	private $_warnings;

	/**
	 * @param $canBeSaved bool
	 * @param $errors string[]
	 * @param $warnings string[]
	 */
	public function __construct($canBeSaved = true, $errors = null, $warnings = null)
	{
		$this->_canBeSaved = $canBeSaved;
		$this->_errors = $errors == null ? array() : $errors;
		$this->_warnings = $warnings == null ? array() : $warnings;
	}

	public function CanBeSaved()
	{
		return $this->_canBeSaved;
	}

	public function GetErrors()
	{
		return $this->_errors;
	}

	public function GetWarnings()
	{
		return $this->_warnings;
	}
}
?>