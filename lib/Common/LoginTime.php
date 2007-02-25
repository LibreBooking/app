<?php
class LoginTime
{
	public static $Now = null;
	
	private $_format = 'Y-m-d H:is';
	
	public static function Now()
	{
		if (empty(self::$Now))
		{
			return date(self::$_format);
		}
		else 
		{
			return date(self::$_format, self::$Now);
		}
	}
}
?>