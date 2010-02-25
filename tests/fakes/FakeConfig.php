<?php

class FakeConfig extends Configuration implements IConfiguration
{
	public $_RegisteredFiles = array();
	
	public function Register($configFile, $configId, $overwrite = false)
	{		
		$this->_RegisteredFiles[$configId] = $configFile;
	}
	
	public function __construct()
	{
		$this->_configs[self::DEFAULT_CONFIG_ID] = new FakeConfigFile();
	}
	
	public function SetFile($configId, $file)
	{
		$this->_configs[$configId] = $file;
	}
	
	public function SetKey($keyName, $value)
	{
		$this->File(self::DEFAULT_CONFIG_ID)->SetKey($keyName, $value);
	}
	
	public function SetSectionKey($section, $keyName, $value)
	{
		$this->File(self::DEFAULT_CONFIG_ID)->SetSectionKey($section, $keyName, $value);
	}
	
	public function SetTimezone($timezone)
	{
		$this->SetKey(ConfigKeys::SERVER_TIMEZONE, $timezone);
	}
}

class FakeConfigFile implements IConfigurationFile 
{
	public $_values = array();
	public $_sections = array();
	public $_ScriptUrl = '';
	
	public function GetKey($keyName, $converter = null)
	{		
		$value = null;
		
		if (array_key_exists($keyName, $this->_values))
		{
			$value = $this->_values[$keyName];
		}
		
		return $this->Convert($value, $converter);
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{
		$value = null;
		if (array_key_exists($section, $this->_sections))
		{
			if (array_key_exists($keyName, $this->_sections[$section]))
			{
				$value = $this->_sections[$section][$keyName];
			}
		}
		
		return $this->Convert($value, $converter);
	}
	
	public function SetKey($keyName, $value)
	{
		$this->_values[$keyName] = $value;
	}
	
	public function SetSectionKey($section, $keyName, $value)
	{
		$this->_sections[$section][$keyName] = $value;
	}
	
	protected function Convert($value, $converter)
	{
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
	
	public function GetScriptUrl()
	{
		return $this->_ScriptUrl;
	}
}

?>