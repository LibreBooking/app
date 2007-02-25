<?php
require_once('namespace.php');

class Cookie
{
	public $Name;
	public $Value;
	public $Expiration;
	public $Path;
	
	public function __construct($name, $value, $expiration, $path)
	{
		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = $expiration;
		$this->Path = $path;
	}
}
?>