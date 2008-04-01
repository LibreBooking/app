<?php
//require_once($root . 'config/newconfig.php');

interface IConfiguration
{
	public function GetSectionKey($section, $name, $converter = null);
	public function GetKey($name, $converter = null);
}

class Configuration
{
	private static $_values = array();
	private static $_configs = array();
	private static $_instance = null;
	
	const SETTINGS = 'settings';
	const DEFAULT_CONFIG_ID = 'phpscheduleit';
	
	private function __construct()
	{
	}
	
	private static function AddConfig($configId, $container)
	{
		if (array_key_exists($configId, self::$_configs))
		{
			throw new Exception('Configuration already exists');
		}
		
		self::$_configs[$configId] = new ConfigurationFile($container->getItem("section", self::SETTINGS)->toArray());
	}

	public static function Register($configFile, $configId)
	{		
		$config = new Config();
		$container = $config->parseConfig($configFile, "PHPArray");
		self::AddConfig($configId, $container);
	}
	
	public static function File($configId)
	{
		return self::$_configs[$configId];
	}
	
	public static function GetSectionKey($section, $keyName, $converter = null)
	{	
		return self::File(self::DEFAULT_CONFIG_ID)->GetSectionKey($section, $keyName, $converter);
	}
	
	public static function GetKey($keyName, $converter = null)
	{
		return self::File(self::DEFAULT_CONFIG_ID)->GetKey($keyName, $converter);
		/*
		$readConfig = new Config();
		$readContainer = $readConfig->parseConfig(dirname(__FILE__) . "/test_config.php", "PHPArray");
		
		$settings = $readContainer->getItem("section", 'settings');
		$dbsection = $settings->getItem("section", 'database');
		
		$configValues = $dbsection->toArray();

		$type = $dbsection->getItem("directive", ConfigKeys::DATABASE_TYPE);
		
		*/
		
		//$value = self::$_container->getItem("directive", $name);
				
		//return $value;
		
		$baseSettings = self::Base('phpScheduleIt');
		return $baseSettings[$name];
		
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
	
	protected static function _GetKey($name)
	{
		global $config;		
		return $config[$name];
	}
	

}

class ConfigurationFile implements IConfiguration
{
	private $_values = array();
	
	public function __construct($values)
	{
		$this->_values = $values[Configuration::SETTINGS];
	}
	
	public function GetKey($keyName, $converter = null)
	{		
		return $this->Convert($this->_values[$keyName], $converter);
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{
		return $this->Convert($this->_values[$section][$keyName], $converter);
	}
	
	private function Convert($value, $converter)
	{
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
}

?>