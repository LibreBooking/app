<?php
interface IReservationPersistenceFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @return IReservationPersistenceService
	 */
	function Create($reservationAction);
}

?>