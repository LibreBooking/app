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

	protected $statusId;


	public function StatusId()
	{
		return $this->statusId;
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
	 * @param int[] $allowedResourceIds
	 * @return void
	 */
	public function WithPermissions($allowedResourceIds = array())
	{
		$this->permissionsChanged = false;
		$this->allowedResourceIds = $allowedResourceIds;
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
		$user->language = $row[ColumnNames::LANGUAGE_CODE];
		$user->timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->statusId = $row[ColumnNames::USER_STATUS_ID];
			
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
}

?>