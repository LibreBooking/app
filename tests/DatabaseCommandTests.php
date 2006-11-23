<?php
require_once('PHPUnit.php');
require_once('../lib/Database/Commands/Commands.php');

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
		$username = 'login';
		$password = 'password';
		
		$command = new AuthorizationCommand($username, $password);
		
		$this->assertEquals($this->queries->VALIDATE_USER, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		
		$this->assertEquals($this->names->USER_NAME, $par1->Name);
		$this->assertEquals($username, $par1->Value);
		
		$this->assertEquals($this->names->PASSWORD, $par2->Name);
		$this->assertEquals($password, $par2->Value);
	}
}
?>