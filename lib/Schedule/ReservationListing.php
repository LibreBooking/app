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
	
	/**
	 * @param ScheduleReservation $reservation 
	 */
	public function Add($reservation)
	{
		$this->_reservations[] = $reservation;
		$this->_reservationByDate[$reservation->GetStartDate()->ToUtc()->Format('Ymd')][] = $reservation;
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
		$dateKey = $date->ToUtc()->Format('Ymd');
		
		if (!array_key_exists($dateKey, $this->_reservationByDate))
		{
			return $reservationListing;
		}		
		
		$reservationListing->_reservations = $this->_reservationByDate[$dateKey];
		
		foreach ($reservationListing->_reservations as $rli)
		{
			$reservationListing->_reservationByResource[$rli->GetResourceId()][] = $rli;
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