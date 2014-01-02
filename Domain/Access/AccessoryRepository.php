<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Accessory.php');

interface IAccessoryRepository
{
	/**
	 * @abstract
	 * @param int $accessoryId
	 * @return Accessory
	 */
	public function LoadById($accessoryId);

	/**
	 * @abstract
	 * @param Accessory $accessory
     * @return int
	 */
	public function Add(Accessory $accessory);

	/**
	 * @abstract
	 * @param Accessory $accessory
	 * @return void
	 */
	public function Update(Accessory $accessory);

	/**
	 * @abstract
	 * @param int $accessoryId
	 * @return void
	 */
	public function Delete($accessoryId);
}

class AccessoryRepository implements IAccessoryRepository
{
	/**
	 * @param int $accessoryId
	 * @return Accessory
	 */
	public function LoadById($accessoryId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAccessoryByIdCommand($accessoryId));

		if ($row = $reader->GetRow())
		{
			return new Accessory($row[ColumnNames::ACCESSORY_ID], $row[ColumnNames::ACCESSORY_NAME], $row[ColumnNames::ACCESSORY_QUANTITY]);
		}

		return null;
	}

	/**
	 * @param Accessory $accessory
	 * @return int
	 */
	public function Add(Accessory $accessory)
	{
		return ServiceLocator::GetDatabase()->ExecuteInsert(new AddAccessoryCommand($accessory->GetName(), $accessory->GetQuantityAvailable()));
	}

	/**
	 * @param Accessory $accessory
	 * @return void
	 */
	public function Update(Accessory $accessory)
	{
		ServiceLocator::GetDatabase()->Execute(new UpdateAccessoryCommand($accessory->GetId(), $accessory->GetName(), $accessory->GetQuantityAvailable()));
	}

	/**
	 * @param int $accessoryId
	 * @return void
	 */
	public function Delete($accessoryId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteAccessoryCommand($accessoryId));
	}

}
?>