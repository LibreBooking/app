<?php
class AddReservationPersistenceService implements IReservationPersistenceService 
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository;
	
	public function __construct(IReservationRepository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function Load($reservationId)
	{
		return new Reservation();
	}
	
	public function Persist($reservation)
	{
		$this->_repository->Add($reservation);
	}
}
?>