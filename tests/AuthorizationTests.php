<?php
require_once('PHPUnit.php');
require_once('../lib/Authorization/namespace.php');
require_once('fakes/DBFakes.php');

class AuthorizationTests extends PHPUnit_TestCase
{
	var $cols;
	
	function setup()
	{
		$this->cols = new ColumnNames();
	}
	
	function teardown()
	{
	}
	
	function testValidateChecksAgainstDB()
	{
		$username = 'LoGInName';
		$password = 'password';
		$db = new FakeDatabase();
		
		$rows = array($this->cols->USER_ID => 'someexpectedid');
		$reader = new FakeDBResult($rows);
			
		$db->SetReader($reader);
		
		$auth = new Authorization($db);
		$auth->Validate($username, $password);
		
		$command = new AuthorizationCommand(strtolower($username), $password);
		$this->assertEquals($command, $db->_LastCommand);
		
		/// FIGURE OUT WHAT VALIDATE/LOGIN SHOULD DO ///
	}
}
?>