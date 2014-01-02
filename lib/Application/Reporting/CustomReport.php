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

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class CustomReport implements IReport
{
	/**
	 * @var CustomReportData
	 */
	private $data;
	/**
	 * @var ReportColumns
	 */
	private $cols;
	/**
	 * @var int
	 */
	private $resultCount = 0;

	public function __construct($rows)
	{
		$this->data = new CustomReportData($rows);
		$this->resultCount = count($rows);

		$this->cols = new ReportColumns();
		if (count($rows) > 0)
		{
			foreach ($rows[0] as $columnName => $value)
			{
				$this->cols->Add($columnName);
			}
		}
	}

	/**
	 * @return IReportColumns
	 */
	public function GetColumns()
	{
		return $this->cols;
	}

	/**
	 * @return IReportData
	 */
	public function GetData()
	{
		return $this->data;
	}

	/**
	 * @return int
	 */
	public function ResultCount()
	{
		return $this->resultCount;
	}

}

?>