<?php
require_once('namespace.php');

class Cookie
{
	public $Name;
	public $Value;
	public $Expiration;
	public $Path;
	
	public function __construct($name, $value, $expiration = null, $path = null)
	{
		if (is_null($expiration))
		{
			$expiration = Date::Now()->AddDays(30)->DateTime();
		}
		
		if (is_null($path))
		{
			$path = '';
		}
		
		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = $expiration;
		$this->Path = $path;
	}
	
	public function __toString()
	{
		return sprintf('%s %s %s %s', $this->Name, $this->Value, $this->Expiration, $this->Path);
	}
}
?>