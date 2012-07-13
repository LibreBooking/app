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

class SavedReport
{
	/**
	 * @var string
	 */
	private $reportName;
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var Report_Usage
	 */
	private $usage;
	/**
	 * @var Report_ResultSelection
	 */
	private $selection;
	/**
	 * @var Report_GroupBy
	 */
	private $groupBy;

	/**
	 * @var Report_Range
	 */
	private $range;

	/**
	 * @var Report_Filter
	 */
	private $filter;

	/**
	 * @var Date
	 */
	private $dateCreated;


	public function __construct($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$this->reportName = $reportName;
		$this->userId = $userId;
		$this->usage = $usage;
		$this->selection = $selection;
		$this->groupBy = $groupBy;
		$this->range = $range;
		$this->filter = $filter;
		$this->dateCreated = Date::Now();
	}

	/**
	 * @return Date
	 */
	public function DateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @return Report_Usage
	 */
	public function Usage()
	{
		return $this->usage;
	}

	/**
	 * @return Report_ResultSelection
	 */
	public function Selection()
	{
		return $this->selection;
	}

	/**
	 * @return Report_GroupBy
	 */
	public function GroupBy()
	{
		return $this->groupBy;
	}

	/**
	 * @return Report_Range
	 */
	public function Range()
	{
		return $this->range;
	}

	/**
	 * @return Date
	 */
	public function RangeStart()
	{
		return $this->range->Start();
	}

	/**
	 * @return Date
	 */
	public function RangeEnd()
	{
		return $this->range->End();
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->filter->ResourceId();
	}

	/**
	 * @return int|null
	 */
	public function ScheduleId()
	{
		return $this->filter->ScheduleId();
	}

	/**
	 * @return int|null
	 */
	public function UserId()
	{
		return $this->filter->UserId();
	}

	/**
	 * @return int|null
	 */
	public function GroupId()
	{
		return $this->filter->GroupId();
	}

	/**
	 * @return int|null
	 */
	public function AccessoryId()
	{
		return $this->filter->AccessoryId();
	}

	/**
	 * @return string
	 */
	public function ReportName()
	{
		return $this->reportName;
	}

	/**
	 * @return int
	 */
	public function OwnerId()
	{
		return $this->userId;
	}
}

?>