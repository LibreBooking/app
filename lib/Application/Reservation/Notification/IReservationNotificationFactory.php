<?php

interface IReservationNotificationFactory
{
    /**
     * @param ReservationAction $reservationAction
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function Create($reservationAction, $userSession);
}
