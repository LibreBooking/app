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
	 * @param IDomainEvent $event
	 * @return bool
	 */
	public function WantsEventEmail(IDomainEvent $event)
	{
		return $this->emailPreferences->Exists($event->EventCategory(), $event->EventType());
	}
	
	public static function FromRow($row, IEmailPreferences $emailPreferences)
	{
		$user = new User();
		$user->id = $row[ColumnNames::USER_ID];
		$user->firstName = $row[ColumnNames::FIRST_NAME];
		$user->lastName = $row[ColumnNames::LAST_NAME];
		$user->emailAddress = $row[ColumnNames::EMAIL];
		$user->language = $row[ColumnNames::LANGUAGE_CODE];
		$user->timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->statusId = $row[ColumnNames::USER_STATUS_ID];
			
		$user->emailPreferences = $emailPreferences;
		return $user;
	}


}

?>