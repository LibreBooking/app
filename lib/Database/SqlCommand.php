<?php
require_once('namespace.php');

class SqlCommand implements ISqlCommand
{
	public $Parameters = null;
		
	private $_paramNames = array();
	private $_values = array();
	private $_query = null;
	
	public function __construct($query = null) {
		$this->_query = $query;
		$this->Parameters = new Parameters();
	}
	
	public function SetParameters(Parameters &$parameters) {
		$this->_paramNames = array();	// Clean out contents
		$this->_values = array();
		
		$this->Parameters = &$parameters;
		
		for ($i = 0; $i < $this->Parameters->Count(); $i++) {
			$p = $this->Parameters->Items($i);
			$this->_paramNames[] = $p->Name;
			$this->_values[] = $p->Value;
		}
	}
	
	public function AddParameter(Parameter &$parameter) {
		$this->Parameters->Add($parameter);
	}

	public function GetQuery() {
		return $this->_query;
	}
}
?>