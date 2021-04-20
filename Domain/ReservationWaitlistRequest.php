<?php

class ReservationWaitlistRequest
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var Date
     */
    private $startDate;
    /**
     * @var Date
     */
    private $endDate;

    /**
     * @var int
     */
    private $resourceId;

    /**
     * @param int $id
     * @param int $userId
     * @param Date $startDate
     * @param Date $endDate
     * @param int $resourceId
     */
    public function __construct($id, $userId, $startDate, $endDate, $resourceId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->resourceId = $resourceId;
    }

    /**
     * @param array $row
     * @return ReservationWaitlistRequest
     */
    public static function FromRow($row)
    {
        return new ReservationWaitlistRequest(
            $row[ColumnNames::RESERVATION_WAITLIST_REQUEST_ID],
            $row[ColumnNames::USER_ID],
            Date::FromDatabase($row[ColumnNames::RESERVATION_START]),
            Date::FromDatabase($row[ColumnNames::RESERVATION_END]),
            $row[ColumnNames::RESOURCE_ID]
        );
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function UserId()
    {
        return $this->userId;
    }

    /**
     * @return Date
     */
    public function StartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Date
     */
    public function EndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function ResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param int $userId
     * @param Date $startDate
     * @param Date $endDate
     * @param int $resourceId
     * @return ReservationWaitlistRequest
     */
    public static function Create($userId, $startDate, $endDate, $resourceId)
    {
        return new ReservationWaitlistRequest(0, $userId, $startDate, $endDate, $resourceId);
    }

    /**
     * @param int $id
     */
    public function WithId($id)
    {
        $this->id = $id;
    }

    /**
     * @return DateRange
     */
    public function Duration()
    {
        return new DateRange($this->StartDate(), $this->EndDate());
    }
}
