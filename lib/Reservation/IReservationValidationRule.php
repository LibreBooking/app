<?php
interface IReservationValidationRule
{
	/**
	 * @param Reservation $reservation
	 * @return ReservationRuleResult
	 */
	function Validate($reservation);
}
?>