<?php
require_once('/lib/Database/namespace.php');

class Parameter
{
	var $Name = '';
	var $Value = '';
	
	function Parameter($name = '', $value = '') {
		$this->Name = $name;
		$this->Value = $value;
	}
}
?>