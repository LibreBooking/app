<?php

require_once('../lib/helpers/ReservationHelper.class.php');
require_once('PHPUnit/Framework.php');

/// FAKES ///


class ReservationHelperTests extends PHPUnit_Framework_TestCase
{
    // contains the object handle of the string class
    var $db = null;

    // constructor of the test suite
    function ReservationHelperTests($name) {
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
	
	function testHelperGetsCorrectRowsForParticipationInvite() {
		$helper = new ReservationHelper();
		$orig = $this->getOrigRows();
		$invited = $this->getInvitedRows();
		
		$to_invite = $helper->getRowsForInvitation($orig, $invited);
		$this->assertEquals(2, count($to_invite), 'The number of rows in the $to_invite array is incorrect');
		
		$this->assertTrue(array_key_exists('id1i', $to_invite), 'ID should be invited');
		$this->assertTrue(array_key_exists('id2i', $to_invite), 'ID should be invited');
		
		$this->assertFalse(array_key_exists('id3', $to_invite), 'ID should not be invited');
		$this->assertFalse(array_key_exists('id4', $to_invite), 'ID should not be invited');
		
		$invited_parts = explode('|', $invited[1]);		
		$this->assertEquals($to_invite[$invited_parts[0]], $invited_parts[1], 'Value for key was incorrect');	
	}
	
    function testHelperGetsCorrectRowsForParticipationRemoval() {
		$helper = new ReservationHelper();
		$orig = $this->getOrigRows();
		$removed = $this->getRemovedRows();
		$invited = $this->getInvitedRows();
		
		$to_remove = $helper->getRowsForRemoval($orig, $removed, $invited);
		$this->assertEquals(count($removed) + 2, count($to_remove), 'The number of rows in the $to_remove array is incorrect');
		
		$this->assertTrue(array_key_exists('id1', $to_remove), 'ID should be removed');
		$this->assertTrue(array_key_exists('id2', $to_remove), 'ID should be removed');
		$this->assertTrue(array_key_exists('id1r', $to_remove), 'ID should be removed');
		$this->assertTrue(array_key_exists('id2r', $to_remove), 'ID should be removed');
		$this->assertTrue(array_key_exists('id3r', $to_remove), 'ID should be removed');
		$this->assertTrue(array_key_exists('id4r', $to_remove), 'ID should be removed');
		
		$this->assertFalse(array_key_exists('id3', $to_remove), 'ID should not be removed');
		$this->assertFalse(array_key_exists('id4', $to_remove), 'ID should not be removed');
		
		$removed_parts = explode('|', $removed[0]);		
		$this->assertEquals($to_remove[$removed_parts[0]], $removed_parts[1], 'Value for key was incorrect');
		
		$removed_parts = explode('|', $orig[0]);
		$this->assertEquals($to_remove[$removed_parts[0]], $removed_parts[1], 'Value for key was incorrect');
	}
	
	
	
	function testHelperGetsCorrectUnchangedUsers() {
		$helper = new ReservationHelper();
		$orig = $this->getOrigRows();
		$added = $this->getInvitedRows();
		
		$unchanged = $helper->getUnchangedUsers($orig, $added);
		$this->assertEquals(2, count($unchanged), 'Unchanged count should be 2');
		$this->assertTrue(array_key_exists('id3', $unchanged), 'Value should be in the array');
		$this->assertTrue(array_key_exists('id4', $unchanged), 'Value should be in the array');
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////
	
	function getOrigRows() {
		$orig = array('id1|email1', 'id2|email2', 'id3|email3', 'id4|email4');
		return $orig;
	}
	
	function getRemovedRows() {
		$removed = array('id2r|email2r', 'id4r|email4r', 'id1r|email1r', 'id3r|email3r');
		return $removed;
	}
	
	function getInvitedRows() {
		$invited = array('id3|email3', 'id1i|email1i', 'id4|email4', 'id2i|email2i');
		return $invited;
	}
}
?>