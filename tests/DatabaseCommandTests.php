<?php
require_once('PHPUnit.php');
require_once('../lib/Database/Commands/Commands.php');
require_once('../lib/Common/namespace.php');

class DatabaseCommandTests extends PHPUnit_TestCase
{
	var $names;
	var $queries;

	function setup()
	{
		$this->names = new ParameterNames();
		$this->queries = new Queries();
	}
	
	function teardown()
	{
	}
	
	function testAuthorizationCommand()
	{
		$username = 'loGin';
		$password = 'password';
		
		$command = new AuthorizationCommand($username, $password);
		
		$this->assertEquals($this->queries->VALIDATE_USER, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		
		$this->assertEquals($this->names->USER_NAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
		
		$this->assertEquals($this->names->PASSWORD, $par2->Name);
		$this->assertEquals($password, $par2->Value);
	}
	
	function testLoginCommand()
	{
		$username = 'loGin';	

		$command = new LoginCommand($username);
		
		$this->assertEquals($this->queries->LOGIN_USER, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		
		$this->assertEquals($this->names->USER_NAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
	}
	
	function testUpdateLoginTimeCommand()
	{
		$id = 'someid';
		$time = new LoginTime();
		
		$command = new UpdateLoginTimeCommand($id, $time->Now());
		
		$this->assertEquals($this->queries->UPDATE_LOGINTIME, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		
		$this->assertEquals($this->names->LAST_LOGIN, $par1->Name);
		$this->assertEquals($time->Now(), $par1->Value);		
		$this->assertEquals($this->names->USER_ID, $par2->Name);
		$this->assertEquals($id, $par2->Value);
	}
}
?>