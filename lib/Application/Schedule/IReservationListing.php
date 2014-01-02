<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @abstract
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|ReservationListItem[]
	 */
	public function OnDateForResource(Date $date, $resourceId);
}

interface IMutableReservationListing extends IReservationListing
{
	/**
	 * @abstract
	 * @param ReservationItemView $reservation
	 * @return void
	 */
	public function Add($reservation);

	/**
	 * @abstract
	 * @param BlackoutItemView $blackout
	 * @return void
	 */
	public function AddBlackout($blackout);
}
?>