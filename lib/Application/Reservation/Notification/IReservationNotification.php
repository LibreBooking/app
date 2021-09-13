<?php

interface IReservationNotification
{
    /**
     * @param ReservationSeries $reservationSeries
     */
    public function Notify($reservationSeries);
}
