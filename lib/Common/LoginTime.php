<?php
//require_once('namespace.php');

class LoginTime
{
	public static $Now = null;
	
	private static $_format = 'Y-m-d H:i:s';
	
	public static function Now()
	{
		if (empty(self::$Now))
		{
			$date = new Date();
			return $date->Format(self::$_format);
		}
		else 
		{
			return date(self::$_format, self::$Now);
		}
	}
}
?>