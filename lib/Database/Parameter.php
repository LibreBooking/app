<?php
//require_once('namespace.php');

class Parameter
{
	public $Name = null;
	public $Value = null;
	
	public function __construct($name = null, $value = null) 
	{
		$this->Name = $name;
		$this->Value = $value;
	}
}
?>