<?php
class ResourceAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationRepository
	 */
	protected $_repository; 
	
	/**
	 * @var string
	 */
	protected $_timezone;
	
	public function __construct(IReservationRepository $repository, $timezone)
	{
		$this->_repository = $repository;
		$this->_timezone = $timezone;
	}
	
	/**
	 * @see IReservationValidationRule::Validate()
	 * @param ReservationSeries $reservationSeries
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();
		
		$reservations = $reservationSeries->Instances();

		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug($reservation->ReferenceNumber());
			
			$scheduleReservations = $this->_repository->GetWithin($reservation->StartDate(), $reservation->EndDate());

			/** @var ScheduleReservation $scheduleReservation */
			foreach ($scheduleReservations as $scheduleReservation)
			{
				if (
					$scheduleReservation->GetStartDate()->Equals($reservation->EndDate()) ||
					$scheduleReservation->GetEndDate()->Equals($reservation->StartDate())
				)
				{
					continue;
				}
				
				if ($this->IsInConflict($reservation, $reservationSeries, $scheduleReservation))
				{
					array_push($conflicts, $scheduleReservation);
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
	
	protected function IsInConflict(Reservation $instance, ReservationSeries $series, ScheduleReservation $scheduleReservation)
	{
		return ($scheduleReservation->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($scheduleReservation->GetResourceId(), $series->Resources()));
	}
	
	protected function GetErrorString($conflicts)
	{
		$errorString = new StringBuilder();

		$errorString->Append(Resources::GetInstance()->GetString('ConflictingReservationDates'));
		$errorString->Append("\n");
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		
		$dates = array();
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