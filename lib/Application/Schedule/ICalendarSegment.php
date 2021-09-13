<?php

interface ICalendarSegment
{
    /**
     * @return Date
     */
    public function FirstDay();

    /**
     * @abstract
     * @return Date
     */
    public function LastDay();

    /**
     * @param $reservations array|CalendarReservation[]
     * @return void
     */
    public function AddReservations($reservations);

    /**
     * @return string|CalendarTypes
     */
    public function GetType();

    /**
     * @return Date
     */
    public function GetPreviousDate();

    /**
     * @return Date
     */
    public function GetNextDate();

    /**
     * @return  array|CalendarReservation[]
     */
    public function Reservations();
}
