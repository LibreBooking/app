<?php

interface IResourceAvailabilityStrategy
{
    /**
     * @param Date $startDate
     * @param Date $endDate
     * @param int[]|int|null $resourceIds
     * @return array|IReservedItemView[]
     */
    public function GetItemsBetween(Date $startDate, Date $endDate, $resourceIds);
}

class ResourceAvailability implements IResourceAvailabilityStrategy
{
    /**
     * @var IReservationViewRepository
     */
    protected $_repository;

    public function __construct(IReservationViewRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function GetItemsBetween(Date $startDate, Date $endDate, $resourceIds)
    {
        $reservations = $this->_repository->GetReservations($startDate, $endDate, null, null, null, $resourceIds);
        $blackouts = $this->_repository->GetBlackoutsWithin(new DateRange($startDate, $endDate), null, $resourceIds);

        return array_merge($reservations, $blackouts);
    }
}
