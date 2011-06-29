<?php

class Group
{
	private $id;
	private $name;
	private $_removedUsers = array();

	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function Id()
	{
		return $this->id;
	}

	public function Name()
	{
		return $this->name;
	}

	public function RemoveUser($userId)
	{
		$this->_removedUsers[] = $userId;
	}

	/**
	 * @internal
	 * @return int[] array of userIds
	 */
	public function RemovedUsers()
	{
		return $this->_removedUsers;
	}

}

?>