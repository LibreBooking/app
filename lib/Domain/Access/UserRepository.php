<?php
class UserRepository implements IUserRepository 
{
	public function GetAll()
	{
		return array();
	}
}

interface IUserRepository
{
	/**
	 * @return array[int]UserDto
	 */
	public function GetAll();
}

class UserDto
{
	public function __construct($userId, $firstName, $lastName)
	{
		
	}
}
?>