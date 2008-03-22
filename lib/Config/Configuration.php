<?php
//require_once('namespace.php');
require_once($root . 'config/newconfig.php');

class Configuration
{
	private static $_values = array();
	
	private function __construct()
	{	
	}
	
	public static function GetKey($name, $converter = null)
	{
		$value = null;
		
		if (empty(self::$_values[$name]))
		{
			$value = self::_GetKey($name);
		}
		else 
		{
			$value = self::$_values[$name];
		}
		
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
	
	public static function SetKey($name, $value)
	{
		self::$_values[$name] = $value;
	}
	
	public static function Reset()
	{
		self::$_values = array();
	}
	
	private static function _GetKey($name)
	{
		global $config;		
		return $config[$name];
	}
}

?>