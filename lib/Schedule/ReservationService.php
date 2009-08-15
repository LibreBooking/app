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
	
	public function __construct(
		IReservationRepository $repository, 
		IReservationCoordinatorFactory $coordinatorFactory)
	{
		$this->_repository = $repository;
		$this->_coordinatorFactory = $coordinatorFactory;
	}
		
	public function GetReservations(
		DateRange $dateRangeUtc, 
		$scheduleId, 
		$targetTimezone, 
		IScheduleLayout $layout)
	{
		$reservations = $this->_repository->GetWithin($dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd(), $scheduleId);
		
		$coordinator = $this->_coordinatorFactory->CreateCoordinator();
		
		foreach ($reservations as $reservation)
		{
			$coordinator->AddReservation($reservation);
		}
		
		$coordinator->Arrange($timezone, $dateRangeUtc);
		
		throw new Exception("need to somehow bind reservations to a layout");
	}
}

interface IReservationService
{
	/**
	 * @param DateRange $dateRangeUtc range of dates to search against in UTC
	 * @param int $scheduleId
	 * @param string $targetTimezone timezone to convert the results to
	 * @param IScheduleLayout the layout to bind the reservations to
	 * @return IReservationListing
	 */
	function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone, IScheduleLayout $layout);
}
?>