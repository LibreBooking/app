<?php

class ReservationListing implements IReservationListing
{
	/**
	 * @var array[int]ReservationListingItem
	 */
	private $_reservations = array();
	
	/**
	 * @var array[int]ReservationListingItem
	 */
	private $_reservationByDate = array();
	
	/**
	 * @var array[int]ReservationListingItem
	 */
	private $_reservationByResource = array();
	
	/**
	 * @param $startDate Date
	 * @param $endDate Date
	 * @param $reservation ScheduleReservation
	 */
	public function Add($startDate, $endDate, $reservation)
	{
		$rli = new ReservationListingItem($reservation, $startDate, $endDate);
		
		$this->_reservations[] = $rli;
		$this->_reservationByDate[$startDate->Format('Ymd')][] = $rli;
		$this->_reservationByResource[$reservation->GetResourceId()][] = $rli;
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
		$dateKey = Date::Parse($date)->Format('Ymd');
		
		if (!array_key_exists($dateKey, $this->_reservationByDate))
		{
			return $reservationListing;
		}		
		
		$reservationListing->_reservations = $this->_reservationByDate[$dateKey];
		
		foreach ($reservationListing->_reservations as $rli)
		{
			$reservationListing->_reservationByResource[$rli->Reservation->GetResourceId()][] = $rli;
		}
		
		return $reservationListing;
	}
	
	public function ForResource($resourceId)
	{
		$reservationListing = new ReservationListing();
		$reservationListing->_reservations = $this->_reservationByResource[$resourceId];
		
		return $reservationListing;
	}
}

?>