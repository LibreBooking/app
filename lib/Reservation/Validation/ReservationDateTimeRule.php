<?php
class ReservationDateTimeRule implements IReservationValidationRule
{
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservation)
	{
		$startIsBeforeEnd = $reservation->StartDate()->LessThan($reservation->EndDate());
		return new ReservationRuleResult($startIsBeforeEnd, Resources::GetInstance()->GetString('StartDateBeforeEndDateRule'));
	}
}
?>