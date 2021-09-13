<?php

class ExistingResourceAvailabilityRule extends ResourceAvailabilityRule implements IUpdateReservationValidationRule
{
    /**
     * @param ReservationSeries|ExistingReservationSeries $reservationSeries
     * @param null|ReservationRetryParameter[] $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters = null)
    {
        return parent::Validate($reservationSeries, $retryParameters);
    }

    /**
     * @param Reservation $instance
     * @param ReservationSeries $series
     * @param IReservedItemView $existingItem
     * @param BookableResource[] $keyedResources
     * @return bool
     */
    protected function IsInConflict(Reservation $instance, ReservationSeries $series, IReservedItemView $existingItem, $keyedResources)
    {
        // this class used to add logic, but that has been moved to the ReservationConflictIdentifier
        return parent::IsInConflict($instance, $series, $existingItem, $keyedResources);
    }
}
