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

interface IDateReservationListing extends IResourceReservationListing
{
	/**
	 * @param int $resourceId
	 * @return IResourceReservationListing
	 */
	public function ForResource($resourceId);
}

interface IResourceReservationListing
{
	/**
	 * @return int
	 */
	public function Count();

	/**
	 * @return array|ReservationListItem[]
	 */
	public function Reservations();
}

interface IReservationListing extends IResourceReservationListing
{
	/**
	 * @param Date $date
	 * @return IReservationListing
	 */
	public function OnDate($date);

	/**
	 * @param int $resourceId
	 * @return IReservationListing
	 */
	public function ForResource($resourceId);

	/**
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|ReservationListItem[]
	 */
	public function OnDateForResource(Date $date, $resourceId);
}

interface IMutableReservationListing extends IReservationListing
{
	/**
	 * @param ReservationItemView $reservation
	 * @return void
	 */
	public function Add($reservation);

	/**
	 * @param BlackoutItemView $blackout
	 * @return void
	 */
	public function AddBlackout($blackout);
}

class EmptyReservationListing implements IReservationListing {

    /**
     * @inheritDoc
     */
    public function Count()
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function Reservations()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function OnDate($date)
    {
        return new EmptyReservationListing();
    }

    /**
     * @inheritDoc
     */
    public function ForResource($resourceId)
    {
        return new EmptyReservationListing();
    }

    /**
     * @inheritDoc
     */
    public function OnDateForResource(Date $date, $resourceId)
    {
        return new EmptyReservationListing();
    }
}