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
}
?>