<?php
require_once('namespace.php');

class Mdb2CommandAdapter extends ISqlCommand
{
	var $_values = null;
	var $_query = null;
	
	function Mdb2CommandAdapter(&$command) {
		$_values = array();
		$_query = null;
		
		$this->_Convert($command);
	}
	
	function GetValues() {
		return $this->_values;
	}
	
	function GetQuery() {
		return $this->_query;
	}
	
	function _Convert(&$command) {		
		for ($p = 0; $p < $command->Parameters->Count(); $p++) {
			$curParam = $command->Parameters->Items($p);
			$this->_values[str_replace('@', '', $curParam->Name)] = $curParam->Value;
		}
		
		$this->_query = str_replace('@', ':', $command->GetQuery());
	}
}
?>