<?php 

interface IReservationListingFactory
{
	/**
	 * @param string $targetTimezone
	 * @return IMutableReservationListing
	 */
	function CreateReservationListing($targetTimezone);
}

class ReservationListingFactory implements IReservationListingFactory
{
	public function CreateReservationListing($targetTimezone)
	{
		return new ReservationListing($targetTimezone);
	}
}

?>