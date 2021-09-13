<?php

class AccessoryReservation
{
    /**
     * @var string
     */
    private $referenceNumber;

    /**
     * @var int
     */
    private $accessoryId;

    /**
     * @var \Date
     */
    private $startDate;

    /**
     * @var \Date
     */
    private $endDate;

    /**
     * @var int
     */
    private $quantityReserved;

    /**
     * @param string $referenceNumber
     * @param Date $startDate
     * @param Date $endDate
     * @param int $accessoryId
     * @param int $quantityReserved
     */
    public function __construct($referenceNumber, $startDate, $endDate, $accessoryId, $quantityReserved)
    {
        $this->referenceNumber = $referenceNumber;
        $this->accessoryId = $accessoryId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->quantityReserved = $quantityReserved;
    }

    /**
     * @return string
     */
    public function GetReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @return Date
     */
    public function GetStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Date
     */
    public function GetEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function GetAccessoryId()
    {
        return $this->accessoryId;
    }

    /**
     * @return int
     */
    public function QuantityReserved()
    {
        return $this->quantityReserved;
    }

    /**
     * @return DateRange
     */
    public function GetDuration()
    {
        return new DateRange($this->GetStartDate(), $this->GetEndDate());
    }
}
