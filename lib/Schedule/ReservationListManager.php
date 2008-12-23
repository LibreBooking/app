<?php
class ReservationListManager
{
	/**
	 * @var IReservationRepository
	 */
	private $_reservationRepository;
	
	/**
	 * @var Schedule
	 */
	private $_schedule;
	
	/**
	 * @param IReservationRepository $reservationRepository
	 * @param Schedule $schedule
	 */
	public function __construct(IReservationRepository $reservationRepository, Schedule $schedule)
	{
		$this->_reservationRepository = $reservationRepository;
		$this->_schedule = $schedule;
	}
	
	/**
	 * @return array of ReservationListGroup
	 */
	public function BuildReservationGroups()
	{
		return array();
	}
}
?>