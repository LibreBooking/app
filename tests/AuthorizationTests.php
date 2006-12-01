<?php
require_once('PHPUnit.php');
require_once('../lib/Authorization/namespace.php');
require_once('../lib/Common/namespace.php');
require_once('fakes/DBFakes.php');

class AuthorizationTests extends PHPUnit_TestCase
{
	var $cols;
	var $username;
	var $password;
	var $db;
	
	
	function setup()
	{
		$this->cols = new ColumnNames();
		
		$this->username = 'LoGInName';
		$this->password = 'password';
		
		$this->db = new FakeDatabase();
	}
	
	function teardown()
	{
		$this->db = null;
	}
	
	function testValidateChecksAgainstDB()
	{	
		$rows = array('count' => 1);
		$reader = new FakeDBResult($rows);
			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db);
		$authenticated = $auth->Validate($this->username, $this->password);
		
		$command = new AuthorizationCommand(strtolower($this->username), $this->password);
		
		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertTrue($authenticated);
	}
	
	function testLoginGetsUserDataFromDatabase()
	{
		LoginTime::Now = mktime();
		
		$persist = true;
		$id = 'someexpectedid';
		
		$rows = array(
					$this->cols->USER_ID => $id
					);
					
		$reader = new FakeDBResult($rows);
			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db);
		$authenticated = $auth->Login(strtolower($this->username), $persist);
		
		$command1 = new LoginCommand(strtolower($this->username));
		$command2 = new UpdateLoginTimeCommand($id, );
		
		$this->assertEquals(2, count($this->db->_Commands));
		$this->assertEquals($command1, $this->db->_Commands[0]);	
		$this->assertEquals($command2, $this->db->_Commands[1]);
	}
}
?>