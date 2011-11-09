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
		// TODO: Implement LoadById() method.
	}
}
?>