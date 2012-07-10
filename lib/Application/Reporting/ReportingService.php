<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class Report_Usage
{
	const RESOURCES = 'RESOURCES';
	const ACCESSORIES = 'ACCESSORIES';

	/**
	 * @var Report_Usage|string
	 */
	private $usage;

	/**
	 * @param $usage string|Report_Usage
	 */
	public function __construct($usage)
	{
		$this->usage = $usage;
	}
}

class Report_ResultSelection
{
	const COUNT = 'COUNT';
	const TIME = 'TIME';
	const FULL_LIST = 'LIST';

	/**
	 * @var Report_ResultSelection|string
	 */
	private $selection;

	/**
	 * @param $selection string|Report_ResultSelection
	 */
	public function __construct($selection)
	{
		$this->selection = $selection;
	}
}

class Report_GroupBy
{
	const NONE = 'NONE';
	const RESOURCE = 'RESOURCE';
	const SCHEDULE = 'SCHEDULE';
	const USER = 'USER';
	const GROUP = 'GROUP';

	/**
	 * @var Report_GroupBy|string
	 */
	private $groupBy;

	/**
	 * @param $groupBy string|Report_GroupBy
	 */
	public function __construct($groupBy)
	{
		$this->groupBy = $groupBy;
	}
}

class Report_Range
{
	const DATE_RANGE = 'DATE_RANGE';
	const ALL_TIME = 'ALL_TIME';

	/**
	 * @var Report_Range|string
	 */
	private $range;

	/**
	 * @param $range string|Report_Range
	 * @param Date $start
	 * @param Date $end
	 */
	public function __construct($range, Date $start, Date $end)
	{
		$this->range = $range;
	}
}

class Report_Filter
{
	/**
	 * @var int|null
	 */
	private $resourceId;

	/**
	 * @var int|null
	 */
	private $scheduleId;

	/**
	 * @var int|null
	 */
	private $userId;

	/**
	 * @var int|null
	 */
	private $groupId;

	/**
	 * @param $resourceId int|null
	 * @param $scheduleId int|null
	 * @param $userId int|null
	 * @param $groupId int|null
	 */
	public function __construct($resourceId, $scheduleId, $userId, $groupId)
	{
		$this->resourceId = $resourceId;
		$this->scheduleId = $scheduleId;
		$this->userId = $userId;
		$this->groupId = $groupId;
	}
}

class ReportColumns implements IReportColumns
{
	public static function ResourceFullList()
	{
		return new ReportColumns();
	}
}

interface IReportColumns
{

}

interface IReportData
{

}

class CustomReportData implements IReportData
{

}

interface IReport
{
	/**
	 * @abstract
	 * @return IReportColumns
	 */
	public function GetColumns();

	/**
	 * @abstract
	 * @return IReportData
	 */
	public function GetData();
}

interface IReportingService
{
	/**
	 * @abstract
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 * @return IReport
	 */
	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);
}

class CustomReport implements IReport
{
	/**
	 * @return IReportColumns
	 */
	public function GetColumns()
	{
		// TODO: Implement GetColumns() method.
	}

	/**
	 * @return IReportData
	 */
	public function GetData()
	{
		// TODO: Implement GetData() method.
	}
}

class ReportingService implements IReportingService
{

	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		return new CustomReport();
	}
}

?>