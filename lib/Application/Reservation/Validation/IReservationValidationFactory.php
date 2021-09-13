<?php

interface IReservationValidationFactory
{
    /**
     * @param ReservationAction $reservationAction
     * @param UserSession $userSession
     * @return IReservationValidationService
     */
    public function Create($reservationAction, $userSession);
}
