<?php
/**
Copyright 2014-2017 Nick Korbel

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

class FakeAccessoryRepository implements IAccessoryRepository
{
	public $_AllAccessories = array();

	public function AddAccessory(Accessory $accessory)
	{
		$this->_AllAccessories[] = $accessory;
		return $this;
	}

	/**
	 * @param int $accessoryId
	 * @return Accessory
	 */
	public function LoadById($accessoryId)
	{
		// TODO: Implement LoadById() method.
	}

	/**
	 * @return Accessory[]
	 */
	public function LoadAll()
	{
		return $this->_AllAccessories;
	}

	/**
	 * @param Accessory $accessory
	 * @return int
	 */
	public function Add(Accessory $accessory)
	{
		// TODO: Implement Add() method.
	}

	/**
	 * @param Accessory $accessory
	 * @return void
	 */
	public function Update(Accessory $accessory)
	{
		// TODO: Implement Update() method.
	}

	/**
	 * @param int $accessoryId
	 * @return void
	 */
	public function Delete($accessoryId)
	{
		// TODO: Implement Delete() method.
	}
}
 