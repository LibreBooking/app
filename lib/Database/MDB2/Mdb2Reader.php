<?php
//require_once('namespace.php');

class Mdb2Reader implements IReader
{
	private $_result = null;
	
	/**
	* Takes a PEAR MDB2_Result object to abstract its methods
	* @param MDB2_Result $MDB2_Result
	*/
	public function __construct(&$MDB2_Result) 
	{
		$this->_result = $MDB2_Result;
	}
	
	public function GetRow() 
	{
		return $this->_result->fetchRow();
	}
	
	public function NumRows() 
	{
		return $this->_result->numRows();
	}
	
	public function Free()
	{
		$this->_result->free();
	}
}
?>
