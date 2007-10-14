<?php
require_once('PHPUnit/Framework.php');
require_once('../lib/Database/Commands/Commands.php');
require_once('../lib/Common/namespace.php');

class DatabaseCommandTests extends PHPUnit_Framework_TestCase
{	
	function testAuthorizationCommand()
	{
		$username = 'loGin';
		
		$command = new AuthorizationCommand($username);
		
		$this->assertEquals(Queries::VALIDATE_USER, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		
		$this->assertEquals(ParameterNames::USER_NAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
	}
	
	function testLoginCommand()
	{
		$username = 'loGin';	

		$command = new LoginCommand($username);
		
		$this->assertEquals(Queries::LOGIN_USER, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		
		$this->assertEquals(ParameterNames::USER_NAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
	}
	
	function testUpdateLoginTimeCommand()
	{
		$id = 'someid';
		$time = new LoginTime();
		
		$command = new UpdateLoginTimeCommand($id, $time->Now());
		
		$this->assertEquals(Queries::UPDATE_LOGINTIME, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		
		$this->assertEquals(ParameterNames::LAST_LOGIN, $par1->Name);
		$this->assertEquals($time->Now(), $par1->Value);		
		$this->assertEquals(ParameterNames::USER_ID, $par2->Name);
		$this->assertEquals($id, $par2->Value);
	}
}
?>