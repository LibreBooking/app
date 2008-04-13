<?php

class FakeConfig implements IConfiguration
{
	public $_RegisteredFiles = array();
	public $_values = array();
	
	public function Register($configFile, $configId)
	{		
		$this->_RegisteredFiles[$configId] = $configFile;
	}
	
	public function File($configId)
	{
		return $this->_configs[$configId];
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{	
		//return $this->File(self::DEFAULT_CONFIG_ID)->GetSectionKey($section, $keyName, $converter);
	}
	
	public function GetKey($keyName, $converter = null)
	{		
		$value = null;
		
		if (array_key_exists($keyName, $this->_values))
		{
			$value = $this->_values[$keyName];
		}
		
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
	
	public function SetKey($keyName, $value)
	{
		$this->_values[$keyName] = $value;
	}
}

?>