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
	 * @param Date $startDate starting date/time of reservation in timezone of target listing
	 * @param Date $endDate ending date/time of reservation in timezone of target listing
	 * @param ScheduleReservation $reservation 
	 */
	public function Add($startDate, $endDate, $reservation)
	{
		$this->_reservations[] = $reservation;
		$this->_reservationByDate[$startDate->Format('Ymd')][] = $reservation;
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
		throw new Exception("need to ask the reservation if it occurs on this date");
		
		$reservationListing = new ReservationListing();
		$dateKey = $date->Format('Ymd');
		
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