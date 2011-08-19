<?php
class User
{
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
	 * @var array|GroupUserView[]
	 */
	protected $groups = array();

	/**
	 * @return array|GroupUserView[]
	 */
	public function Groups()
	{
		return $this->groups;
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
	public $password;

	/**
	 * @var string
	 * @internal
	 */
	public $passwordSalt;

	private $attributes = array();
	private $attributesChanged = false;

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
	 * @param array|GroupUserView[] $groups
	 * @return void
	 */
	public function WithGroups($groups = array())
	{
		$this->groups = $groups;
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
		$user->password = $row[ColumnNames::PASSWORD];
		$user->passwordSalt = $row[ColumnNames::SALT];
		$user->homepageId = $row[ColumnNames::HOMEPAGE_ID];

		$user->attributes[UserAttribute::Phone] = $row[ColumnNames::PHONE_NUMBER];
		$user->attributes[UserAttribute::Position] = $row[ColumnNames::POSITION];
		
		return $user;
	}

	public function WithId($userId)
	{
		$this->id = $userId;
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

	public function ChangePassword($password, $salt)
	{
		$this->password = $password;
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
	 * @param UserAttribute $attributeName
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
}

class UserAttribute
{
	const Phone = 'phone';
	const Organization = 'organization';
	const Position = 'position';
}
?>