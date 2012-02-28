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

class ReservationFilter
{
	private $startDate = null;
	private $endDate = null;
	private $referenceNumber = null;
	private $scheduleId = null;
	private $resourceId = null;
	private $userId = null;
	/**
	 * @var array|ISqlFilter[]
	 */
	private $_and = array();

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @param int $statusId
	 */
	public function __construct($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null, $statusId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->referenceNumber = $referenceNumber;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
		$this->userId = $userId;
		$this->statusId = $statusId;
	}

	/**
	 * @param ISqlFilter $filter
	 * @return ReservationFilter
	 */
	public function _And(ISqlFilter $filter)
	{
		$this->_and[] = $filter;
		return $this;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!empty($this->startDate)) {
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate)) {
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}
		if (!empty($this->referenceNumber)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $this->referenceNumber));
		}
		if (!empty($this->scheduleId)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}
		if (!empty($this->userId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::USERS, ColumnNames::USER_ID), $this->userId));
		}
		if (!empty($this->statusId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESERVATION_SERIES_ALIAS, ColumnNames::RESERVATION_STATUS), $this->statusId));
		}
		foreach ($this->_and as $and)
		{
			$filter->_And($and);
		}

		return $filter;
	}
}

?>