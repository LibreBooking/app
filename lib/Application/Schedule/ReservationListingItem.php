<?php
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