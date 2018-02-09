<?php

/**
 * Copyright 2014-2018 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class FakeReservationViewRepository implements IReservationViewRepository
{
    public $_ReservationView;

    /**
     * @var ReservationItemView[]
     */
    public $_Reservations = array();

    /**
     * @var BlackoutItemView[]
     */
    public $_Blackouts = array();

    public $_LastRange;

	/**
	 * @var AccessoryReservation[]
	 */
	public $_AccessoryReservations = array();

	public $_Filter;

	/**
	 * @var PageableData
	 */
	public $_FilterResults;

	public function __construct()
    {
        $this->_ReservationView = new ReservationView();
        $this->_FilterResults= new PageableData();
    }

    public function GetReservationForEditing($referenceNumber)
    {
        return $this->_ReservationView;
    }

    public function GetReservations(
			Date $startDate,
			Date $endDate,
			$userId = ReservationViewRepository::ALL_USERS,
			$userLevel = ReservationUserLevel::OWNER,
			$scheduleIds = ReservationViewRepository::ALL_SCHEDULES,
			$resourceIds = ReservationViewRepository::ALL_RESOURCES)
    {
        $this->_LastRange = new DateRange($startDate, $endDate);
        return $this->_Reservations;
    }

    public function GetAccessoryReservationList(Date $startDate, Date $endDate, $accessoryName)
    {
        return array();
    }

    public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
    {
    	$this->_Filter = $filter;
        return $this->_FilterResults;
    }

    public function GetBlackoutsWithin(DateRange $dateRange, $scheduleId = ReservationViewRepository::ALL_SCHEDULES)
    {
        return $this->_Blackouts;
    }

    public function GetBlackoutList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
    {
        return new PageableData();
    }

    public function GetAccessoriesWithin(DateRange $dateRange)
    {
        return $this->_AccessoryReservations;
    }
}