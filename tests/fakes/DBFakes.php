<?php
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/pear/MDB2.php');

class FakeDatabase extends Database
{
	public $reader = array();
	public $_LastCommand;
	public $_Commands = array();
	private $readcount; 

	public function __construct()
	{
		$this->readcount = 0;
	}

	public function SetReader($readerCount, IReader &$reader)
	{
		$this->reader[$readerCount] = &$reader;
	}

	public function &Query(&$command)
	{
		$this->_LastCommand = $command;
		$this->_AddCommand($command);
		return $this->reader[$this->readcount++];
	}

	public function Execute(&$command)
	{
		$this->_LastCommand = $command;
		$this->_AddCommand($command);
	}

	private function _AddCommand(&$command)
	{
		array_push($this->_Commands, $command);
	}
	
	public function SetRows($rows)
	{
		$this->SetRow(0, $rows);
	}
	
	public function SetRow($readerCount, $rows)
	{
		$reader = new Mdb2Reader(new FakeDBResult($rows));
		$this->SetReader($readerCount, $reader);
	}
}

class FakeDBConnection implements IDBConnection
{
	public $_LastQueryCommand = null;
	public $_LastExecuteCommand = null;
	public $_ConnectWasCalled = false;
	public $_DisconnectWasCalled = false;

	public function __construct()
	{
	}

	public function Connect() {
		$this->_ConnectWasCalled = true;
	}

	public function Disconnect() {
		$this->_DisconnectWasCalled = true;
	}

	public function Query(&$command) {
		$this->_LastSqlCommand = $command;
		return null;
	}

	public function Execute(&$command)
	{
		$this->_LastExecuteCommand = $command;
	}
}

class FakePearDB extends MDB2
{
	public $dsn = '';
	public $permcn = false;
	public $result = null;

	public $PrepareHandle = null;

	public $_PrepareWasCalled = false;
	public $_LastPreparedQuery = '';
	public $_PrepareAutoDetect = false;
	public $_PrepareType = -1;

	public function __construct(&$results) {
		$this->result = $results;
	}

	public function connect($dsn, $permcn) {
		$this->dsn = $dsn;
		$this->permcn = $permcn;
	}

	public function &prepare($query, $autodetect, $prepareType) {
		$this->_LastPreparedQuery = $query;
		$this->_PrepareWasCalled = true;
		$this->_PrepareAutoDetect = $autodetect;
		$this->_PrepareType = $prepareType;
		return $this->PrepareHandle;
	}
}

class FakeDBResult extends MDB2_Result_Common
{
	public $rows = array();
	public $idx = 0;
	public $_FreeWasCalled = false;

	public function __construct(&$rows) 
	{
		$this->rows = $rows;
	}

	public function fetchRow() 
	{
		if (sizeof($this->rows) > $this->idx)
		{
			return $this->rows[$this->idx++];
		}
		return false;
	}

	public function NumRows() {
		return sizeof($this->rows);
	}

	public function Free() {
		$this->_FreeWasCalled = true;
	}
}

class FakePrepareHandle extends MDB2_Statement_Common
{
	public $result = null;
	public $_ExecuteWasCalled = false;
	public $_LastExecutedValues = array();

	public function __construct(&$result) {
		$this->result = $result;
	}

	public function &execute($values) {
		$this->_ExecuteWasCalled = true;
		$this->_LastExecutedValues = $values;
		return $this->result;
	}
}
?>