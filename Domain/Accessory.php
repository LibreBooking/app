<?php

/**
 * Copyright 2011-2014 Nick Korbel
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

class Accessory
{
	/**
	 * @var int
	 */
	private $id;


	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var int
	 */
	private $quantityAvailable;

	/**
	 * @var ResourceAccessory[]
	 */
	private $resources = array();

	/**
	 * @param int $id
	 * @param string $name
	 * @param int $quantityAvailable
	 */
	public function __construct($id, $name, $quantityAvailable)
	{
		$this->id = $id;
		$this->SetName($name);
		$this->SetQuantityAvailable($quantityAvailable);
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function SetName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param int $quantity
	 */
	public function SetQuantityAvailable($quantity)
	{
		$q = intval($quantity);
		$this->quantityAvailable = empty($q) ? null : $q;
	}

	/**
	 * @return int
	 */
	public function GetQuantityAvailable()
	{
		return $this->quantityAvailable;
	}

	/**
	 * @return ResourceAccessory[]
	 */
	public function Resources()
	{
		return $this->resources;
	}

	/**
	 * @return int[]
	 */
	public function ResourceIds()
	{
		$ids = array();
		foreach ($this->resources as $resource)
		{
			$ids[] = $resource->ResourceId;
		}

		return $ids;
	}

	/**
	 * @static
	 * @param string $name
	 * @param int $quantity
	 * @return Accessory
	 */
	public static function Create($name, $quantity)
	{
		return new Accessory(null, $name, $quantity);
	}

	/**
	 * @return bool
	 */
	public function HasUnlimitedQuantity()
	{
		return empty($this->quantityAvailable);
	}

	public function AddResource($resourceId, $minQuantity, $maxQuantity)
	{
		$this->resources[] = new ResourceAccessory($resourceId, $minQuantity, $maxQuantity);
	}

	/**
	 * @param ResourceAccessory[] $resources
	 */
	public function ChangeResources($resources)
	{
		$this->resources = $resources;
	}

	/**
	 * @return bool
	 */
	public function IsTiedToResource()
	{
		return count($this->resources) > 0;
	}

	/**
	 * @param int $resourceId
	 * @return ResourceAccessory
	 */
	public function GetResource($resourceId)
	{
		foreach ($this->resources as $resource)
		{
			if ($resource->ResourceId == $resourceId)
			{
				return $resource;
			}
		}

		return null;
	}
}

class ResourceAccessory
{
	public $ResourceId;
	public $MinQuantity;
	public $MaxQuantity;

	public function __construct($resourceId, $minQuantity, $maxQuantity)
	{
		$this->ResourceId = $resourceId;
		$this->MinQuantity = empty($minQuantity) ? null : (int)$minQuantity;
		$this->MaxQuantity = empty($maxQuantity) ? null : (int)$maxQuantity;;
	}
}
