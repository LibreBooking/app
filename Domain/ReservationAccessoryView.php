<?php

class ReservationAccessoryView
{
    /**
     * @var int
     */
    public $AccessoryId;

    /**
     * @var int
     */
    public $QuantityReserved;

    /**
     * @var int
     */
    public $QuantityAvailable;

    /**
     * @var null|string
     */
    public $Name;

    /**
     * @param int $accessoryId
     * @param int $quantityReserved
     * @param string $accessoryName
     * @param int $quantityAvailable
     */
    public function __construct($accessoryId, $quantityReserved, $accessoryName, $quantityAvailable)
    {
        $this->AccessoryId = $accessoryId;
        $this->QuantityReserved = $quantityReserved;
        $this->Name = $accessoryName;
        $this->QuantityAvailable = $quantityAvailable;
    }
}
