<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Values/RoleLevel.php');
require_once(ROOT_DIR . 'Domain/Values/EmailPreferences.php');

class User
{
	public function __construct()
	{
		$this->emailPreferences = new EmailPreferences();
	}

	/**
	 * @var IEmailPreferences
	 */
	protected $emailPreferences;

	protected $id;

	public function Id()
	{
		return $this->id;
	}

	protected $firstName;

	public function FirstName()
	{
		return $this->firstName;
	}

	protected $lastName;

	public function LastName()
	{
		return $this->lastName;
	}

	public function FullName()
	{
		return $this->FirstName() . ' ' . $this->LastName();
	}

	protected $emailAddress;

	public function EmailAddress()
	{
		return $this->emailAddress;
	}

	protected $username;

	public function Username()
	{
		return $this->username;
	}

	protected $language;

	public function Language()
	{
		return $this->language;
	}

	protected $timezone;

	public function Timezone()
	{
		return $this->timezone;
	}

	protected $homepageId;

	public function Homepage()
	{
		return $this->homepageId;
	}

	protected $statusId;


	public function StatusId()
	{
		return $this->statusId;
	}

	/**
	 * @var string
	 */
	private $lastLogin;

	/**
	 * @return string
	 */
	public function LastLogin()
	{
		return $this->lastLogin;
	}

	/**
	 * @var array|UserGroup[]
	 */
	protected $groups = array();

    /**
     * @var array|UserGroup[]
     */
    protected $groupsICanAdminister = array();

	/**
	 * @return array|UserGroup[]
	 */
	public function Groups()
	{
		return $this->groups;
	}

    private $isCalendarSubscriptionAllowed = false;

    /**
     * @param bool $isAllowed
     */
    protected function SetIsCalendarSubscriptionAllowed($isAllowed)
    {
        $this->isCalendarSubscriptionAllowed = $isAllowed;
    }

    /**
     * @return bool
     */
    public function GetIsCalendarSubscriptionAllowed()
    {
        return $this->isCalendarSubscriptionAllowed;
    }

    private $publicId;

    /**
     * @param string $publicId
     */
    protected function SetPublicId($publicId)
    {
        $this->publicId = $publicId;
    }

    /**
     * @return string
     */
    public function GetPublicId()
    {
        return $this->publicId;
    }

    public function EnableSubscription()
    {
        $this->SetIsCalendarSubscriptionAllowed(true);
        if (empty($this->publicId))
        {
            $this->SetPublicId(uniqid());
        }
    }

    public function DisableSubscription()
    {
        $this->SetIsCalendarSubscriptionAllowed(false);
    }

	public function Activate()
	{
		$this->statusId = AccountStatus::ACTIVE;
	}

	public function Deactivate()
	{
		$this->statusId = AccountStatus::INACTIVE;
	}

	/**
	 * @var bool
	 */
	private $permissionsChanged = false;
	private $removedPermissions = array();
	private $addedPermissions = array();

	/**
	 * @var array
	 */
	protected $allowedResourceIds = array();

	/**
	 * @var string
	 * @internal
	 */
	public $encryptedPassword;

	/**
	 * @var string
	 * @internal
	 */
	public $passwordSalt;

	private $attributes = array();
	private $attributesChanged = false;

	private $isGroupAdmin = false;
	private $isApplicationAdmin = false;
	private $isResourceAdmin = false;

	/**
	 * @param array|int[] $allowedResourceIds
	 * @return void
	 */
	public function WithPermissions($allowedResourceIds = array())
	{
		$this->permissionsChanged = false;
		$this->allowedResourceIds = $allowedResourceIds;
	}

	/**
	 * @param array|UserGroup[] $groups
	 * @return void
	 */
	public function WithGroups($groups = array())
	{
        $adminGroupIds = array();
        $groupsWithAdminId = array();

		foreach ($groups as $group)
		{
			if ($group->IsGroupAdmin)
			{
				$this->isGroupAdmin = true;
                $adminGroupIds[$group->GroupId] = true;
			}
			if ($group->IsApplicationAdmin)
			{
				$this->isApplicationAdmin = true;
			}
			if ($group->IsResourceAdmin)
			{
				$this->isResourceAdmin = true;
			}

            if (!empty($group->AdminGroupId))
            {
                $groupsWithAdminId[] = $group;
            }
		}

        $this->groups = $groups;

        foreach ($groupsWithAdminId as $g)
        {
            if (array_key_exists($g->AdminGroupId, $adminGroupIds))
            {
                $this->groupsICanAdminister[] = $g;
            }
        }
	}

	public function ChangePermissions($allowedResourceIds = array())
	{
		$removed = array_diff($this->allowedResourceIds, $allowedResourceIds);
		$added = array_diff($allowedResourceIds, $this->allowedResourceIds);

		if (!empty($removed) || !empty($added))
		{
			$this->permissionsChanged = true;
			$this->removedPermissions = $removed;
			$this->addedPermissions = $added;

			$this->allowedResourceIds = $allowedResourceIds;
		}
	}

