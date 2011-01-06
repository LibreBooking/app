<?php
interface IReservationPersistenceService
{
	/**
	 * @param ReservationSeries $reservation
	 */
	function Persist($reservation);
}
?>