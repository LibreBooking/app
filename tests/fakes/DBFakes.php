<?php
include_once('DB.php');

class FakeDBConnection extends IDBConnection
{
	var $reader = null;
	var $isConnected = false;
	var $_db = null;
	
	function FakeDBConnection($results) {
		parent::IDBConnection(null, null, null, null);
		$this->_db = new FakePearDB($results);
	}
	
	function connect($safeMode = false) { 
		$this->_db->connect('', '');
	}
	
	function disconnect() { }
	
	function setCommand($command) { }
	
	function addParameter($name, $value) { }

	function &query() { } 
	
	function &execute() { }
}

class FakePearDB extends DB
{
	var $dsn = '';
	var $permcn = false;
	var $result = null;
	
	var $prepareWasCalled = false;
	var $queryWasCalled = false;
	var $executeWasCalled = false;
	
	function FakePearDB($results) {
		$this->result = $results;
	}
	
	function connect($dsn, $permcn) {
		$this->dsn = $dsn;
		$this->permcn = $permcn;
	}
	
	function &query($command, $values) {
		$this->queryWasCalled = true;
		$this->prepare();
		return $this->execute($command, $values);
	}
	
	function &execute($command, $values) {
		$this->executeWasCalled = true;
		return $this->result;
	}
	
	function prepare() {
		$this->prepareWasCalled = true;
	}
}

class FakeDBResult extends DB_result
{
	var $rows = array();
	var $idx = 0;
	
	function FakeDBResult(&$rows) {
		$this->rows = $rows;
	}
	
	function &fetchRow() {
		return $this->rows[$this->idx++];
	}
	
	function numRows() {
		return sizeof($this->rows);
	}
}

?>