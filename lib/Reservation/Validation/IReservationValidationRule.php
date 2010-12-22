<?php
interface IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	function Validate($reservationSeries);
}
?>