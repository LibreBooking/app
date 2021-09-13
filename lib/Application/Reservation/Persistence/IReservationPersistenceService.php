<?php

interface IReservationPersistenceService
{
    /**
     * @param ReservationSeries|ExistingReservationSeries $reservation
     */
    public function Persist($reservation);
}
