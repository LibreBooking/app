<?php
class FakeUser extends User
{
	public function __construct()
	{
		$this->timezone = 'America/Chicago';
		$this->language = 'en_us';
	}
	
	public function EmailAddress()
	{
		return 'test@test.com';
	}
	
	public function SetLanguage($language)
	{
		$this->language = $language;
	}
	
	public function SetTimezone($timezone)
	{
		$this->timezone = $timezone;
	}

	/**
	 * @param $groups array|UserGroup[]
	 * @return void
	 */
	public function SetGroups($groups)
	{
		$this->groups = $groups;
	}
}
?>