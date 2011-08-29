<?php
class ReservationStartTimeRule implements IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$currentInstance = $reservationSeries->CurrentInstance();

		Log::Debug("Start Time Rule: Comparing %s to %s", $currentInstance->StartDate(), Date::Now());
		
		$startIsInFuture = $currentInstance->StartDate()->Compare(Date::Now()) >= 0;
		return new ReservationRuleResult($startIsInFuture, Resources::GetInstance()->GetString('StartIsInPast'));
	}
}
?>