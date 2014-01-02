<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */


require_once(ROOT_DIR . 'Domain/User.php');
require_once(ROOT_DIR . 'Domain/Values/AccountStatus.php');
require_once(ROOT_DIR . 'Domain/Values/FullName.php');
require_once(ROOT_DIR . 'Domain/Values/UserPreferences.php');
require_once(ROOT_DIR . 'lib/Email/Messages/AccountCreationEmail.php');

interface IUserRepository extends IUserViewRepository
{
	/**
	 * @param int $userId
	 * @return User
	 */
	function LoadById($userId);

	/**
	 * @param string $publicId
	 * @return User
	 */
	function LoadByPublicId($publicId);

	/**
	 * @param string $userName
	 * @return User
	 */
	function LoadByUsername($userName);

	/**
	 * @abstract
	 * @param User $user
	 * @return void
	 */
	function Update(User $user);

	/**
	 * @abstract
	 * @param User $user
	 * @return int
	 */
	function Add(User $user);

	/**
	 * @abstract
	 * @param $userId int
	 * @return void
	 */
	function DeleteById($userId);
}

interface IUserViewRepository
{
	/**
	 * @param int $userId
	 * @return UserDto
	 */
	function GetById($userId);

	/**
	 * @return array[int]UserDto
	 */
	function GetAll();

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param null|string $sortField
	 * @param null|string $sortDirection
	 * @param null|ISqlFilter $filter
	 * @param AccountStatus|int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null,
							$accountStatus = AccountStatus::ALL);

	/**
	 * @param int $resourceId
	 * @return array|UserDto[]
	 */
	function GetResourceAdmins($resourceId);

	/**
	 * @return array|UserDto[]
	 */
	function GetApplicationAdmins();

	/**
	 * @param int $userId
	 * @return array|UserDto[]
	 */
	function GetGroupAdmins($userId);

	/**
	 * @param $userId int
	 * @param $roleLevels int|null|array|int[]
	 * @return array|UserGroup[]
	 */
	function LoadGroups($userId, $roleLevels = null);

	/**
	 * @param string $emailAddress
	 * @param string $userName
	 * @return int|null
	 */
	public function UserExists($emailAddress, $userName);
}

interface IAccountActivationRepository
{
	/**
	 * @abstract
	 * @param User $user
	 * @param string $activationCode
	 * @return void
	 */
	public function AddActivation(User $user, $activationCode);

	/**
	 * @abstract
	 * @param string $activationCode
	 * @return int|null
	 */
	public function FindUserIdByCode($activationCode);

	/**
	 * @abstract
	 * @param string $activationCode
	 * @return void
	 */
	public function DeleteActivation($activationCode);
}

class UserRepository implements IUserRepository, IAccountActivationRepository
{
	/**
	 * @var DomainCache
	 */
	private $_cache;

	public function __construct()
	{
		$this->_cache = new DomainCache();
	}

