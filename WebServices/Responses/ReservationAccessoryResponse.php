<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ReservationAccessoryResponse extends RestResponse
{
	public $id;
	public $name;
	public $quantityAvailable;
	public $quantityReserved;

	public function __construct(IRestServer $server, $id, $name, $quantityReserved, $quantityAvailable)
	{
		$this->id = $id;
		$this->name = $name;
		$this->quantityReserved = $quantityReserved;
		$this->quantityAvailable = $quantityAvailable;

		$this->AddService($server, WebServices::GetAccessory, array(WebServiceParams::AccessoryId => $id));
	}

	public static function Example()
	{
		return new ExampleReservationAccessoryResponse();
	}
}

class ExampleReservationAccessoryResponse extends ReservationAccessoryResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->name = 'Example';
		$this->quantityAvailable = 12;
		$this->quantityReserved = 3;
	}
}

