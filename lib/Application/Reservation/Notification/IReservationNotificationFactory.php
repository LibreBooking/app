<?php

interface IReservationNotificationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @param UserSession $userSession
	 * @return IReservationNotificationService
	 */
	function Create($reservationAction, $userSession);
}
