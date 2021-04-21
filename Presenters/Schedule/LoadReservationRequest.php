<?php

class LoadReservationRequest
{
    /**
     * @var DateRange
     */
    private $dateRange;
    /**
     * @var int
     */
    private $scheduleId;
    /**
     * @var int[]
     */
    private $resourceIds;
    /**
     * @var Date[]
     */
    private $specificDates;

    /**
     * @var int|null
     */
    private $ownerId;

    /**
     * @var int|null
     */
    private $participantId;

    /**
     * @param DateRange $dateRange
     * @param int $scheduleId
     * @param int[] $resourceIds
     * @param Date[] $specificDates
     * @param int|null $ownerId
     * @param int|null $participantId
     */
    public function __construct($dateRange, $scheduleId, $resourceIds, $specificDates, $ownerId, $participantId)
    {
        $this->dateRange = $dateRange;
        $this->scheduleId = $scheduleId;
        $this->resourceIds = $resourceIds;
        $this->specificDates = $specificDates;
        $this->ownerId = $ownerId;
        $this->participantId = $participantId;
    }

    /**
     * @return DateRange
     */
    public function DateRange()
    {
        return $this->dateRange;
    }

    /**
     * @return int
     */
    public function ScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * @return int[]
     */
    public function ResourceIds()
    {
        return $this->resourceIds;
    }

    /**
     * @return Date[]
     */
    public function SpecificDates()
    {
        return $this->specificDates;
    }

    /**
     * @return int
     */
    public function OwnerId()
    {
        return $this->ownerId;
    }

    public function ParticipantId()
    {
        return $this->participantId;
    }
}

class LoadReservationRequestBuilder
{
    /**
     * @var Date
     */
    private $start;
    /**
     * @var Date
     */
    private $end;
    /**
     * @var int[]
     */
    private $resourceIds = [];
    /**
     * @var int
     */
    private $scheduleId;
    /**
     * @var Date[]
     */
    private $specificDates = [];
    /**
     * @var int|null
     */
    private $ownerId;
    /**
     * @var int|null
     */
    private $participantId;

    public function WithRange(Date $start, Date $end)
    {
        $this->start = $start;
        $this->end = $end->AddDays(1);
        return $this;
    }

    /**
     * @param $resourceIds int[]
     * @return LoadReservationRequestBuilder
     */
    public function WithResources($resourceIds)
    {
        $this->resourceIds = $resourceIds;
        return $this;
    }


    public function WithScheduleId($scheduleId)
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }

    /**
     * @param Date[] $dates
     * @return LoadReservationRequestBuilder
     */
    public function WithSpecificDates($dates)
    {
        $this->specificDates = $dates;
        return $this;
    }

    /**
     * @param $owner string
     * @return LoadReservationRequestBuilder
     */
    public function WithOwner($owner)
    {
        if (!empty($owner)) {
            $this->ownerId = intval($owner);
        }

        return $this;
    }

    /**
     * @param $participant string
     * @return LoadReservationRequestBuilder
     */
    public function WithParticipant($participant)
    {
        if (!empty($participant)) {
            $this->participantId = intval($participant);
        }

        return $this;
    }

    public function Build()
    {
        return new LoadReservationRequest(new DateRange($this->start, $this->end), $this->scheduleId, $this->resourceIds, $this->specificDates, $this->ownerId, $this->participantId);
    }
}
