<?php
/**
Copyright 2012-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class FakeReport implements IReport
{
	public $_ReportColumns;
	public $_ReportData;
	public $_ResultCount = 0;

	public function __construct()
	{
		$this->_ReportColumns = new FakeReportColumns();
		$this->_ReportData = new FakeReportData();
	}
	/**
	 * @return IReportColumns
	 */
	public function GetColumns()
	{
		return $this->_ReportColumns;
	}

	/**
	 * @return IReportData
	 */
	public function GetData()
	{
		return $this->_ReportData;
	}

	/**
	 * @return int
	 */
	public function ResultCount()
	{
		return $this->_ResultCount;
	}
}

class FakeReportColumns implements IReportColumns
{
	/**
	 * @param $columnName string
	 * @return bool
	 */
	public function Exists($columnName)
	{
		return true;
	}

	/**
	 * @return array|string
	 */
	public function GetAll()
	{
		return array();
	}

	/**
	 * @return string[]
	 */
	public function GetCustomAttributes()
	{
		return array();
	}
}

class FakeReportData implements IReportData
{
	/**
	 * @return array
	 */
	public function Rows()
	{
		return array();
	}
}

?>