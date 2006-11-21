<?php
require_once('namespace.php');

class SqlCommand extends ISqlCommand
{
	var $Parameters = null;
		
	var $_paramNames = array();
	var $_values = array();
	var $_query = null;
	
	function SqlCommand($query = null) {
		$this->_query = $query;
		$this->Parameters = new Parameters();
	}
	
	function SetParameters(&$parameters) {
		$this->_paramNames = array();	// Clean out contents
		$this->_values = array();
		
		$this->Parameters = &$parameters;
		
		for ($i = 0; $i < $this->Parameters->Count(); $i++) {
			$p = $this->Parameters->Items($i);
			$this->_paramNames[] = $p->Name;
			$this->_values[] = $p->Value;
		}
	}
	
	function AddParameter(&$parameter) {
		$this->Parameters->Add($parameter);
	}
	
	function GetQuery() {
		return $this->_query;
	}
}
?>