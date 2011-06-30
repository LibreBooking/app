<?php

class Group
{
	private $id;
	private $name;
	
	private $_addedUsers = array();
	private $_removedUsers = array();
	private $_users = array();

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

	public function AddUser($userId)
	{
		if (!$this->HasMember($userId))
		{
			$this->_addedUsers[] = $userId;
		}
	}

	public function RemoveUser($userId)
	{
		if ($this->HasMember($userId))
		{
			$this->_removedUsers[] = $userId;
		}
	}

	/**
	 * @internal
	 * @return int[] array of userIds
	 */
	public function AddedUsers()
	{
		return $this->_addedUsers;
	}
	
	/**
	 * @internal
	 * @return int[] array of userIds
	 */
	public function RemovedUsers()
	{
		return $this->_removedUsers;
	}

	/**
	 * @internal
	 * @param $userId
	 * @return void
	 */
	public function WithUser($userId)
	{
		$this->_users[] = $userId;
	}

	/**
	 * @param $userId
	 * @return bool
	 */
	public function HasMember($userId)
	{
		return in_array($userId, $this->_users);
	}
}

?>