<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class FakeReservationService implements IReservationService
{
    /**
     * @var FakeReservationListing
     */
    public $_ReservationListing;

    /**
     * @var DateRange
     */
    public $_LastDateRange;

    /**
     * @var int
     */
    public $_LastScheduleId;

    /**
     * @var string
     */
    public $_LastTimezone;

    /**
     * @var int
     */
    public $_LastResourceId;

    /**
     * @var ExistingReservationSeries
     */
    public $_Reservation;

    public function __construct()
    {
        $this->_ReservationListing = new FakeReservationListing();
    }

    /**
     * @param DateRange $dateRangeUtc range of dates to search against in UTC
     * @param int $scheduleId
     * @param string $targetTimezone timezone to convert the results to
     * @param null|int $resourceIds
     * @return IReservationListing
     */
    function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone, $resourceIds = null)
    {
        $this->_LastDateRange = $dateRangeUtc;
        $this->_LastScheduleId = $scheduleId;
        $this->_LastTimezone = $targetTimezone;
        $this->_LastResourceId = $resourceIds;

        return $this->_ReservationListing;
    }
}

class FakeReservationListing implements IReservationListing
{

    /**
     * @var array|ReservationListItem[]

     */
    public $_Reservations = array();

    /**
     * @return int
     */
    public function Count()
    {
        return count($this->_Reservations);
    }

    /**
     * @return array|ReservationListItem[]
     */
    public function Reservations()
    {
        return $this->_Reservations;
    }

    /**
     * @param Date $date
     * @return IReservationListing
     */
    public function OnDate($date)
    {
        return $this;
    }

    /**
     * @param int $resourceId
     * @return IReservationListing
     */
    public function ForResource($resourceId)
    {
        return $this;
    }

    /**
     * @param Date $date
     * @param int $resourceId
     * @return array|ReservationListItem[]
     */
    public function OnDateForResource(Date $date, $resourceId)
    {
        return $this->_Reservations;
    }
}