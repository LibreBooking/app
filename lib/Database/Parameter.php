<?php
require_once('namespace.php');

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