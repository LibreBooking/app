<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class BlackoutFilter
{
	private $startDate = null;
	private $endDate = null;
	private $scheduleId = null;
	private $resourceId = null;

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId
	 * @param int $resourceId
	 */
	public function __construct($startDate = null, $endDate = null, $scheduleId = null, $resourceId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!empty($this->startDate))
		{
			$filter->_And(new SqlFilterGreaterThan(new SqlFilterColumn(TableNames::BLACKOUT_INSTANCES_ALIAS, ColumnNames::RESERVATION_START), $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate))
		{
			$filter->_And(new SqlFilterLessThan(new SqlFilterColumn(TableNames::BLACKOUT_INSTANCES_ALIAS, ColumnNames::RESERVATION_END), $this->endDate->ToDatabase()));
		}
		if (!empty($this->scheduleId))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ID), $this->scheduleId));
		}
		if (!empty($this->resourceId))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS, ColumnNames::RESOURCE_ID), $this->resourceId));
		}

		return $filter;
	}
}