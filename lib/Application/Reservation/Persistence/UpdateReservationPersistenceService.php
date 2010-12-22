<?php
class UpdateReservationPersistenceService implements IReservationPersistenceService 
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
		return $this->_repository->LoadById($reservationId);
	}
	
	public function Persist($reservation)
	{
		$this->_repository->Update($reservation);
	}
}
?>