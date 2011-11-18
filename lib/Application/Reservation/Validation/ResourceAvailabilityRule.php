<?php
class ResourceAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $_repository; 
	
	/**
	 * @var string
	 */
	protected $_timezone;
	
	public function __construct(IReservationViewRepository $repository, $timezone)
	{
		$this->_repository = $repository;
		$this->_timezone = $timezone;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();
		
		$reservations = $reservationSeries->Instances();

		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug("Checking for reservation conflicts, reference number %s", $reservation->ReferenceNumber());
			
			$existingReservations = $this->_repository->GetReservationList($reservation->StartDate(), $reservation->EndDate());

			/** @var ReservationItemView $existingReservation */
			foreach ($existingReservations as $existingReservation)
			{
				if (
					$existingReservation->GetStartDate()->Equals($reservation->EndDate()) ||
					$existingReservation->GetEndDate()->Equals($reservation->StartDate())
				)
				{
					continue;
				}
				
				if ($this->IsInConflict($reservation, $reservationSeries, $existingReservation))
				{
					Log::Debug("Reference number %s conflicts with existing reservation %s", $reservation->ReferenceNumber(), $existingReservation->GetReferenceNumber());
					array_push($conflicts, $existingReservation);
				}
			}
		}
		
		$thereAreConflicts = count($conflicts) > 0;		
		
		if ($thereAreConflicts)
		{
			return new ReservationRuleResult(false, $this->GetErrorString($conflicts));
		}
		
		return new ReservationRuleResult();
	}
	
	protected function IsInConflict(Reservation $instance, ReservationSeries $series, ReservationItemView $existingReservation)
	{
		return ($existingReservation->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($existingReservation->GetResourceId(), $series->AllResourceIds()));
	}

	/**
	 * @param array|ReservationItemView $conflicts
	 * @return string
	 */
	protected function GetErrorString($conflicts)
	{
		$errorString = new StringBuilder();

		$errorString->Append(Resources::GetInstance()->GetString('ConflictingReservationDates'));
		$errorString->Append("\n");
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		
		$dates = array();
		/** @var ReservationItemView $conflict */
		foreach($conflicts as $conflict)
		{
			$dates[] = $conflict->GetStartDate()->ToTimezone($this->_timezone)->Format($format);
		}
		
		$uniqueDates = array_unique($dates);
		sort($uniqueDates);
		
		foreach ($uniqueDates as $date)
		{
			$errorString->Append($date);
			$errorString->Append("\n");
		}
		
		return $errorString->ToString();
	}
}
?>