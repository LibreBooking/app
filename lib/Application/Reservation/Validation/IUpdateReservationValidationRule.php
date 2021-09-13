<?php

interface IUpdateReservationValidationRule
{
    /**
     * @param ExistingReservationSeries $reservationSeries
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries);
}
