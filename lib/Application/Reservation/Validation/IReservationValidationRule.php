<?php

interface IReservationValidationRule
{
    /**
     * @param ReservationSeries $reservationSeries
     * @param ReservationRetryParameter[]|null $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters);
}
