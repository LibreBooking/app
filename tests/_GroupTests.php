<?php
require_once('PHPUnit.php');
require_once('fakes/DBFakes.php');
require_once('../lib/Group.class.php');


////////////////////////////////////////////
// TO BE IMPLEMENTED WHEN DB IS REWRITTEN //

class GroupTests extends PHPUnit_TestCase
{
    var $db = null;

    // constructor of the test suite
    function GroupTests($name) {
       $this->PHPUnit_TestCase($name);
    }

    // called before the test functions will be executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function setUp() {
        // create the object instance
    }

    // called after the test functions are executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function tearDown() {
        // delete your instance
    }
	
	function testGroupCanPopulateItself() {
		$results = new FakeDBResult($this->getRows());
		$db = new FakeDBConnection($results);
		
		$data = new GroupDB($db);
		
		$group = new Group($data, 'groupid');
		
		$this->assertTrue($db->prepareWasCalled, 'Prepare was not called');
		$this->assertTrue($db->queryWasCalled, 'Query was not called');
		$this->assertEquals($group->id, $results[0]['groupid'], 'Group id not set');
		$this->assertEquals($group->name, $results[0]['group_name'], 'Group name not set');
		$this->assertEquals($group->adminid, $results[0]['group_admin'], 'Admin id not set');		
	}
	
	function getRows() {
		$rows[] = array('groupid' => 'groupid', 'group_name' => 'group 1', 'group_admin' => 'adminid');
		
		return $rows;
	}
}
?>