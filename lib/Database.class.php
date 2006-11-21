<?php

require_once('DBConnection.class.php');

class Database
{
	var $Command = '';
	var $Parameters = null;
	var $Connection = null;
	
	var $_paramNames = array();
	var $_values = array();

	function Database(&$dbConnection) {
		$this->Connection = $dbConnection;
		$this->Parameters = new Parameters();
	}
	
	function SetParameters(&$parameters) {
		$this->_paramNames = array();	// Clean out contents
		$this->_values = array();
		
		$this->Parameters = $parameters;
		
		for ($i = 0; $i < $this->Parameters->Count(); $i++) {
			$p = $this->Parameters->Items($i);
			$this->_paramNames[] = $p->Name;
			$this->_values[] = $p->Value;
		}
	}
	
	function SetCommand($command) {
//		$matches = array();
//		preg_match_all("/\@[\w\d]+/", $command, $matches);
//		if (sizeof($matches) > 0) {
//			$this->_paramNames = $matches[0];
//		}
//		unset($matches);
		
		$this->Connection->SetCommand($command);
	}
	
	function &Query() {		
		return $this->Connection->Query($this->_paramNames, $this->_values);
	}
}

class Parameters
{
	var $_parameters = array();
	var $_count = 0;
	
	function Parameters() { }
	
	function Add(&$parameter) {
		$this->_parameters[] = $parameter;
		$this->_count++;
	}
	
	function Remove(&$parameter) {
		for ($i = 0; $i < $this->_count; $i++) {
			if ($this->_parameters[$i] == $parameter) {
				$this->removeAt($i);
			}
		}
	}
	
	function RemoveAt($index) {
		unset($this->_parameters[$index]);
		$this->_parameters = array_values($this->_parameters);	// Re-index the array
		$this->_count--;
	}
	
	function &Items($index) {
		return $this->_parameters[$index];
	}
	
	function Count() {
		return $this->_count;
	}
}

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