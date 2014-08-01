<?php
/**
Copyright 2014 Nick Korbel

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

class FakeReservationViewRepository implements IReservationViewRepository
{
	public $_ReservationView;

	public function __construct()
	{
		$this->_ReservationView = new ReservationView();
	}

	public function GetReservationForEditing($referenceNumber)
	{
		return $this->_ReservationView;
	}

	public function GetReservationList(
			Date $startDate,
			Date $endDate,
			$userId = ReservationViewRepository::ALL_USERS,
			$userLevel = ReservationUserLevel::OWNER,
			$scheduleId = ReservationViewRepository::ALL_SCHEDULES,
			$resourceId = ReservationViewRepository::ALL_RESOURCES)
	{
		return array();
	}

	public function GetAccessoryReservationList(Date $startDate, Date $endDate, $accessoryName)
	{
		return array();
	}

	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		return new PageableData();
	}

	public function GetBlackoutsWithin(DateRange $dateRange, $scheduleId = ReservationViewRepository::ALL_SCHEDULES)
	{
		return array();
	}

	public function GetBlackoutList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		return new PageableData();
	}

	public function GetAccessoriesWithin(DateRange $dateRange)
	{
		return array();
	}
}