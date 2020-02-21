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

class AccessoriesResponse extends RestResponse
{
    /**
     * @var AccessoryItemResponse
     */
    public $accessories;

    /**
	 * @param IRestServer $server
	 * @param AccessoryDto[] $accessories
	 */
	public function __construct(IRestServer $server, $accessories)
	{
		/** @var $accessory AccessoryDto */
		foreach ($accessories as $accessory)
		{
			$this->accessories[] = new AccessoryItemResponse($server, $accessory);
		}
	}

	public static function Example()
	{
		return new ExampleAccessoriesResponse();
	}
}

class ExampleAccessoriesResponse extends AccessoriesResponse
{
	public function __construct()
	{
		$this->accessories = array(AccessoryItemResponse::Example());
	}
}

class AccessoryItemResponse extends RestResponse
{
	public $id;
	public $name;
	public $quantityAvailable;
    public $associatedResourceCount;

    public function __construct(IRestServer $server, AccessoryDto $accessory)
	{
		$this->id = $accessory->Id;
		$this->name = $accessory->Name;
		$this->quantityAvailable = $accessory->QuantityAvailable;
        $this->associatedResourceCount = $accessory->AssociatedResources;
		$this->AddService($server, WebServices::GetAccessory, array(WebServiceParams::AccessoryId => $this->id));
	}

	public static function Example()
	{
		return new ExampleAccessoryItemResponse();
	}
}

class ExampleAccessoryItemResponse extends AccessoryItemResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->name = 'accessoryName';
		$this->quantityAvailable = 3;
        $this->associatedResourceCount = 10;
	}
}