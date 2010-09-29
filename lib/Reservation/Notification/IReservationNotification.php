<?php
interface IReservationNotification
{
	/**
	 * @param Reservation $reservation
	 */
	function Notify($reservation);
}
?>