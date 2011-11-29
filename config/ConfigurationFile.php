<?php
require_once(ROOT_DIR . 'lib/Config/Configuration.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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

	public function GetScriptUrl()
	{
		$url = strtolower($this->GetKey(ConfigKeys::SCRIPT_URL));

		return rtrim($url, '/');
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
