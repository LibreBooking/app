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
}
?>