	/**
	 * @return array
	 */
	public function AllowedResourceIds()
	{
		return $this->allowedResourceIds;
	}

	/**
	 * @internal
	 * @param IEmailPreferences $emailPreferences
	 * @return void
	 */
	public function WithEmailPreferences(IEmailPreferences $emailPreferences)
	{
		$this->emailPreferences = $emailPreferences;
	}

	/**
	 * @param IDomainEvent $event
	 * @return bool
	 */
	public function WantsEventEmail(IDomainEvent $event)
	{
		return $this->emailPreferences->Exists($event->EventCategory(), $event->EventType());
	}

	/**
	 * @param IDomainEvent $event
	 * @param bool $turnedOn
	 */
	public function ChangeEmailPreference(IDomainEvent $event, $turnedOn)
	{
		if ($turnedOn)
		{
			$this->emailPreferences->AddPreference($event);
		} else
		{
			$this->emailPreferences->RemovePreference($event);
		}
	}

	/**
	 * @param string $loginTime
	 * @param string $language
	 */
	public function Login($loginTime, $language)
	{
		$this->lastLogin = $loginTime;
		$this->language = $language;
	}

	/**
	 * @return array|IDomainEvent[]
	 */
	public function GetAddedEmailPreferences()
	{
		return $this->emailPreferences->GetAdded();
	}

	/**
	 * @return array|IDomainEvent[]
	 */
	public function GetRemovedEmailPreferences()
	{
		return $this->emailPreferences->GetRemoved();
	}

	public static function FromRow($row)
	{
		$user = new User();
		$user->id = $row[ColumnNames::USER_ID];
		$user->firstName = $row[ColumnNames::FIRST_NAME];
		$user->lastName = $row[ColumnNames::LAST_NAME];
		$user->emailAddress = $row[ColumnNames::EMAIL];
		$user->username = $row[ColumnNames::USERNAME];
		$user->language = $row[ColumnNames::LANGUAGE_CODE];
		$user->timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->statusId = $row[ColumnNames::USER_STATUS_ID];
		$user->encryptedPassword = $row[ColumnNames::PASSWORD];
		$user->passwordSalt = $row[ColumnNames::SALT];
		$user->homepageId = $row[ColumnNames::HOMEPAGE_ID];
		$user->lastLogin = $row[ColumnNames::LAST_LOGIN];
        $user->isCalendarSubscriptionAllowed = $row[ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION];
        $user->publicId = $row[ColumnNames::PUBLIC_ID];

		$user->attributes[UserAttribute::Phone] = $row[ColumnNames::PHONE_NUMBER];
		$user->attributes[UserAttribute::Position] = $row[ColumnNames::POSITION];
		$user->attributes[UserAttribute::Organization] = $row[ColumnNames::ORGANIZATION];

		return $user;
	}

	public static function Create($firstName, $lastName, $emailAddress, $userName, $language, $timezone, $password, $passwordSalt)
	{
		$user = new User();
		$user->firstName = $firstName;
		$user->lastName = $lastName;
		$user->emailAddress = $emailAddress;
		$user->username = $userName;
		$user->language = $language;
		$user->timezone = $timezone;
		$user->encryptedPassword = $password;
		$user->passwordSalt = $passwordSalt;
		$user->homepageId = Pages::DEFAULT_HOMEPAGE_ID;
		return $user;
	}

	/**
	 * @param int $userId
	 */
	public function WithId($userId)
	{
		$this->id = $userId;
	}

	/**
	 * @param string $loginTime
	 */
	public function WithLastLogin($loginTime)
	{
		$this->lastLogin = $loginTime;
	}

	/**
	 * @internal
	 * @return array
	 */
	public function GetAddedPermissions()
	{
		return $this->addedPermissions;
	}

	/**
	 * @internal
	 * @return array
	 */
	public function GetRemovedPermissions()
	{
		return $this->removedPermissions;
	}

	/**
	 * @param string $encryptedPassword
	 * @param string $salt
	 */
	public function ChangePassword($encryptedPassword, $salt)
	{
		$this->encryptedPassword = $encryptedPassword;
		$this->passwordSalt = $salt;
	}

	public function ChangeName($firstName, $lastName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}

	public function ChangeEmailAddress($emailAddress)
	{
		$this->emailAddress = $emailAddress;
	}

	public function ChangeUsername($username)
	{
		$this->username = $username;
	}

	public function ChangeDefaultHomePage($homepageId)
	{
		$this->homepageId = $homepageId;
	}

	public function ChangeTimezone($timezoneName)
	{
		$this->timezone = $timezoneName;
	}

