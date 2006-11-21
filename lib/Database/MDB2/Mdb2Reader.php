<?php
require_once('namespace.php');

class Mdb2Reader extends IReader
{
	var $_result = null;
	
	/**
	* Takes a PEAR MDB2_Result object to abstract its methods
	* @param MDB2_Result $MDB2_Result
	*/
	function Mdb2Reader(&$MDB2_Result) {
		$this->_result = $MDB2_Result;
	}
	
	function &GetRow() {
		return $this->_result->fetchRow();
	}
	
	function NumRows() {
		return $this->_result->numRows();
	}
}
?>
