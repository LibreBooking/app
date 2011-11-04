<?php
class ReservationAccessory
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
	 * @param int $accessoryId
	 * @param int $quantityReserved
	 */
	public function __construct($accessoryId, $quantityReserved)
	{
		$this->AccessoryId = $accessoryId;
		$this->QuantityReserved = $quantityReserved;
	}

	public function __toString()
	{
        return sprintf("ReservationAccessory id:%d quantity reserved:%d", $this->AccessoryId, $this->QuantityReserved);
    }
}

?>