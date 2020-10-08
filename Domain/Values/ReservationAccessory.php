<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ReservationAccessory
{
	/**
	 * @var Accessory
	 */
	public $Accessory;

	/**
	 * @var int
	 */
	public $AccessoryId;

	/**
	 * @var int
	 */
	public $QuantityReserved;

	/**
	 * @param Accessory $accessory
	 * @param int $quantityReserved
	 */
	public function __construct(Accessory $accessory, $quantityReserved)
	{
		$this->Accessory = $accessory;
		$this->AccessoryId = $accessory->GetId();
		$this->QuantityReserved = $quantityReserved;
	}

	public function __toString()
	{
        return sprintf("ReservationAccessory id:%d quantity reserved:%d", $this->Accessory->GetId(), $this->QuantityReserved);
    }
}