	public function GetAll()
	{
		$command = new GetAllUsersByStatusCommand(AccountStatus::ACTIVE);

		$reader = ServiceLocator::GetDatabase()->Query($command);
		$users = array();

		while ($row = $reader->GetRow())
		{
			$preferences = isset($row[ColumnNames::USER_PREFERENCES]) ? $row[ColumnNames::USER_PREFERENCES] : '';
			$users[] = new UserDto($row[ColumnNames::USER_ID], $row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME], $row[ColumnNames::EMAIL], $row[ColumnNames::TIMEZONE_NAME], $row[ColumnNames::LANGUAGE_CODE], $preferences);
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
			return new UserDto($row[ColumnNames::USER_ID], $row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME], $row[ColumnNames::EMAIL], $row[ColumnNames::TIMEZONE_NAME], $row[ColumnNames::LANGUAGE_CODE]);
		}

		return null;
	}

	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null,
							$accountStatus = AccountStatus::ALL)
	{
		$command = new GetAllUsersByStatusCommand($accountStatus);

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('UserItemView', 'Create');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	/**
	 * @param $command SqlCommand
	 * @return User
	 */
	private function Load($command)
	{
		$reader = ServiceLocator::GetDatabase()->Query($command);

		if ($row = $reader->GetRow())
		{
			$userId = $row[ColumnNames::USER_ID];
			$emailPreferences = $this->LoadEmailPreferences($userId);
			$permissions = $this->LoadPermissions($userId);
			$groups = $this->LoadGroups($userId);

			$user = User::FromRow($row);
			$user->WithEmailPreferences($emailPreferences);
			$user->WithPermissions($permissions);
			$user->WithGroups($groups);
			$this->LoadAttributes($userId, $user);

			if ($user->IsGroupAdmin())
			{
				$ownedGroups = $this->LoadOwnedGroups($userId);
				$user->WithOwnedGroups($ownedGroups);
			}

			$preferences = $this->LoadPreferences($userId);
			$user->WithPreferences($preferences);

			$user->WithDefaultSchedule($row[ColumnNames::DEFAULT_SCHEDULE_ID]);

			$this->_cache->Add($userId, $user);

			return $user;
		}
		else
		{
			return User::Null();
		}
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
			return $this->Load($command);
		}
		else
		{
			return $this->_cache->Get($userId);
		}
	}

	/**
	 * @param string $publicId
	 * @return User
	 */
	public function LoadByPublicId($publicId)
	{
		$command = new GetUserByPublicIdCommand($publicId);
		return $this->Load($command);
	}

	/**
	 * @param string $userName
	 * @return User
	 */
	public function LoadByUsername($userName)
	{
		$command = new LoginCommand(strtolower($userName));
		return $this->Load($command);
	}

	/**
	 * @param User $user
	 * @return int
	 */
	public function Add(User $user)
	{
		$db = ServiceLocator::GetDatabase();
		$id = $db->ExecuteInsert(new RegisterUserCommand($user->Username(), $user->EmailAddress(), $user->FirstName(),
														 $user->LastName(), $user->encryptedPassword, $user->passwordSalt, $user->Timezone(), $user->Language(),
														 $user->Homepage(), $user->GetAttribute(UserAttribute::Phone), $user->GetAttribute(UserAttribute::Organization),
														 $user->GetAttribute(UserAttribute::Position), $user->StatusId(), $user->GetPublicId(), $user->GetDefaultScheduleId()));

		$user->WithId($id);

		if(Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_NOTIFY, new BooleanConverter()))
			ServiceLocator::GetEmailService()->Send(new AccountCreationEmail($user));

		foreach ($user->GetAddedAttributes() as $added)
		{
			$db->Execute(new AddAttributeValueCommand($added->AttributeId, $added->Value, $user->Id(), CustomAttributeCategory::USER));
		}

		$addedPreferences = $user->GetAddedEmailPreferences();
		foreach ($addedPreferences as $event)
		{
			$db->Execute(new AddEmailPreferenceCommand($id, $event->EventCategory(), $event->EventType()));
		}

		return $id;
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function Update(User $user)
	{
		$userId = $user->Id();

		$db = ServiceLocator::GetDatabase();
		$updateUserCommand = new UpdateUserCommand($user->Id(),
												   $user->StatusId(),
												   $user->encryptedPassword,
												   $user->passwordSalt,
												   $user->FirstName(),
												   $user->LastName(),
												   $user->EmailAddress(),
												   $user->Username(),
												   $user->Homepage(),
												   $user->Timezone(),
												   $user->LastLogin(),
												   $user->GetIsCalendarSubscriptionAllowed(),
												   $user->GetPublicId(),
												   $user->Language(),
												   $user->GetDefaultScheduleId());
		$db->Execute($updateUserCommand);

		$removedPermissions = $user->GetRemovedPermissions();
		foreach ($removedPermissions as $resourceId)
		{
			$db->Execute(new DeleteUserResourcePermission($userId, $resourceId));
		}

		$addedPermissions = $user->GetAddedPermissions();
		foreach ($addedPermissions as $resourceId)
		{
			$db->Execute(new AddUserResourcePermission($userId, $resourceId));
		}

		if ($user->HaveAttributesChanged())
		{
			$updateAttributesCommand = new UpdateUserAttributesCommand($userId, $user->GetAttribute(UserAttribute::Phone), $user->GetAttribute(UserAttribute::Organization), $user->GetAttribute(UserAttribute::Position));
			$db->Execute($updateAttributesCommand);
		}

		$removedPreferences = $user->GetRemovedEmailPreferences();
		foreach ($removedPreferences as $event)
		{
			$db->Execute(new DeleteEmailPreferenceCommand($userId, $event->EventCategory(), $event->EventType()));
		}

		$addedPreferences = $user->GetAddedEmailPreferences();
		foreach ($addedPreferences as $event)
		{
			$db->Execute(new AddEmailPreferenceCommand($userId, $event->EventCategory(), $event->EventType()));
		}

		foreach ($user->GetRemovedAttributes() as $removed)
		{
			$db->Execute(new RemoveAttributeValueCommand($removed->AttributeId, $user->Id()));
		}

		foreach ($user->GetAddedAttributes() as $added)
		{
			$db->Execute(new AddAttributeValueCommand($added->AttributeId, $added->Value, $user->Id(), CustomAttributeCategory::USER));
		}

		foreach($user->GetPreferences()->AddedPreferences() as $added)
		{
			$db->Execute(new AddUserPreferenceCommand($user->Id(), $added, $user->GetPreference($added)));
		}

		foreach($user->GetPreferences()->ChangedPreferences() as $updated)
		{
			$db->Execute(new UpdateUserPreferenceCommand($user->Id(), $updated, $user->GetPreference($updated)));
		}
	}

	public function DeleteById($userId)
	{
		$deleteUserCommand = new DeleteUserCommand($userId);
		ServiceLocator::GetDatabase()->Execute($deleteUserCommand);
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
	 * @param int $resourceId
	 * @return array|UserDto[]
	 */
	public function GetResourceAdmins($resourceId)
	{
		$command = new GetAllResourceAdminsCommand($resourceId);

		$reader = ServiceLocator::GetDatabase()->Query($command);
		$users = array();

		while ($row = $reader->GetRow())
		{
			$users[] = new UserDto($row[ColumnNames::USER_ID], $row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME], $row[ColumnNames::EMAIL], $row[ColumnNames::TIMEZONE_NAME], $row[ColumnNames::LANGUAGE_CODE]);
		}

		return $users;
	}

	/**
	 * @return array|UserDto[]
	 */
	public function GetApplicationAdmins()
	{
		$command = new GetAllApplicationAdminsCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);
		$users = array();

		while ($row = $reader->GetRow())
		{
			$users[] = new UserDto($row[ColumnNames::USER_ID], $row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME], $row[ColumnNames::EMAIL], $row[ColumnNames::TIMEZONE_NAME], $row[ColumnNames::LANGUAGE_CODE]);
		}

		return $users;
	}

	/**
	 * @param int $userId
	 * @return array|UserDto[]
	 */
	public function GetGroupAdmins($userId)
	{
		$command = new GetAllGroupAdminsCommand($userId);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		$users = array();

		while ($row = $reader->GetRow())
		{
			$users[] = new UserDto($row[ColumnNames::USER_ID], $row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME], $row[ColumnNames::EMAIL], $row[ColumnNames::TIMEZONE_NAME], $row[ColumnNames::LANGUAGE_CODE]);
		}

		return $users;
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

		$reader->Free();
		return $allowedResourceIds;
	}

	public function LoadGroups($userId, $roleLevels = null)
	{
		/**
		 * @var $groups array|UserGroup[]
		 */
		$groups = array();

		if (!is_null($roleLevels) && !is_array($roleLevels))
		{
			$roleLevels = array($roleLevels);
		}

		$command = new GetUserGroupsCommand($userId, $roleLevels);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$groupId = $row[ColumnNames::GROUP_ID];
			if (!array_key_exists($groupId, $groups))
			{
				// a group can have many roles which are all returned at once
				$group = new UserGroup($groupId, $row[ColumnNames::GROUP_NAME], $row[ColumnNames::GROUP_ADMIN_GROUP_ID], $row[ColumnNames::ROLE_LEVEL]);
				$groups[$groupId] = $group;
			}
			else
			{
				$groups[$groupId]->AddRole($row[ColumnNames::ROLE_LEVEL]);
			}
		}

		return array_values($groups);
	}

	public function LoadPreferences($userId)
	{
		$command = new GetUserPreferencesCommand($userId);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		$preferences = new UserPreferences();
		while($row = $reader->GetRow())
		{
			$preferences->Add($row[ColumnNames::PREFERENCE_NAME], $row[ColumnNames::PREFERENCE_VALUE]);
		}

		$reader->Free();

		return $preferences;
	}
	/**
	 * @param $emailAddress string
	 * @return User
	 */
	public function FindByEmail($emailAddress)
	{
		$command = new CheckEmailCommand($emailAddress);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		if ($row = $reader->GetRow())
		{
			return $this->LoadById($row[ColumnNames::USER_ID]);
		}

		return null;
	}

	/**
	 * @param $userId int
	 * @param $user User
	 */
	private function LoadAttributes($userId, $user)
	{
		$getAttributes = new GetAttributeValuesCommand($userId, CustomAttributeCategory::USER);
		$attributeReader = ServiceLocator::GetDatabase()->Query($getAttributes);

		while ($attributeRow = $attributeReader->GetRow())
		{
			$user->WithAttribute(new AttributeValue($attributeRow[ColumnNames::ATTRIBUTE_ID], $attributeRow[ColumnNames::ATTRIBUTE_VALUE]));
		}

		$attributeReader->Free();
	}

	public function AddActivation(User $user, $activationCode)
	{
		ServiceLocator::GetDatabase()->ExecuteInsert(new AddAccountActivationCommand($user->Id(), $activationCode));
	}

	/**
	 * @param string $activationCode
	 * @return int|null
	 */
	public function FindUserIdByCode($activationCode)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserIdByActivationCodeCommand($activationCode));
		if ($row = $reader->GetRow())
		{
			return $row[ColumnNames::USER_ID];
		}

		return null;
	}

	/**
	 * @param string $activationCode
	 * @return void
	 */
	public function DeleteActivation($activationCode)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteAccountActivationCommand($activationCode));
	}

	/**
	 * @param int $userId
	 * @return array|UserGroup[]
	 */
	private function LoadOwnedGroups($userId)
	{
		$groups = array();
		$reader = ServiceLocator::GetDatabase()->Query(new GetGroupsIManageCommand($userId));
		while ($row = $reader->GetRow())
		{
			$groups[] = new UserGroup($row[ColumnNames::GROUP_ID], $row[ColumnNames::GROUP_NAME]);
		}

		return $groups;
	}

	public function UserExists($emailAddress, $userName)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new CheckUserExistenceCommand($userName, $emailAddress));

		if ($row = $reader->GetRow())
		{
			return $row[ColumnNames::USER_ID];
		}

		return null;
	}
}

