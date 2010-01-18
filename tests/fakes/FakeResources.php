<?php
class FakeResources extends Resources 
{
	public function __construct()
	{
		
	}
	
	public function GetString($key, $args = array())
	{
		return $key;
	}
	
	public function GetDateFormat($key)
	{
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
}
?>