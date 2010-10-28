<?php
class FakeUser extends User
{
	public function __construct()
	{
		$this->timezone = 'US/Central';
		$this->language = 'en_us';
	}
	
	public function SetLanguage($language)
	{
		$this->language = $language;
	}
	
	public function SetTimezone($timezone)
	{
		$this->timezone = $timezone;
	}
}
?>