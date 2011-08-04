<?php

class ReservationListing implements IMutableReservationListing
{
	/**
	 * @var array[int]ScheduleReservation
	 */
	private $_reservations = array();
	
	/**
	 * @var array[int]ScheduleReservation
	 */
	private $_reservationByDate = array();
	
	/**
	 * @var array[int]ScheduleReservation
	 */
	private $_reservationByResource = array();

	public function __construct()
	{
		
	}
	
	/**
	 * @param ScheduleReservation $reservation 
	 */
	public function Add($reservation)
	{
		$this->_reservations[] = $reservation;
		$this->_reservationByResource[$reservation->GetResourceId()][] = $reservation;
	}
	
	public function Count()
	{
		return count($this->_reservations);
	}
	
	public function Reservations()
	{
		return $this->_reservations;
	}
	
	public function OnDate($date)
	{
		$reservationListing = new ReservationListing();
		
		/** @var ScheduleReservation $reservation  */
		foreach ($this->_reservations as $reservation)
		{
			if ($reservation->OccursOn($date))
			{
				$reservationListing->Add($reservation);
			}
		}
		
		return $reservationListing;
	}
	
	public function ForResource($resourceId)
	{
		$reservationListing = new ReservationListing();
		
		if (array_key_exists($resourceId, $this->_reservationByResource))
		{
			$reservationListing->_reservations = $this->_reservationByResource[$resourceId];
		}
		
		return $reservationListing;
	}
}

?>