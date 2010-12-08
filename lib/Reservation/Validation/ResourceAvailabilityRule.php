<?php
class ResourceAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository; 
	
	public function __construct(IReservationRepository $repository)
	{
		$this->_repository = $repository;
	}
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservation)
	{
		$conflicts = array();
		$conflictingIds = array();
		
		$reservationResources = $reservation->Resources();
		$reservationResources[] = $reservation->ResourceId();
		
		$dates = $reservation->RepeatedDates();
		array_unshift($dates, new DateRange($reservation->StartDate(), $reservation->EndDate()));
		
		foreach ($dates as $date)
		{
			$reservations = $this->_repository->GetWithin($date->GetBegin(), $date->GetEnd());
			
			foreach ($reservations as $scheduleReservation)
			{
				$reservationId = $scheduleReservation->GetReservationId();
				
				if (!array_key_exists($reservationId, $conflictingIds) && false !== array_search($scheduleReservation->GetResourceId(), $reservationResources))
				{
					$conflictingIds[$reservationId] = true;
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
		
		foreach($conflicts as $conflict)
		{
			$errorString->Append($conflict->GetStartDate()->Format($format));
			$errorString->Append("\n");
		}
		
		return $errorString->ToString();
	}
}
?>