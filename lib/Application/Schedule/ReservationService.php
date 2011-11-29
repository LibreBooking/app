<?php
class ReservationService implements IReservationService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $_repository;
	
	/**
	 * @var IReservationListingFactory
	 */
	private $_coordinatorFactory;
	
	public function __construct(IReservationViewRepository $repository, IReservationListingFactory $listingFactory)
	{
		$this->_repository = $repository;
		$this->_coordinatorFactory = $listingFactory;
	}
		
	public function GetReservations(DateRange $dateRangeUtc, $scheduleId, $targetTimezone)
	{
		$reservationListing = $this->_coordinatorFactory->CreateReservationListing($targetTimezone);

		$reservations = $this->_repository->GetReservationList($dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd(), null, null, $scheduleId, null);
		Log::Debug("Found %s reservations for schedule %s between %s and %s", count($reservations), $scheduleId, $dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd());

		foreach ($reservations as $reservation)
		{
			$reservationListing->Add($reservation);
		}

		$blackouts = $this->_repository->GetBlackoutsWithin($dateRangeUtc, $scheduleId);
		Log::Debug("Found %s blackouts for schedule %s between %s and %s", count($blackouts), $scheduleId, $dateRangeUtc->GetBegin(), $dateRangeUtc->GetEnd());

		foreach ($blackouts as $blackout)
		{
			$reservationListing->AddBlackout($blackout);
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