<?php
class UserRepository implements IUserRepository 
{
	/**
	 * @see IUserRepository:GetAll()
	 */
	public function GetAll()
	{
		$command = new GetAllUsersByStatusCommand(AccountStatus::ACTIVE);

		$reader = ServiceLocator::GetDatabase()->Query($command);
		$users = array();

		while ($row = $reader->GetRow())
		{
			$users[] = new UserDto(
								$row[ColumnNames::USER_ID], 
								$row[ColumnNames::FIRST_NAME],
								$row[ColumnNames::LAST_NAME]
								);
		}

		return $users;
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
	private $_userId;
	private $_firstName;
	private $_lastName;
	
	public function __construct($userId, $firstName, $lastName)
	{
		$this->_userId = $userId;
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
	}
	
	public function Id()
	{
		return $this->_userId;
	}
	
	public function FirstName()
	{
		return $this->_firstName;
	}
	
	public function LastName()
	{
		return $this->_lastName;
	}
	
	public function FullName()
	{
		return $this->FirstName() . ' ' . $this->LastName();
	}
}

class NullUserDto extends UserDto
{
	public function __construct()
	{
		parent::__construct(0, null, null);
	}
	
	public function FullName()
	{
		return null;
	}
}
?>