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
		$conflicts = $this->_repository->GetWithin($reservation->StartDate(), $reservation->EndDate());
		
		$repeatDates = $reservation->RepeatedDates();
		
		foreach ($repeatDates as $repeatDate)
		{
			$repeatConflicts = $this->_repository->GetWithin($repeatDate->GetBegin(), $repeatDate->GetEnd());
			array_push($repeatConflicts, $conflicts);
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