<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../../config/newconfig.php');

class Configuration
{
	private static $_values = array();
	
	private function __construct()
	{	
	}
	
	public static function GetKey($name)
	{
		if (empty(self::$_values[$name]))
		{
			return self::_GetKey($name);
		}
		else 
		{
			return self::$_values[$name];
		}
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