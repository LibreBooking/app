<?php

require_once('DBConnection.class.php');

class Database
{
	var $command = '';
	var $parameters = null;
	var $connection = null;
	
	var $_paramNames = array();
	var $_values = array();

	function Database(&$dbConnection) {
		$this->connection = $dbConnection;
		$this->parameters = new Parameters();
	}
	
	function setParameters(&$parameters) {
		$this->_paramNames = array();	// Clean out contents
		$this->_values = array();
		
		$this->parameters = $parameters;
		
		for ($i = 0; $i < $this->parameters->count(); $i++) {
			$p = $this->parameters->items($i);
			$this->_paramNames[] = $p->name;
			$this->_values[] = $p->value;
		}
	}
	
	function setCommand($command) {
//		$matches = array();
//		preg_match_all("/\@[\w\d]+/", $command, $matches);
//		if (sizeof($matches) > 0) {
//			$this->_paramNames = $matches[0];
//		}
//		unset($matches);
		
		$this->connection->setCommand($command);
	}
	
	function &query() {		
		return $this->connection->query($this->_paramNames, $this->_values);
	}
}

class Parameters
{
	var $_parameters = array();
	var $_count = 0;
	
	function Parameters() { }
	
	function add(&$parameter) {
		$this->_parameters[] = $parameter;
		$this->_count++;
	}
	
	function remove(&$parameter) {
		for ($i = 0; $i < $this->_count; $i++) {
			if ($this->_parameters[$i] == $parameter) {
				$this->removeAt($i);
			}
		}
	}
	
	function removeAt($index) {
		unset($this->_parameters[$index]);
		$this->_parameters = array_values($this->_parameters);	// Re-index the array
		$this->_count--;
	}
	
	function &items($index) {
		return $this->_parameters[$index];
	}
	
	function count() {
		return $this->_count;
	}
}

class Parameter
{
	var $name = '';
	var $value = '';
	
	function Parameter($name = '', $value = '') {
		$this->name = $name;
		$this->value = $value;
	}
}

?>