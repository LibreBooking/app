<?php
class ReservationService implements IReservationService
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository;
	
	/**
	 * @var IReservationListingFactory
	 */
	private $_listingFactory;
	
	public function __construct(IReservationRepository $repository, IReservationListingFactory $listingFactory)
	{
		$this->_repository = $repository;
		$this->_coordinatorFactory = $listingFactory;
	}
		
	public function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone)
	{
		$reservations = $this->_repository->GetWithin($dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd(), $scheduleId);
		
		Log::Debug("Found %s reservations for schedule %s between %s and %s", count($reservations), $scheduleId, $dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd());
		
		$reservationListing = $this->_coordinatorFactory->CreateReservationListing($targetTimezone);
		
		foreach ($reservations as $reservation)
		{
			$reservationListing->Add($reservation);
		}
		
		return $reservationListing;
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