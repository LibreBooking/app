<?php

require_once(ROOT_DIR . 'lib/Common/Date.php');
require_once(ROOT_DIR . 'lib/Common/Helpers/String.php');

class Cookie
{
	public $Name;
	public $Value;
	public $Expiration;
	public $Path;

	public function __construct($name, $value, $expiration = null, $path = null)
	{
		if (is_null($expiration))
		{
			$expiration = Date::Now()->AddDays(30)->TimeStamp();
		}

		if (is_null($path))
		{
			$path = Configuration::Instance()->GetScriptUrl();
		}

		if (BookedStringHelper::StartsWith($path,'http'))
		{
			$parts = parse_url($path);
			$path = isset($parts['path']) ? $parts['path'] : '';
		}

		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = $expiration;    // date(DATE_COOKIE, $expiration);
		$this->Path = $path;
	}

	public function Delete()
	{
		$this->Expiration = date(DATE_COOKIE, Date::Now()->AddDays(-30)->Timestamp());
	}

	public function __toString()
	{
		return sprintf('%s %s %s %s', $this->Name, $this->Value, $this->Expiration, $this->Path);
	}
}
