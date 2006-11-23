<?php
require_once('/lib/Database/namespace.php');
require_once('/lib/pear/MDB2.php');

class FakeDatabase extends Database
{
	var $reader;
	var $_LastCommand;
	
	function FakeDatabase()
	{
		
	}
	
	function SetReader(&$reader)
	{
		$this->reader = $reader;
	}
	
	function &Query(&$command) 
	{
		$this->_LastCommand = $command;
		return $this->reader;
	}
	
	function Execute(&$command) 
	{
		$this->_LastCommand = $command;
	}
}

class FakeDBConnection extends IDBConnection
{
	var $_LastQueryCommand = null;
	var $_LastExecuteCommand = null;
	var $_ConnectWasCalled = false;
	var $_DisconnectWasCalled = false;
	
	function FakeDBConnection() { }
	
	function Connect() { 
		$this->_ConnectWasCalled = true;
	}
	
	function Disconnect() { 
		$this->_DisconnectWasCalled = true;
	}

	function &Query(&$command) { 
		$this->_LastSqlCommand = $command;
	} 
	
	function &Execute() { 
		$this->_LastExecuteCommand = $command;
	}
}

class FakePearDB extends MDB2
{
	var $dsn = '';
	var $permcn = false;
	var $result = null;
	
	var $PrepareHandle = null;
	
	var $_PrepareWasCalled = false;
	var $_LastPreparedQuery = '';
	var $_PrepareAutoDetect = false;
	var $_PrepareType = -1;
	
	function FakePearDB(&$results) {
		$this->result = $results;
	}
	
	function connect($dsn, $permcn) {
		$this->dsn = $dsn;
		$this->permcn = $permcn;
	}
	
	function &prepare($query, $autodetect, $prepareType) {
		$this->_LastPreparedQuery = $query;
		$this->_PrepareWasCalled = true;
		$this->_PrepareAutoDetect = $autodetect;
		$this->_PrepareType = $prepareType;
		return $this->PrepareHandle;
	}
}

class FakeDBResult extends MDB2_Result_Common
{
	var $rows = array();
	var $idx = 0;
	var $_FreeWasCalled = false;
	
	function FakeDBResult($rows) {
		$this->rows = $rows;
	}
	
	function &fetchRow() {
		return $this->rows[$this->idx++];
	}
	
	function numRows() {
		return sizeof($this->rows);
	}
	
	function free() {
		$this->_FreeWasCalled = true;
	}
}

class FakePrepareHandle extends MDB2_Statement_Common
{
	var $result = null;
	var $_ExecuteWasCalled = false;
	var $_LastExecutedValues = array();
	
	function FakePrepareHandle(&$result) {
		$this->result = $result;
	}
	
	function &execute($values) {
		$this->_ExecuteWasCalled = true;
		$this->_LastExecutedValues = $values;
		return $this->result;
	}
}

?>