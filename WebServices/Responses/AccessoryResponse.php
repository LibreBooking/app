<?php
/**
Copyright 2012-2015 Nick Korbel

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

class AccessoryResponse extends RestResponse
{
	public function __construct(IRestServer $server, Accessory $accessory)
	{
		$this->id = $accessory->GetId();
		$this->name = $accessory->GetName();
		$this->quantityAvailable = $accessory->GetQuantityAvailable();
	}

	public static function Example()
	{
		return new ExampleAccessoryResponse(null, new Accessory(1, 'accessoryName', 10));
	}
}

class ExampleAccessoryResponse extends AccessoryResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->name = 'accessoryName';
		$this->quantityAvailable = 10;
	}
}

?>