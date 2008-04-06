<?php
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

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
		$userid = 1;
		$time = new LoginTime();
		
		$command = new UpdateLoginTimeCommand($userid, $time->Now());
		
		$this->assertEquals(Queries::UPDATE_LOGINTIME, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		
		$this->assertEquals(ParameterNames::LAST_LOGIN, $par1->Name);
		$this->assertEquals($time->Now(), $par1->Value);		
		$this->assertEquals(ParameterNames::USER_ID, $par2->Name);
		$this->assertEquals($userid, $par2->Value);
	}
	
	function testMigratePasswordCommand()
	{
		$userid = 1;
		$password = 'encrypted';
		$salt = 'salt';
		
		$command = new MigratePasswordCommand($userid, $password, $salt);
		
		$this->assertEquals(Queries::MIGRATE_PASSWORD, $command->GetQuery());
		$this->assertEquals(3, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$par2 = $command->Parameters->Items(1);
		$par3 = $command->Parameters->Items(2);
		
		$this->assertEquals(ParameterNames::USER_ID , $par1->Name);
		$this->assertEquals($userid, $par1->Value);		
		
		$this->assertEquals(ParameterNames::PASSWORD , $par2->Name);
		$this->assertEquals($password, $par2->Value);
		
		$this->assertEquals(ParameterNames::SALT , $par3->Name);
		$this->assertEquals($salt, $par3->Value);
	}
	
	function testCookieLoginCommand()
	{
		$userid = 10;
		$command = new CookieLoginCommand($userid);
		
		$this->assertEquals(Queries::COOKIE_LOGIN, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $userid), $par1);	
	}
	
	function testCheckUserExistanceCommand()
	{
		$username = 'username';
		$email = 'email';
		
		$command = new CheckUserExistanceCommand($username, $email);
		
		$this->assertEquals(Queries::CHECK_USER_EXISTANCE, $command->GetQuery());
		$this->assertEquals(2, $command->Parameters->Count());
		
		$this->assertEquals(new Parameter(ParameterNames::USER_NAME, $username), $command->Parameters->Items(0));
		$this->assertEquals(new Parameter(ParameterNames::EMAIL_ADDRESS, $email), $command->Parameters->Items(1));
	}
	
	function testCheckEmailCommand()
	{
		$email = 'some@email.com';
		$command = new CheckEmailCommand($email);
		
		$this->assertEquals(Queries::CHECK_EMAIL, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::EMAIL_ADDRESS, $email), $command->Parameters->Items(0));
	}
	
	function testCheckUsernameCommand()
	{
		$username = 'username';
		$command = new CheckUsernameCommand($username);
		
		$this->assertEquals(Queries::CHECK_USERNAME, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USER_NAME , $username), $command->Parameters->Items(0));
	}
	
	function testRegisterUserCommand()
	{
		$username = 'testlogin';
		$email = 'test@test.com';
		$fname = 'First';
		$lname = 'Last';
		$password = 'password';
		$salt = '23948';
		$timezone = 'US/Eastern';
		$phone = '123.123.1234';
		$institution = 'inst';
		$position = 'pos';
		
		$command = new RegisterUserCommand($username, $email, $fname, $lname, $password, $salt, 
							$timezone, $phone, $institution, $position);
		
		$this->assertEquals(Queries::REGISTER_USER, $command->GetQuery());
		$this->assertEquals(10, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USER_NAME, $username), $command->Parameters->Items(0));
		$this->assertEquals(new Parameter(ParameterNames::EMAIL_ADDRESS, $email), $command->Parameters->Items(1));
		$this->assertEquals(new Parameter(ParameterNames::FIRST_NAME, $fname), $command->Parameters->Items(2));
		$this->assertEquals(new Parameter(ParameterNames::LAST_NAME, $lname), $command->Parameters->Items(3));
		$this->assertEquals(new Parameter(ParameterNames::PASSWORD, $password), $command->Parameters->Items(4));
		$this->assertEquals(new Parameter(ParameterNames::SALT, $salt), $command->Parameters->Items(5));
		$this->assertEquals(new Parameter(ParameterNames::TIMEZONE, $timezone), $command->Parameters->Items(6));
		$this->assertEquals(new Parameter(ParameterNames::PHONE, $phone), $command->Parameters->Items(7));
		$this->assertEquals(new Parameter(ParameterNames::INSTITUTION, $institution), $command->Parameters->Items(8));
		$this->assertEquals(new Parameter(ParameterNames::POSITION, $position), $command->Parameters->Items(9));
	}
	
	function testGetUserRoleCommand()
	{
		$userid = 123;
		
		$command = new GetUserRoleCommand($userid);
		$this->assertEquals(Queries::GET_USER_ROLES, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $userid), $command->Parameters->Items(0));
	}
}
?>