<?php
interface IUpdateReservationValidationRule
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	function Validate($reservationSeries);
}
?>