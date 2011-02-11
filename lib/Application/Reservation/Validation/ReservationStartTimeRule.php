<?php
class ReservationStartTimeRule implements IReservationValidationRule
{
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservationSeries)
	{
		$currentInstance = $reservationSeries->CurrentInstance();
		
		$startIsInFuture = $currentInstance->StartDate()->Compare(Date::Now()) >= 0;
		return new ReservationRuleResult($startIsInFuture, Resources::GetInstance()->GetString('StartIsInPast'));
	}
}
?>