	public function ChangeAttributes($phone, $organization, $position)
	{
		$this->attributesChanged = true;

		$this->attributes[UserAttribute::Phone] = $phone;
		$this->attributes[UserAttribute::Organization] = $organization;
		$this->attributes[UserAttribute::Position] = $position;
	}

	public function HaveAttributesChanged()
	{
		return $this->attributesChanged;
	}

	/**
	 * @param UserAttribute|string $attributeName
	 * @return string
	 */
	public function GetAttribute($attributeName)
	{
		if (key_exists($attributeName, $this->attributes))
		{
			return $this->attributes[$attributeName];
		}
		return null;
	}

	/**
	 * @return bool
	 */
	public function IsGroupAdmin()
	{
		return $this->isGroupAdmin;
	}

    /**
     * @param User $user
     * @return bool
     */
	public function IsAdminFor(User $user)
	{
		if (!$this->isGroupAdmin)
		{
			return false;
		}

		$adminIdsForUser = array();
		foreach ($user->Groups() as $userGroup)
		{
			if (!empty($userGroup->AdminGroupId))
			{
				$adminIdsForUser[$userGroup->AdminGroupId] = true;
			}
		}

		foreach ($this->Groups() as $group)
		{
			if ($group->IsGroupAdmin)
			{
				if (array_key_exists($group->GroupId, $adminIdsForUser))
				{
					return true;
				}
			}
		}

		return false;
	}

    /**
     * @param IResource $resource
     * @return bool
     */
    public function IsResourceAdminFor(IResource $resource)
    {
       if (!$this->isResourceAdmin)
       {
           return false;
       }

        foreach ($this->groups as $group)
        {
            if ($group->GroupId == $resource->GetAdminGroupId())
            {
                return true;
            }
        }

        return false;
    }

	/**
	 * @param int|RoleLevel $roleLevel
	 * @return bool
	 */
	public function IsInRole($roleLevel)
	{
		if ($roleLevel == RoleLevel::GROUP_ADMIN)
		{
			return $this->isGroupAdmin;
		}
		if ($roleLevel == RoleLevel::APPLICATION_ADMIN)
		{
			return $this->isApplicationAdmin;
		}
		if ($roleLevel == RoleLevel::RESOURCE_ADMIN)
		{
			return $this->isResourceAdmin;
		}

		return false;
	}

	/**
	 * @static
	 * @return User
	 */
	public static function Null()
	{
		return new NullUser();
	}

    /**
     * @return array|UserGroup[]
     */
    public function GetAdminGroups()
    {
        return $this->groupsICanAdminister;
//        $adminGroups = array();
//
//        foreach ($this->Groups() as $group)
//        {
//            if ($group->IsGroupAdmin)
//            {
//                $adminGroups[] = $group;
//            }
//        }
//
//        return $adminGroups;
    }
}

class NullUser extends User
{
}

class UserAttribute
{
	const Phone = 'phone';
	const Organization = 'organization';
	const Position = 'position';

	/**
	 * @var array|string[]
	 */
	private $attributeValues = array();

	public function __construct($attributeValues = array())
	{
		$this->attributeValues = $attributeValues;
	}

	/**
	 * @param string|UserAttribute $attributeName
	 * @return null|string
	 */
	public function Get($attributeName)
	{
		if (array_key_exists($attributeName, $this->attributeValues))
		{
			return $this->attributeValues[$attributeName];
		}

		return null;
	}
}

class UserGroup
{
	/**
	 * @var int
	 */
	public $GroupId;

	/**
	 * @var string
	 */
	public $GroupName;

	/**
	 * @var int|null
	 */
	public $AdminGroupId;

	/**
	 * @var bool
	 */
	public $IsGroupAdmin = false;

	/**
	 * @var bool
	 */
	public $IsApplicationAdmin = false;

	/**
	 * @var bool
	 */
	public $IsResourceAdmin = false;

	/**
	 * @param int $groupId
	 * @param string $groupName
	 * @param int|null $adminGroupId
	 * @param int|RoleLevel $roleLevel defaults to none
	 */
	public function __construct($groupId, $groupName, $adminGroupId = null, $roleLevel = RoleLevel::NONE)
	{
		$this->GroupId = $groupId;
		$this->GroupName = $groupName;
		$this->AdminGroupId = $adminGroupId;
		$this->AddRole($roleLevel);
	}

	/**
	 * @param int|null|RoleLevel $roleLevel
	 */
	public function AddRole($roleLevel = null)
	{
		if ($roleLevel == RoleLevel::GROUP_ADMIN)
		{
			$this->IsGroupAdmin = true;
		}
		if ($roleLevel == RoleLevel::APPLICATION_ADMIN)
		{
			$this->IsApplicationAdmin = true;
		}
		if ($roleLevel == RoleLevel::RESOURCE_ADMIN)
		{
			$this->IsResourceAdmin = true;
		}
	}
}

?>