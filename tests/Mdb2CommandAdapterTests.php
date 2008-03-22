<?php
require_once($root . 'lib/Database/Mdb2/namespace.php');

class Mdb2CommandAdapterTests extends PHPUnit_Framework_TestCase
{
	function testDatabaseQueryLoadsValuesInCorrectOrder() {
		$name1 = 'paramName1';
		$val1 = 'value1';
		$name2 = 'paramName2';
		$val2 = 'value2';
		
		$cn = new FakeDBConnection();
		$db = new Database($cn);
		
		$p1 = new Parameter($name1, $val1);
		$p2 = new Parameter($name2, $val2);
		
		$parameters = new Parameters();		
		$parameters->Add($p1);
		$parameters->Add($p2);
		
		$command = new SqlCommand("SELECT * FROM sometable WHERE col1 = @$name1 AND col2 = @$name2");	
		$command->SetParameters($parameters);
		
		$adapter = new Mdb2CommandAdapter($command);
		
		$vals = $adapter->GetValues();
		$this->assertEquals(2, count($vals));
		$this->assertEquals($val1, $vals[$name1]);
		$this->assertEquals($val2, $vals[$name2]);
		$this->assertEquals("SELECT * FROM sometable WHERE col1 = :$name1 AND col2 = :$name2", $adapter->GetQuery());
	}
}
?>