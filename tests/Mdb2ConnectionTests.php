<?php
require_once($root . 'lib/Database/Mdb2/namespace.php');

class Mdb2ConnectionTests extends PHPUnit_Framework_TestCase
{
	var $fakeDb;
	var $fakeResult;
	var $cn;
	var $fakeHandle;

	function setUp() {
        $this->cn = new Mdb2Connection(null, null, null, null, null);
		$empty = array();
        $this->fakeResult = new FakeDBResult($empty);
		$this->fakeDb =& new FakePearDB($this->fakeResult);	
		$this->fakeHandle = new FakePrepareHandle($this->fakeResult);
		$this->fakeDb->PrepareHandle =& $this->fakeHandle;
		$this->cn->SetDb($this->fakeDb);
    }
	
	function tearDown() {
		$this->cn = null;
		$this->fakeResult = null;		
		$this->fakeHandle = null;
		$this->fakeDb->PrepareHandle = null;
		$this->fakeDb = null;
	}
	
    function testCanCreateConnectionObject() {
        $dbType = 'mysql';
		$dbUser = 'nick';
		$dbPassword = 'password';
		$hostSpec = 'hostspec';
		$dbName = 'phpscheduleit';
		
		$cn = new Mdb2Connection($dbType, $dbUser, $dbPassword, $hostSpec, $dbName);	
		$this->db = new Database($cn);
		
        $this->assertEquals($dbType, $this->db->Connection->GetDbType());
		$this->assertEquals($dbUser, $this->db->Connection->GetDbUser());
		$this->assertEquals($dbPassword, $this->db->Connection->GetDbPassword());
		$this->assertEquals($hostSpec, $this->db->Connection->GetHostSpec());
		$this->assertEquals($dbName, $this->db->Connection->GetDbName());
    }

	function testMdb2ConnectionCallsQueryCorrectly() {
		$parameters = new Parameters();		
		$parameters->Add(new Parameter('1', '1'));
		
		$sql = "SELECT * FROM sometable WHERE col1 = @name1";
		
		$command = new SqlCommand($sql);	
		$command->SetParameters($parameters);
		
		$expectedCommand = new Mdb2CommandAdapter($command);
		$expectedResult = new Mdb2Reader($this->fakeResult);		
		
		$result = $this->cn->Query($command);
		
		$this->assertTrue($this->fakeDb->_PrepareWasCalled, 'Prepare was not called');
		$this->assertTrue($this->fakeDb->_PrepareAutoDetect, 'Auto detect param types should be on');		
		$this->assertEquals(MDB2_PREPARE_RESULT, $this->fakeDb->_PrepareType);
		$this->assertEquals(str_replace('@', ':', $sql), $this->fakeDb->_LastPreparedQuery);
		$this->assertEquals($expectedCommand->GetValues(), $this->fakeHandle->_LastExecutedValues);
		$this->assertTrue($this->fakeHandle->_ExecuteWasCalled, 'Execute was not called');		
		$this->assertEquals($expectedResult, $result);
	}
	
	function testMdb2ConnectionCallsExecuteCorrectly() {
		$parameters = new Parameters();		
		$parameters->Add(new Parameter('1', '1'));
		
		$sql = "SELECT * FROM sometable WHERE col1 = @name1";
		
		$command = new SqlCommand($sql);	
		$command->SetParameters($parameters);
		
		$expectedCommand = new Mdb2CommandAdapter($command);
		
		$this->cn->Execute($command);
		
		$this->assertTrue($this->fakeDb->_PrepareWasCalled, 'Prepare was not called');
		$this->assertTrue($this->fakeDb->_PrepareAutoDetect, 'Auto detect param types should be on');		
		$this->assertEquals(MDB2_PREPARE_MANIP, $this->fakeDb->_PrepareType);
		$this->assertEquals(str_replace('@', ':', $sql), $this->fakeDb->_LastPreparedQuery);
		$this->assertEquals($expectedCommand->GetValues(), $this->fakeHandle->_LastExecutedValues);
		$this->assertTrue($this->fakeHandle->_ExecuteWasCalled, 'Execute was not called');
	}
}
?>
