<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class MoodleOptions
{
	const CONFIG_ID = 'moodle';
	
	public function __construct()
	{
		require_once(dirname(__FILE__) . '/Moodle.config.php');

		Configuration::Instance()->Register(
			dirname(__FILE__) . '/Moodle.config.php',
			self::CONFIG_ID);

		Log::Debug('Moodle authentication plugin - Moodle options loaded');
	}

	public function RetryAgainstDatabase()
	{
		return $this->GetConfig('database.auth.when.user.not.found', new BooleanConverter());
	}

	public function GetPath()
	{
		$path = $this->GetConfig('moodle.root.directory');

		if (!BookedStringHelper::StartsWith($path, '/'))
		{
			$path = ROOT_DIR . "/$path";
		}
		if (BookedStringHelper::EndsWith($path, '/'))
		{
			return $path;
		}

		return $path . '/';
	}

	public function GetMoodleCookieId()
	{
		return $this->GetConfig('moodle.cookie.id');
	}


	private function GetConfig($keyName, $converter = null)
	{
		return Configuration::Instance()->File(self::CONFIG_ID)->GetKey($keyName, $converter);
	}
}

?>