<?php

class ReservationAccessoryRequest
{
	public $accessoryId;
	public $quantityRequested;

	public function __construct($accessoryId, $quantityRequested)
	{
		$this->accessoryId = $accessoryId;
		$this->quantityRequested = $quantityRequested;
	}
}

