<?php
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
	 * @return void
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
	 * @return void
	 */
	public function Add(Accessory $accessory)
	{
		ServiceLocator::GetDatabase()->Execute(new AddAccessoryCommand($accessory->GetName(), $accessory->GetQuantityAvailable()));
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