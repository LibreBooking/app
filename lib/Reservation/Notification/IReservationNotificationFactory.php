<?php
interface IReservationNotificationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @return IReservationNotificationService
	 */
	function Create($reservationAction);
}
?>