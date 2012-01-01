<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


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