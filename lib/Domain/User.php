<?php
class User
{
	private $firstName;
	
	/**
	 * @var IEmailPreferences
	 */
	private $emailPreferences;
	
	public function FirstName()
	{
		return $this->firstName;
	}
	
	public function WantsEventEmail(IDomainEvent $event)
	{
		return $this->emailPreferences->Exists($event->EventCategory(), $event->EventType());
	}
	
	public static function FromRow($row, IEmailPreferences $emailPreferences)
	{
		$user = new User();
		$user->firstName = $row[ColumnNames::FIRST_NAME];
	
		$user->emailPreferences = $emailPreferences;
		return $user;
	}
}

?>