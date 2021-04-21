<?php

interface IReservationNotification
{
	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries);
}
