<?php

interface IReservationValidationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	function Create($reservationAction, $userSession);
}
