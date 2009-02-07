<?php
class ReservationListing
{
	/**
	 * @var array[int]ReservationListingItem
	 */
	private $_reservations = array();
	
	public function Add($startDate, $endDate, $reservation)
	{
		$this->_reservations[] = new ReservationListingItem($reservation, $startDate, $endDate);
	}
	
	public function Count()
	{
		return count($this->_reservations);
	}
	
	/**
	 * @return array[int]ReservationListingItem
	 */
	public function Reservations()
	{
		return $this->_reservations;
	}
}

class ReservationListingItem
{
	/**
	 * @var ScheduleReservation
	 */
	public $Reservation;
	
	/**
	 * @var Date
	 */
	public $DisplayStartDate;
	
	/**
	 * @var Date
	 */
	public $DisplayEndDate;
	
	public function __construct(ScheduleReservation $reservation, Date $dispayStartDate, Date $displayEndDate)
	{
		$this->Reservation = $reservation;
		$this->DisplayStartDate = $dispayStartDate;
		$this->DisplayEndDate = $displayEndDate;
	}
}
?>