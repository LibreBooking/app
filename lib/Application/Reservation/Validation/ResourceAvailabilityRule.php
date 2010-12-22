<?php
class ResourceAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository; 
	
	/**
	 * @var string
	 */
	private $_timezone;
	
	public function __construct(IReservationRepository $repository, $timezone)
	{
		$this->_repository = $repository;
		$this->_timezone = $timezone;
	}
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();
		$conflictingIds = array();
		
		$reservationResources = $reservationSeries->Resources();
		$reservationResources[] = $reservationSeries->ResourceId();
		
		$reservations = $reservationSeries->Instances();
		
		foreach ($reservations as $reservation)
		{
			$reservations = $this->_repository->GetWithin($reservation->StartDate(), $reservation->EndDate());
			
			foreach ($reservations as $scheduleReservation)
			{
				if (false !== array_search($scheduleReservation->GetResourceId(), $reservationResources))
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
	
	private function GetErrorString($conflicts)
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