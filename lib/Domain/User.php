<?php
class User
{
	/**
	 * @var IEmailPreferences
	 */
	protected $emailPreferences;
	
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
		$user->firstName = $row[ColumnNames::FIRST_NAME];
		$user->lastName = $row[ColumnNames::LAST_NAME];
		$user->emailAddress = $row[ColumnNames::EMAIL];
		$user->language = $row[ColumnNames::LANGUAGE_CODE];
		$user->timezone = $row[ColumnNames::TIMEZONE_NAME];
			
		$user->emailPreferences = $emailPreferences;
		return $user;
	}
}

?>