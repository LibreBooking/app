<?php
class ReservationService implements IReservationService
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository;
	
	/**
	 * @var IReservationCoordinatorFactory
	 */
	private $_coordinatorFactory;
	
	public function __construct(IReservationRepository $repository, IReservationCoordinatorFactory $coordinatorFactory)
	{
		$this->_repository = $repository;
		$this->_coordinatorFactory = $coordinatorFactory;
	}
		
	public function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone)
	{
		$reservations = $this->_repository->GetWithin($dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd(), $scheduleId);
		
		$coordinator = $this->_coordinatorFactory->CreateCoordinator();
		
		foreach ($reservations as $reservation)
		{
			$coordinator->AddReservation($reservation);
		}
		
		return $coordinator->Arrange($targetTimezone, $dateRangeUtc);
	}
}

interface IReservationService
{
	/**
	 * @param DateRange $dateRangeUtc range of dates to search against in UTC
	 * @param int $scheduleId
	 * @param string $targetTimezone timezone to convert the results to
	 * @return IReservationListing
	 */
	function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone);
}
?>