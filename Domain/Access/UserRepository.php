<?php
require_once(ROOT_DIR . 'Domain/User.php');
require_once(ROOT_DIR . 'Domain/Values/AccountStatus.php');

class UserRepository implements IUserRepository, IUserViewRepository
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
								$row[ColumnNames::EMAIL],
								$row[ColumnNames::TIMEZONE_NAME],
								$row[ColumnNames::LANGUAGE_CODE]
								);
		}

		return $users;
	}

	/**
	 * @param $userId
	 * @return null|UserDto
	 */
	public function GetById($userId)
	{
		$command = new GetUserByIdCommand($userId);

		$reader = ServiceLocator::GetDatabase()->Query($command);

		if ($row = $reader->GetRow())
		{
			return new UserDto(
								$row[ColumnNames::USER_ID],
								$row[ColumnNames::FIRST_NAME],
								$row[ColumnNames::LAST_NAME],
								$row[ColumnNames::EMAIL],
								$row[ColumnNames::TIMEZONE_NAME],
								$row[ColumnNames::LANGUAGE_CODE]
								);
		}

		return null;
	}


	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData of UserItemView
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		$command = new GetAllUsersByStatusCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('UserItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}
	
	/**
	 * @param int $userId
	 * @return User
	 */
	public function LoadById($userId)
	{
		if (!$this->_cache->Exists($userId))
		{
			$command = new GetUserByIdCommand($userId);
			$reader = ServiceLocator::GetDatabase()->Query($command);
	
			if ($row = $reader->GetRow())
			{
				$emailPreferences = $this->LoadEmailPreferences($userId);
				$permissions = $this->LoadPermissions($userId);
				$groups = $this->LoadGroups($userId);

				$user = User::FromRow($row);
				$user->WithEmailPreferences($emailPreferences);
				$user->WithPermissions($permissions);
				$user->WithGroups($groups);

				$this->_cache->Add($userId, $user);
			}		
		}
		
		return $this->_cache->Get($userId);
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function Update($user)
	{
		$userId = $user->Id();
		
		$db = ServiceLocator::GetDatabase();
		$updateUserCommand = new UpdateUserCommand(
			$user->Id(),
			$user->StatusId(),
			$user->password,
			$user->passwordSalt,
			$user->FirstName(),
			$user->LastName(),
			$user->EmailAddress(),
			$user->Username(),
			$user->Homepage(),
			$user->Timezone());
		$db->Execute($updateUserCommand);

		$removed = $user->GetRemovedPermissions();
		foreach ($removed as $resourceId)
		{
			$db->Execute(new DeleteUserResourcePermission($userId, $resourceId));
		}
		
		$added = $user->GetAddedPermissions();
		foreach ($added as $resourceId)
		{
			$db->Execute(new AddUserResourcePermission($userId, $resourceId));
		}

		if ($user->HaveAttributesChanged())
		{
			$updateAttributesCommand = new UpdateUserAttributesCommand(
						$userId,
						$user->GetAttribute(UserAttribute::Phone),
						$user->GetAttribute(UserAttribute::Organization),
						$user->GetAttribute(UserAttribute::Position));
			$db->Execute($updateAttributesCommand);
		}
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

	private function LoadPermissions($userId)
	{
		$allowedResourceIds = array();
		
		$command = new GetUserPermissionsCommand($userId);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$allowedResourceIds[] = $row[ColumnNames::RESOURCE_ID];
		}

		return $allowedResourceIds;
	}

	private function LoadGroups($userId)
	{
		$groups = array();

		$command = new GetUserGroupsCommand($userId);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$group = new GroupUserView($userId, null, null, $row[ColumnNames::ROLE_ID]);
			$group->GroupId = $row[ColumnNames::GROUP_ID];
			$groups[] = $group;
		}

		return $groups;
	}
}

interface IUserRepository
{
	/**
	 * @return array[int]UserDto
	 */
	function GetAll();

	/**
	 * @return UserDto
	 */
	function GetById($userId);
	
	/**
	 * @param int $userId
	 * @return User
	 */
	function LoadById($userId);

	/**
	 * @abstract
	 * @param User $user
	 * @return void
	 */
	function Update($user);
	
	/**
	 * @param int $resourceId
	 * @return UserDto[]
	 */
	function GetResourceAdmins($resourceId);
	
}

interface IUserViewRepository
{
	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @return PageableData|UserItemView[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null);
}

class UserDto
{
	private $userId;
	private $firstName;
	private $lastName;
	private $emailAddress;
	private $timezone;
	private $languageCode;
	
	public function __construct($userId, $firstName, $lastName, $emailAddress, $timezone = null, $languageCode = null)
	{
		$this->userId = $userId;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->emailAddress = $emailAddress;
		$this->timezone = $timezone;
		$this->languageCode = $languageCode;		
	}
	
	public function Id()
	{
		return $this->userId;
	}
	
	public function FirstName()
	{
		return $this->firstName;
	}
	
	public function LastName()
	{
		return $this->lastName;
	}
	
	public function FullName()
	{
		return $this->FirstName() . ' ' . $this->LastName();
	}
	
	public function EmailAddress()
	{
		return $this->emailAddress;
	}
	
	public function Timezone()
	{
		return $this->timezone;
	}
	
	public function Language()
	{
		return $this->language;
	}
}

class NullUserDto extends UserDto
{
	public function __construct()
	{
		parent::__construct(0, null, null, null, null, null);
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

class UserItemView
{
	public $Id;
	public $Username;
	public $First;
	public $Last;
	public $Email;
	public $Phone;
	public $DateCreated;
	public $LastLogin;
	public $StatusId;
	public $Timezone;
	public $Organization;
	public $Position;
	public $Language;

	public function IsActive()
	{
		return $this->StatusId == AccountStatus::ACTIVE;
	}
	
	public static function Create($row)
	{
		$user = new UserItemView();

		$user->Id = $row[ColumnNames::USER_ID];
		$user->Username = $row[ColumnNames::USERNAME];
		$user->First = $row[ColumnNames::FIRST_NAME];
		$user->Last = $row[ColumnNames::LAST_NAME];
		$user->Email = $row[ColumnNames::EMAIL];
		$user->Phone = $row[ColumnNames::PHONE_NUMBER];
	    //$user->DateCreated = Date::FromDatabase($row[ColumnNames::DATE_CREATED]);
		$user->LastLogin = Date::FromDatabase($row[ColumnNames::LAST_LOGIN]);
		$user->StatusId = $row[ColumnNames::USER_STATUS_ID];
		$user->Timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->Organization = $row[ColumnNames::ORGANIZATION];
		$user->Position = $row[ColumnNames::POSITION];
        $user->Language = $row[ColumnNames::LANGUAGE_CODE]; 
		
		return $user;
	}
}
?>