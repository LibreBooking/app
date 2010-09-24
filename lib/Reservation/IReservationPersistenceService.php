<?php
interface IReservationPersistenceService
{
	/**
	 * @return Reservation
	 */
	function Load($reservationId);

	/**
	 * @param Reservation $reservation
	 */
	function Persist($reservation);
}
?>