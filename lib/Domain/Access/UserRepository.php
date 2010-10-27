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
		$user = new User();
		
		if (!$this->_cache->Exists($userId))
		{
			$emailPreferences = $this->LoadEmailPreferences($userId);
			
			$command = new GetUserByIdCommand($userId);

			$reader = ServiceLocator::GetDatabase()->Query($command);
	
			if ($row = $reader->GetRow())
			{
				$user = User::FromRow($row, $emailPreferences);
				$this->_cache->Add($userId, $user);
			}		
		}
		
		return $this->_cache->Get($userId);
	}
	
	public function LoadEmailPreferences($userId)
	{
		$emailPreferences = new EmailPreferences();
			
		$command = new GetUserEmailPreferencesCommand($userId);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$emailPreferences->Add($row[ColumnNames::EVENT_CATEGORY], $row[ColumnNames::EVENT_TYPE]);
		}
		
		return $emailPreferences;
	}
	
	/**
	 * @see IUserRepository::GetResourceAdmins()
	 */
	public function GetResourceAdmins($resourceId)
	{
		//TODO: Implement for real
		// needs first name, last name, email, language, timezone
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

class EmailPreferences implements IEmailPreferences
{
	private $preferences = array();
	
	public function Add($eventCategory, $eventType)
	{
		$key = $this->ToKey($eventCategory, $eventType);
		$this->preferences[$key] = true;
	}
	
	public function Exists($eventCategory, $eventType)
	{
		$key = $this->ToKey($eventCategory, $eventType);
		return isset($this->preferences[$key]);
	}
	
	private function ToKey($eventCategory, $eventType)
	{
		return $eventCategory . '|' . $eventType;
	}
}

interface IEmailPreferences
{
	function Exists($eventCategory, $eventType);
}
?>