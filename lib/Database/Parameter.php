<?php
require_once('namespace.php');

class Parameter
{
	public $Name = '';
	public $Value = '';
	
	public function __construct($name = '', $value = '') {
		$this->Name = $name;
		$this->Value = $value;
	}
}
?>