<?php
interface IReservationPersistenceService
{
	/**
	 * @return ReservationSeries
	 */
	function Load($reservationId);

	/**
	 * @param ReservationSeries $reservation
	 */
	function Persist($reservation);
}
?>