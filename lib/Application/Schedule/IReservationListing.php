<?php
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
	 * @return array[int]ReservationListingItem
	 */
	public function Reservations();
}

interface IReservationListing extends IResourceReservationListing
{
	/**
	 * @param Date $date
	 * @return IDateReservationListing
	 */
	public function OnDate($date);
}

interface IMutableReservationListing extends IReservationListing
{
	/**
	 * @param ReservationItemView $reservation
	 */
	public function Add($reservation);
}
?>