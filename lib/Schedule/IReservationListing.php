<?php
interface IDateReservationListing extends IResourceReservationListing
{
	/**
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
	 * @param $date string
	 * @return IDateReservationListing
	 */
	public function OnDate($date);
}
?>