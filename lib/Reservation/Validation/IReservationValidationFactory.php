<?php
interface IReservationValidationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @return IReservationValidationService
	 */
	function Create($reservationAction);
}
?>