<?php

interface IReservationListingFactory
{
    /**
     * @param string $targetTimezone
     * @param DateRange|null $acceptableDateRange
     * @return IMutableReservationListing
     */
    public function CreateReservationListing($targetTimezone, $acceptableDateRange = null);
}

class ReservationListingFactory implements IReservationListingFactory
{
    public function CreateReservationListing($targetTimezone, $acceptableDateRange = null)
    {
        return new ReservationListing($targetTimezone, $acceptableDateRange);
    }
}
