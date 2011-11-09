<?php

class Accessory
{
	/**
	 * @param int $id
	 * @param string $name
	 * @param int $quantityAvailable
	 */
	public function __construct($id, $name, $quantityAvailable)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->QuantityAvailable = $quantityAvailable;
	}
}

?>