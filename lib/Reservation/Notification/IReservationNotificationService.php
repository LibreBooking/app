<?php
interface IReservationNotificationService
{
	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries);
}
?>