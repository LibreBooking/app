<?php

require_once('../lib/Database.class.php');
require_once('PHPUnit.php');

/// FAKES ///
require_once('fakes/DBFakes.php');

class DatabaseTests extends PHPUnit_TestCase
{
    // contains the object handle of the string class
    var $db = null;

    // constructor of the test suite
    function DatabaseTests($name) {
       $this->PHPUnit_TestCase($name);
    }

    // called before the test functions will be executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function setUp() {
        //$cn = new PearDbConnection(null, null, null, null);
        //$this->db = new Database($cn);
    }

    // called after the test functions are executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function tearDown() {
        // delete your instance
        //unset($this->db);
    }

    function testCanCreateConnectionObject() {
        $dbType = 'mysql';
		$dbUser = 'nick';
		$dbPassword = 'password';
		$hostSpec = 'hostspec';
		$dbNames = array('phpscheduleit');
		
		$cn = new PearDbConnection($dbType, $dbUser, $dbPassword, $hostSpec, $dbNames);	
		$this->db = new Database($cn);
		
        $this->assertEquals($dbType, $this->db->connection->dbType);
		$this->assertEquals($dbUser, $this->db->connection->dbUser);
		$this->assertEquals($dbPassword, $this->db->connection->dbPassword);
		$this->assertEquals($hostSpec, $this->db->connection->hostSpec);
		$this->assertEquals($dbNames[0], $this->db->connection->dbNames[0]);
    }
	
	function testParameterStoresCorrectParamNameAndValue() {
		$name = '@paramName';
		$val = 'value';
		
		$parameter = new Parameter($name, $val);
		$this->assertEquals($name, $parameter->name);
		$this->assertEquals($val, $parameter->value);
	}
	
	function testParametersAreAddedToParametersCollection() {
		$name1 = '@paramName1';
		$val1 = 'value1';
		$name2 = '@paramName2';
		$val2 = 'value2';
		
		$p1 = new Parameter($name1, $val1);
		$p2 = new Parameter($name2, $val2);
		
		$parameters = new Parameters();		
		$parameters->add($p1);
		$parameters->add($p2);
		
		$par1 = $parameters->items(0);
		$par2 = $parameters->items(1);
		
		$this->assertEquals(2, $parameters->count(), 'Parameters count is wrong');
		$this->assertEquals($name1, $par1->name, 'Parameter1 name is wrong');
		$this->assertEquals($val1, $par1->value, 'Parameter1 value is wrong');
		$this->assertEquals($name2, $par2->name, 'Parameter2 name is wrong');
		$this->assertEquals($val2, $par2->value, 'Parameter2 value is wrong');
	}
	
	function testParametersCanBeRemovedFromParametersCollection() {
		$name1 = '@paramName1';
		$val1 = 'value1';
		$name2 = '@paramName2';
		$val2 = 'value2';
		
		$p1 = new Parameter($name1, $val1);
		$p2 = new Parameter($name2, $val2);
		
		$parameters = new Parameters();		
		$parameters->add($p1);
		$parameters->add($p2);
		
		$par1 = $parameters->items(0);
		$par2 = $parameters->items(1);
		
		$this->assertEquals(2, $parameters->count(), 'Parameters count is wrong before remove');
		
		$parameters->remove($par1);
		$this->assertEquals(1, $parameters->count(), 'Parameters count is wrong after remove');
		$tmp = $parameters->items(0);
		$this->assertEquals($name2, $tmp->name);
		$this->assertEquals($val2, $tmp->value);
	}
	
	function testParametersAreAssignedToDatabase() {
		$db = new Database(new FakeDBConnection());
		
		$parameters = new Parameters();
		$p1 = new Parameter('n1', 'v1');
		$parameters->add($p1);
		$parameters->add(new Parameter('n2', 'v2'));
		
		$db->setParameters($parameters);
		
		$this->assertNotNull($parameters, 'Parameters object null');
		$this->assertNotNull($db->parameters, 'DB::parameters is null');
		$this->assertEquals($parameters->count(), $db->parameters->count());
		$this->assertEquals($parameters, $db->parameters);
	}
	
	function testDatabaseQueryLoadsValuesInCorrectOrder() {
		$name1 = '@paramName1';
		$val1 = 'value1';
		$name2 = '@paramName2';
		$val2 = 'value2';
		
		$db = new Database(new FakeDBConnection());
		
		$p1 = new Parameter($name1, $val1);
		$p2 = new Parameter($name2, $val2);
		
		$parameters = new Parameters();		
		$parameters->add($p1);
		$parameters->add($p2);
		
		$db->setParameters($parameters);
		
		$this->assertEquals($parameters->count(), count($db->_values), 'Values array count is not correct');
		$this->assertEquals($val1, $db->_values[0], 'Parameter value 1 is not correct');
		$this->assertEquals($val2, $db->_values[1], 'Parameter value 2 is not correct');
		$this->assertEquals($name1, $db->_paramNames[0], 'Parameter name 1 is not correct');
		$this->assertEquals($name2, $db->_paramNames[1], 'Parameter name 2 is not correct');
	}
	
	function testReaderGetRowGetsArrayWhenItHasResults() {
		$result = new FakeDBResult($this->createResultRows());
		
		$reader = new PearReader($result);
		
		$row = $reader->getRow();
		
		$this->assertEquals('1a', $row['col 1'], 'Row value is not equal');
		$this->assertEquals('2a', $row['col 2'], 'Row value is not equal');
		$this->assertEquals('3a', $row['col 3'], 'Row value is not equal');
		
		$row = $reader->getRow();
		$this->assertEquals('1b', $row['col 1'], 'Row value is not equal');
		$this->assertEquals('2b', $row['col 2'], 'Row value is not equal');
		$this->assertEquals('3b', $row['col 3'], 'Row value is not equal');
		
		$row = $reader->getRow();
		$this->assertFalse($row, 'Row should be false');
	}
	
	function testDatabaseQueryReturnsValidReader() {
		$cn = new PearDbConnection(null, null, null, null);
		$cn->_db = new FakePearDB();
		$cn->_db->result = new FakeDBResult($this->createResultRows());
		
		$db = new Database($cn);
		$reader = $db->query(array(), array());
		
		$row = $reader->getRow();
		
		$this->assertEquals('1a', $row['col 1'], 'Row value is not equal');
		$this->assertEquals('2a', $row['col 2'], 'Row value is not equal');
		$this->assertEquals('3a', $row['col 3'], 'Row value is not equal');
		
		$row = $reader->getRow();
		$this->assertEquals('1b', $row['col 1'], 'Row value is not equal');
		$this->assertEquals('2b', $row['col 2'], 'Row value is not equal');
		$this->assertEquals('3b', $row['col 3'], 'Row value is not equal');
		
		$row = $reader->getRow();
		$this->assertFalse($row, 'Row should be false');
	}
	
	function testPearConnectionCallsPrepareBeforeQuery() {
		$cn = new PearDbConnection(null, null, null, null);
		$cn->_db = new FakePearDB();
		
		$cn->query(null, null);
		
		$this->assertTrue($cn->_db->prepareWasCalled, 'Prepare was not called in the Pear connection query');
	}
	
	function testDatabseReaderNumRowsReturnsCorrectNumberOfRows() {
		$result = new FakeDBResult($this->createResultRows());		
		$reader = new PearReader($result);
		
		$this->assertEquals(2, $reader->numRows(), 'Number of rows in reader is not correct');
	}
	
	//function testDatabaseExecuteReturns
	
	function createResultRows() {
		$rows = array();
		$rows[] = array('col 1' => '1a', 'col 2' => '2a', 'col 3' => '3a');
		$rows[] = array('col 1' => '1b', 'col 2' => '2b', 'col 3' => '3b');
		return $rows;
	}
}
?>