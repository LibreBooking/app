<?php

interface IReservationPersistenceFactory
{
    /**
     * @param ReservationAction $reservationAction
     * @return IReservationPersistenceService
     */
    public function Create($reservationAction);
}
