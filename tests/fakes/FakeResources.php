<?php
class FakeResources extends Resources 
{
	private $_dateFormats = array();
	
	public function __construct()
	{
		
	}
	
	public function GetString($key, $args = array())
	{
		return $key;
	}
	
	public function GetDateFormat($key)
	{
		if (array_key_exists($key, $this->_dateFormats))
		{
			return $this->_dateFormats[$key];
		}
		return $key;
	}
	
	public function GetDays($key)
	{
		return $key;
	}
	
	public function GetMonths($key)
	{
		return $key;
	}
	
	public function SetDateFormat($key, $value)
	{
		$this->_dateFormats[$key] = $value;
	}
}
?>