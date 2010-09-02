<?php
interface IReservationValidationService
{
	/**
	 * @param $reservation
	 * @return IReservationValidationResult
	 */
	function Validate($reservation);
}
?>