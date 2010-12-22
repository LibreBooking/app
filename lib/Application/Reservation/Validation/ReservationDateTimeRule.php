<?php
class ReservationDateTimeRule implements IReservationValidationRule
{
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservationSeries)
	{
		$currentInstance = $reservationSeries->CurrentInstance();
		
		$startIsBeforeEnd = $currentInstance->StartDate()->LessThan($currentInstance->EndDate());
		return new ReservationRuleResult($startIsBeforeEnd, Resources::GetInstance()->GetString('StartDateBeforeEndDateRule'));
	}
}
?>