<?php
interface IReservationNotificationService
{
	/**
	 * @param Reservation $reservation
	 */
	function Notify($reservation);
}
?>