class UserDto
{
	public $UserId;
	public $FirstName;
	public $LastName;
	public $FullName;
	public $EmailAddress;
	public $Timezone;
	public $LanguageCode;
	public $Preferences;

	public function __construct($userId, $firstName, $lastName, $emailAddress, $timezone = null, $languageCode = null, $preferences = null)
	{
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
		$this->EmailAddress = $emailAddress;
		$this->Timezone = $timezone;
		$this->LanguageCode = $languageCode;
		$name = new FullName($this->FirstName(), $this->LastName());
		$this->FullName =  $name->__toString() . " ({$this->EmailAddress})";
		$this->Preferences = UserPreferences::Parse($preferences)->All();
	}

	public function Id()
	{
		return $this->UserId;
	}

	public function FirstName()
	{
		return $this->FirstName;
	}

	public function LastName()
	{
		return $this->LastName;
	}

	public function FullName()
	{
		return $this->FullName;
	}

	public function EmailAddress()
	{
		return $this->EmailAddress;
	}

	public function Timezone()
	{
		return $this->Timezone;
	}

	public function Language()
	{
		return $this->LanguageCode;
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

class UserItemView
{
	public $Id;
	public $Username;
	public $First;
	public $Last;
	public $Email;
	public $Phone;
	/**
	 * @var Date
	 */
	public $DateCreated;
	/**
	 * @var Date
	 */
	public $LastLogin;
	public $StatusId;
	public $Timezone;
	public $Organization;
	public $Position;
	public $Language;
	public $ReservationColor;
	/**
	 * @var UserPreferences
	 */
	public $Preferences;

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
		$user->DateCreated = Date::FromDatabase($row[ColumnNames::USER_CREATED]);
		$user->LastLogin = Date::FromDatabase($row[ColumnNames::LAST_LOGIN]);
		$user->StatusId = $row[ColumnNames::USER_STATUS_ID];
		$user->Timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->Organization = $row[ColumnNames::ORGANIZATION];
		$user->Position = $row[ColumnNames::POSITION];
		$user->Language = $row[ColumnNames::LANGUAGE_CODE];

		if (isset($row[ColumnNames::USER_PREFERENCES]))
		{
			$preferences = UserPreferences::Parse($row[ColumnNames::USER_PREFERENCES]);
			if (!empty($preferences))
			{
				$user->ReservationColor = $preferences->Get(UserPreferences::RESERVATION_COLOR);
			}
			$user->Preferences = $preferences;
		}
		else
		{
			$user->Preferences = new UserPreferences();
		}

		return $user;
	}
}

?>