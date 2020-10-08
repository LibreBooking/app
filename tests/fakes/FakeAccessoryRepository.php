<?php
/**
 * Copyright 2014-2020 Nick Korbel
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

class FakeAccessoryRepository implements IAccessoryRepository
{
	public $_AllAccessories = array();
	public $_DeletedId;
	/**
	 * @var Accessory
	 */
	public $_Accessory;
	/**
	 * @var Accessory
	 */
	public $_AddedAccessory;
	/**
	 * @var Accessory
	 */
	public $_UpdatedAccessory;
	/**
	 * @var Accessory[]
	 */
	public $_AccessoryList = array();

	public function AddAccessory(Accessory $accessory)
	{
		$this->_AllAccessories[] = $accessory;
		return $this;
	}

	public function LoadById($accessoryId)
	{
		if (array_key_exists($accessoryId, $this->_AccessoryList))
		{
			return $this->_AccessoryList[$accessoryId];
		}
		return $this->_Accessory;
	}

	public function LoadAll()
	{
		return $this->_AllAccessories;
	}

	public function Add(Accessory $accessory)
	{
		$this->_AddedAccessory = $accessory;
	}

	public function Update(Accessory $accessory)
	{
		$this->_UpdatedAccessory = $accessory;
	}

	public function Delete($accessoryId)
	{
		$this->_DeletedId = $accessoryId;
	}
}
 