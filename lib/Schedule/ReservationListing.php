<?php

class ReservationListing implements IReservationListing
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
	
	private $_timezone;
	
	/**
	 * @param $timezone string
	 */
	public function __construct($timezone)
	{
		$this->_timezone = $timezone;
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
		$reservationListing = new ReservationListing($this->_timezone);
		foreach ($this->_reservations as $reservation)
		{
			if ($reservation->OccursOn($date))
			{
				$reservationListing->Add($date, $reservation);
			}
		}
		
		return $reservationListing;
	}
	
	public function ForResource($resourceId)
	{
		$reservationListing = new ReservationListing($this->_timezone);
		
		if (array_key_exists($resourceId, $this->_reservationByResource))
		{
			$reservationListing->_reservations = $this->_reservationByResource[$resourceId];
		}
		
		return $reservationListing;
	}
}

?>