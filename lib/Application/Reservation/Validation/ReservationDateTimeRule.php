<?php
class ReservationDateTimeRule implements IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$currentInstance = $reservationSeries->CurrentInstance();
		
		$startIsBeforeEnd = $currentInstance->StartDate()->LessThan($currentInstance->EndDate());
		return new ReservationRuleResult($startIsBeforeEnd, Resources::GetInstance()->GetString('StartDateBeforeEndDateRule'));
	}
}
?>