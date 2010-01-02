<?php
require_once(ROOT_DIR . 'lib/pear/Config.php');

interface IConfiguration extends IConfigurationFile
{
	public function Register($configFile, $configId);
	public function File($configId);
}

interface IConfigurationFile
{
	public function GetSectionKey($section, $name, $converter = null);
	public function GetKey($name, $converter = null);
}

class Configuration implements IConfiguration
{
	protected $_configs = array();
	private static $_instance = null;
	
	const SETTINGS = 'settings';
	const DEFAULT_CONFIG_ID = 'phpscheduleit';
	const DEFAULT_CONFIG_FILE_PATH = '/config/newconfig.php';
	
	protected function __construct()
	{
	}
	
	/**
	 * @return IConfigurationFile
	 */
	public static function Instance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new Configuration();
			self::$_instance->Register(
					dirname(__FILE__) . '/../../' . self::DEFAULT_CONFIG_FILE_PATH, 
					self::DEFAULT_CONFIG_ID);
		}
		
		return self::$_instance;
	}
	
	public static function SetInstance($value)
	{
		self::$_instance = $value;
	}
	
	public function Register($configFile, $configId, $overwrite = false)
	{		
		$config = new Config();
		$container = $config->parseConfig($configFile, "PHPArray");
		
		$this->AddConfig($configId, $container, $overwrite);
	}
	
	public function File($configId)
	{
		return $this->_configs[$configId];
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{	
		return $this->File(self::DEFAULT_CONFIG_ID)->GetSectionKey($section, $keyName, $converter);
	}
	
	public function GetKey($keyName, $converter = null)
	{
		return $this->File(self::DEFAULT_CONFIG_ID)->GetKey($keyName, $converter);
	}

	protected function AddConfig($configId, $container, $overwrite)
	{		
		if (!$overwrite)
		{		
			if (array_key_exists($configId, $this->_configs))
			{
				throw new Exception('Configuration already exists');
			}
		}
		
		$this->_configs[$configId] = new ConfigurationFile($container->getItem("section", self::SETTINGS)->toArray());
	}
}

class ConfigurationFile implements IConfigurationFile
{
	private $_values = array();
	
	public function __construct($values)
	{
		$this->_values = $values[Configuration::SETTINGS];
	}
	
	public function GetKey($keyName, $converter = null)
	{		
		if (array_key_exists($keyName, $this->_values))
		{
			return $this->Convert($this->_values[$keyName], $converter);
		}
		return null;
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{
		if (array_key_exists($section, $this->_values) && array_key_exists($keyName, $this->_values[$section]))
		{
			return $this->Convert($this->_values[$section][$keyName], $converter);
		}
		return null;
	}
	
	protected function Convert($value, $converter)
	{
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
}

?>