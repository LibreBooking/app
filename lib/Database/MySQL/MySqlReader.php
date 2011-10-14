<?php
class MySqlReader implements IReader
{
	private $_result = null;
	
	public function __construct($result) 
	{
		$this->_result = $result;
	}
	
	public function GetRow() 
	{
		return mysql_fetch_assoc($this->_result);
	}
	
	public function NumRows() 
	{
		return mysql_num_rows($this->_result);
	}
	
	public function Free()
	{
		mysql_free_result($this->_result);
	}
}
?>