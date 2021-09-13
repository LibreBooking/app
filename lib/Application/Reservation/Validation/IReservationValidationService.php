<?php

interface IReservationValidationService
{
    /**
     * @param ReservationSeries|ExistingReservationSeries $series
     * @param ReservationRetryParameter[]|null $retryParameters
     * @return IReservationValidationResult
     */
    public function Validate($series, $retryParameters = null);
}
