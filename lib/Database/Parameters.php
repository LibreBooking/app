<?php
require_once('/lib/Database/namespace.php');

class Parameters
{
	var $_parameters = array();
	var $_count = 0;
	
	function Parameters() { }
	
	function Add(&$parameter) {
		$this->_parameters[] = &$parameter;
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
?>