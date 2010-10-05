<?php
class UserRepository implements IUserRepository 
{
	/**
	 * @var DomainCache
	 */
	private $_cache;
	
	public function __construct()
	{
		$this->_cache = new DomainCache();
	}
	
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
								$row[ColumnNames::LAST_NAME], 
								$row[ColumnNames::EMAIL]
								);
		}

		return $users;
	}
	
	/**
	 * @see IUserRepository::LoadById()
	 */
	public function LoadById($userId)
	{
		//TODO: Implement for real
		
		$user = new User();
		if (!$this->_cache->Exists($userId))
		{
			$user = null;// pull+build
			$this->_cache->Add($userId, $user);
		}
		
		return $this->_cache->Get($userId);
	}
	
	/**
	 * @see IUserRepository::GetResourceAdmins()
	 */
	public function GetResourceAdmins($resourceId)
	{
		//TODO: Implement for real
		
		return array();
	}
}

interface IUserRepository
{
	/**
	 * @return array[int]UserDto
	 */
	public function GetAll();
	
	/**
	 * @param int $userId
	 * @return User
	 */
	public function LoadById($userId);
	
	/**
	 * @param int $resourceId
	 * @return UserDto[]
	 */
	function GetResourceAdmins($resourceId);
}

class UserDto
{
	private $_userId;
	private $_firstName;
	private $_lastName;
	private $_emailAddress;
	
	public function __construct($userId, $firstName, $lastName, $emailAddress)
	{
		$this->_userId = $userId;
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_emailAddress = $emailAddress;
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
	
	public function EmailAddress()
	{
		return $this->_emailAddress;
	}
}

class NullUserDto extends UserDto
{
	public function __construct()
	{
		parent::__construct(0, null, null, null);
	}
	
	public function FullName()
	{
		return null;
	}
}
?>