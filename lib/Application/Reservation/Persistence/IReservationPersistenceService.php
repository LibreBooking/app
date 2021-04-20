<?php

interface IReservationPersistenceService
{
	/**
	 * @param ReservationSeries|ExistingReservationSeries $reservation
	 */
	function Persist($reservation);
}
