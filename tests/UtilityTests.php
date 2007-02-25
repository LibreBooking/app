<?php

require_once('../lib/Utility.class.php');
require_once('PHPUnit/Framework.php');

class UtilityTests extends PHPUnit_Framework_TestCase
{
    // contains the object handle of the string class
    var $db = null;

    // constructor of the test suite
    function UtilityTests($name) {
       $this->PHPUnit_Framework_TestCase($name);
    }

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    function setUp() {
        // create the object instance
    }

    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    function tearDown() {
        // delete your instance
    }
	
	function testUtilityBuildsCorrectQueryStringPairs() {
		$util = new Utility();
		
		$query = '?param1=val1&param2=val2&param3=val3';
		
		$pairs = $util->_buildPairs($query);
		$this->assertEquals(3, count($pairs), 'Wrong number of paris');
		$this->assertEquals('val1', $pairs['param1'], 'Wrong value for param1');
		$this->assertEquals('val2', $pairs['param2'], 'Wrong value for param1');
		$this->assertEquals('val3', $pairs['param3'], 'Wrong value for param1');
	}
	

	function testUtilityBuildsCorrectQueryStringWhenOnlyOrderAndVertExist() {
		$util = new Utility();
		$query_string = '?order=lname&vert=ASC';
		
		$query = $util->getSortingUrl($query_string, 'lname');
		$this->assertEquals('?order=lname&amp;vert=DESC', $query);
		
		$query = $util->getSortingUrl($query_string, 'fname');
		$this->assertEquals('?order=fname&amp;vert=ASC', $query);
	}
	
	function testUtilityGetsCorrectRowsForAdditionalResourceAddition() {
		$util = new Utility();
		$orig = $this->getOrigItemRows();
		$added = $this->getAddedItemRows();
		
		$to_add = $util->getAddedItems($orig, $added);
		$this->assertEquals(3, count($to_add), 'The number of rows in the $to_add array is incorrect');
		$this->assertTrue(in_array('id5', $to_add), 'Value should be in the array');
		$this->assertTrue(in_array('id6', $to_add), 'Value should be in the array');
		$this->assertTrue(in_array('id7', $to_add), 'Value should be in the array');
	}
	
	function testUtilityGetsCorrectRowsForAdditionalResourceRemoval() {
		$util = new Utility();
		$orig = $this->getOrigItemRows();
		$added = $this->getAddedItemRows();
		
		$to_remove = $util->getRemovedItems($orig, $added);
		$this->assertEquals(2, count($to_remove), 'The number of rows in the $to_remove array is incorrect');
		$this->assertTrue(in_array('id1', $to_remove), 'Value should be in the array');
		$this->assertTrue(in_array('id2', $to_remove), 'Value should be in the array');
	}
	
	function testUtilityGetsAllRowsForAdditionWhenOrigIsEmpty() {
		$util = new Utility();
		$orig = array();
		$added = $this->getAddedItemRows();
		$to_add = $util->getAddedItems($orig, $added);
		$this->assertEquals(count($added), count($to_add), 'Array sizes should be equal');
	}
	
	function testUtilityGetsNoRowsForRemoveWhenOrigIsEmpty() {
		$util = new Utility();
		$orig = array();
		$added = $this->getAddedItemRows();
		$to_remove = $util->getRemovedItems($orig, $added);
		$this->assertEquals(0, count($to_remove), 'Array should be empty');
	}
	
		
	function getOrigItemRows() {
		$orig = array('id1', 'id2', 'id3', 'id4');
		return $orig;
	}
	
	function getAddedItemRows() {
		$orig = array('id5', 'id3', 'id4', 'id6', 'id7');
		return $orig;
	}
}
?>