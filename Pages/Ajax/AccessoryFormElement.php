<?php
/**
 * Copyright 2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class AccessoryFormElement
{
	public $Id;
	public $Quantity;
	public $Name;

	public function __construct($formValue)
	{
		$idAndQuantity = $formValue;
		$y = explode('!-!', $idAndQuantity);
		$params = explode(',', $y[1]);
		$id = explode('=', $params[0]);
		$quantity = explode('=', $params[1]);
		$name = explode('=', $params[2]);

		$this->Id = $id[1];
		$this->Quantity = $quantity[1];
		$this->Name = urldecode($name[1]);
	}

	public static function Create($id, $quantity)
	{
		return new AccessoryFormElement("accessory!-!id=$id,quantity=$quantity,name=");
	}
}