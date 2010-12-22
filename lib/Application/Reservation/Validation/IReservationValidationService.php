<?php
interface IReservationValidationService
{
	/**
	 * @param ReservationSeries $reservation
	 * @return IReservationValidationResult
	 */
	function Validate($reservation);
}
?>