<?php

class BlackoutFilter
{
    private $startDate = null;
    private $endDate = null;
    private $scheduleId = null;
    private $resourceId = null;

    /**
     * @param Date $startDate
     * @param Date $endDate
     * @param int $scheduleId
     * @param int $resourceId
     */
    public function __construct($startDate = null, $endDate = null, $scheduleId = null, $resourceId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->scheduleId = $scheduleId;
        $this->resourceId = $resourceId;
    }

    public function GetFilter()
    {
        $filter = new SqlFilterNull();

        if (!empty($this->startDate)) {
            $filter->_And(new SqlFilterGreaterThan(new SqlFilterColumn(TableNames::BLACKOUT_INSTANCES_ALIAS, ColumnNames::RESERVATION_START), $this->startDate->ToDatabase()));
        }
        if (!empty($this->endDate)) {
            $filter->_And(new SqlFilterLessThan(new SqlFilterColumn(TableNames::BLACKOUT_INSTANCES_ALIAS, ColumnNames::RESERVATION_END), $this->endDate->ToDatabase()));
        }
        if (!empty($this->scheduleId)) {
            $filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ID), $this->scheduleId));
        }
        if (!empty($this->resourceId)) {
            $filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS, ColumnNames::RESOURCE_ID), $this->resourceId));
        }

        return $filter;
    }
}
