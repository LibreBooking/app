<?php
/**
Copyright 2012-2014 Nick Korbel

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

class ReportColumns implements IReportColumns
{
	private $knownColumns = array();

	/**
	 * @param $columnName string
	 */
	public function Add($columnName)
	{
		$this->knownColumns[] = $columnName;
	}

	public function Exists($columnName)
	{
		return in_array($columnName, $this->knownColumns);
	}

	/**
	 * @return array|string
	 */
	public function GetAll()
	{
		return $this->knownColumns;
	}
}

?>