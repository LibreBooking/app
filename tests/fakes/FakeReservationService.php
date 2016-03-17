<?php

/**
 * Copyright 2016 Nick Korbel
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

	public function __construct()
	{
		$this->_ReservationListing = new FakeReservationListing();
	}

	/**
	 * @param DateRange $dateRangeUtc range of dates to search against in UTC
	 * @param int $scheduleId
	 * @param string $targetTimezone timezone to convert the results to
	 * @param null|int $resourceId
	 * @return IReservationListing
	 */
	function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone, $resourceId = null)
	{
		$this->_LastDateRange = $dateRangeUtc;
		$this->_LastScheduleId = $scheduleId;
		$this->_LastTimezone = $targetTimezone;
		$this->_LastResourceId = $resourceId;

		return $this->_ReservationListing;
	}
}

class FakeReservationListing implements IReservationListing
{

	/**
	 * @return int
	 */
	public function Count()
	{
		// TODO: Implement Count() method.
	}

	/**
	 * @return array|ReservationListItem[]
	 */
	public function Reservations()
	{
		// TODO: Implement Reservations() method.
	}

	/**
	 * @param Date $date
	 * @return IReservationListing
	 */
	public function OnDate($date)
	{
		// TODO: Implement OnDate() method.
	}

	/**
	 * @param int $resourceId
	 * @return IReservationListing
	 */
	public function ForResource($resourceId)
	{
		// TODO: Implement ForResource() method.
	}

	/**
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|ReservationListItem[]
	 */
	public function OnDateForResource(Date $date, $resourceId)
	{
		// TODO: Implement OnDateForResource() method.
	}
}