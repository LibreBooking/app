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
		
		$this->assertEquals(ParameterNames::USERNAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
	}
	
	function testLoginCommand()
	{
		$username = 'loGin';	

		$command = new LoginCommand($username);
		
		$this->assertEquals(Queries::LOGIN_USER, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());
				
		$par1 = $command->Parameters->Items(0);
		
		$this->assertEquals(ParameterNames::USERNAME, $par1->Name);
		$this->assertEquals(strtolower($username), $par1->Value);
	}
	
	function testUpdateLoginTimeCommand()
	{
		$userid = 1;
		$time = new LoginTime();
		LoginTime::$Now = time();
		
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
		
		$this->assertEquals(new Parameter(ParameterNames::USERNAME, $username), $command->Parameters->Items(0));
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
		$this->assertEquals(new Parameter(ParameterNames::USERNAME , $username), $command->Parameters->Items(0));
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
		$language = 'en_US';
		$phone = '123.123.1234';
		$institution = 'inst';
		$position = 'pos';
		$homepageId = 1;
		$status = AccountStatus::AWAITING_ACTIVATION;
		
		$command = new RegisterUserCommand($username, $email, $fname, $lname, $password, $salt, 
							$timezone, $language, $homepageId, $phone, $institution, $position, $status);
		
		$this->assertEquals(Queries::REGISTER_USER, $command->GetQuery());
		$this->assertEquals(13, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USERNAME, $username), $command->Parameters->Items(0));
		$this->assertEquals(new Parameter(ParameterNames::EMAIL_ADDRESS, $email), $command->Parameters->Items(1));
		$this->assertEquals(new Parameter(ParameterNames::FIRST_NAME, $fname), $command->Parameters->Items(2));
		$this->assertEquals(new Parameter(ParameterNames::LAST_NAME, $lname), $command->Parameters->Items(3));
		$this->assertEquals(new Parameter(ParameterNames::PASSWORD, $password), $command->Parameters->Items(4));
		$this->assertEquals(new Parameter(ParameterNames::SALT, $salt), $command->Parameters->Items(5));
		$this->assertEquals(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone), $command->Parameters->Items(6));
		$this->assertEquals(new Parameter(ParameterNames::LANGUAGE, $language), $command->Parameters->Items(7));
		$this->assertEquals(new Parameter(ParameterNames::HOMEPAGE_ID, $homepageId), $command->Parameters->Items(8));
		$this->assertEquals(new Parameter(ParameterNames::PHONE, $phone), $command->Parameters->Items(9));
		$this->assertEquals(new Parameter(ParameterNames::ORGANIZATION, $institution), $command->Parameters->Items(10));
		$this->assertEquals(new Parameter(ParameterNames::POSITION, $position), $command->Parameters->Items(11));
		$this->assertEquals(new Parameter(ParameterNames::USER_STATUS_ID, $status), $command->Parameters->Items(12));
	}
	
	function testGetUserRoleCommand()
	{
		$userid = 123;
		
		$command = new GetUserRoleCommand($userid);
		$this->assertEquals(Queries::GET_USER_ROLES, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $userid), $command->Parameters->Items(0));
	}
	
	function testUpdateUserFromLdapCommand()
	{
		$username = 'testlogin';
		$email = 'test@test.com';
		$fname = 'First';
		$lname = 'Last';
		$password = 'password';
		$salt = '23948';
		$phone = '123.123.1234';
		$institution = 'inst';
		$position = 'pos';
		
		$command = new UpdateUserFromLdapCommand($username, $email, $fname, $lname, $password, $salt, $phone, $institution, $position);
		
		$this->assertEquals(Queries::UPDATE_USER_BY_USERNAME, $command->GetQuery());
		$this->assertEquals(9, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USERNAME, $username), $command->Parameters->Items(0));
		$this->assertEquals(new Parameter(ParameterNames::EMAIL_ADDRESS, $email), $command->Parameters->Items(1));
		$this->assertEquals(new Parameter(ParameterNames::FIRST_NAME, $fname), $command->Parameters->Items(2));
		$this->assertEquals(new Parameter(ParameterNames::LAST_NAME, $lname), $command->Parameters->Items(3));
		$this->assertEquals(new Parameter(ParameterNames::PASSWORD, $password), $command->Parameters->Items(4));
		$this->assertEquals(new Parameter(ParameterNames::SALT, $salt), $command->Parameters->Items(5));
		$this->assertEquals(new Parameter(ParameterNames::PHONE, $phone), $command->Parameters->Items(6));
		$this->assertEquals(new Parameter(ParameterNames::ORGANIZATION, $institution), $command->Parameters->Items(7));
		$this->assertEquals(new Parameter(ParameterNames::POSITION, $position), $command->Parameters->Items(8));		
	}
	
	function testAutoAssignPermissionsCommand()
	{
		$id = 101;
		
		$command = new AutoAssignPermissionsCommand($id);
		$this->assertEquals(Queries::AUTO_ASSIGN_PERMISSIONS, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $id), $command->Parameters->Items(0));
	}
	
	function testGetDashboardAnnouncementsCommand()
	{
		$now = new Date();
		
		$command = new GetDashboardAnnouncementsCommand($now);
		$this->assertEquals(Queries::GET_DASHBOARD_ANNOUNCEMENTS, $command->GetQuery());
		$this->assertEquals(1, $command->Parameters->Count());		
		$this->assertEquals(new Parameter(ParameterNames::CURRENT_DATE, $now->ToDatabase()), $command->Parameters->Items(0));
	}
	
	function testGetAllSchedulesCommand()
	{
		$command = new GetAllSchedulesCommand();
		$this->assertEquals(Queries::GET_ALL_SCHEDULES, $command->GetQuery());
		$this->assertEquals(0, $command->Parameters->Count());	
	}
	
	function testGetReservationsCommand()
	{
		$start = Date::Create(2008, 06, 22);
		$end = Date::Create(2008, 07, 22);
		$scheduleId = 1;
		
		$command = new GetReservationsCommand($start, $end, $scheduleId);
		$this->assertEquals(Queries::GET_RESERVATIONS_COMMAND, $command->GetQuery());
		$p1 = new Parameter(ParameterNames::START_DATE, $start->ToDatabase());
		$p2 = new Parameter(ParameterNames::END_DATE, $end->ToDatabase());
		$this->assertEquals($p1, $command->Parameters->Items(0));
		$this->assertEquals($p2, $command->Parameters->Items(1));
		$this->assertEquals(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId), $command->Parameters->Items(2));
	}
	
	public function testGetScheduleResourcesCommand()
	{
		$scheduleId = 10;
		
		$command = new GetScheduleResourcesCommand($scheduleId);
		
		$this->assertEquals(Queries::GET_SCHEDULE_RESOURCES, $command->GetQuery());
		$this->assertEquals(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId), $command->Parameters->Items(0));
	}
	
	public function testSelectUserPermissionsCommand()
	{
		$userId = 1;
		
		$command = new SelectUserPermissions($userId);
		
		$this->assertEquals(Queries::GET_USER_RESOURCE_PERMISSIONS, $command->GetQuery());
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $userId), $command->Parameters->Items(0));
	}
	
	public function testSelectUserGroupPermissionsCommand()
	{
		$userId = 1;
		
		$command = new SelectUserGroupPermissions($userId);
		
		$this->assertEquals(Queries::GET_GROUP_RESOURCE_PERMISSIONS, $command->GetQuery());
		$this->assertEquals(new Parameter(ParameterNames::USER_ID, $userId), $command->Parameters->Items(0));
	}
	
	public function testGetLayoutCommand()
	{
		$scheduleId = 1;
		
		$command = new GetLayoutCommand($scheduleId);
		
		$this->assertEquals(Queries::GET_SCHEDULE_TIME_BLOCK_GROUPS, $command->GetQuery());
		$this->assertEquals(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId), $command->Parameters->Items(0));
	}
	
	public function testGetAllUsersByStatusCommand()
	{
		$statusId = AccountStatus::ACTIVE;
		$command = new GetAllUsersByStatusCommand($statusId);
		
		$this->assertEquals(Queries::GET_ALL_USERS_BY_STATUS, $command->GetQuery());
		$this->assertEquals(new Parameter(ParameterNames::USER_STATUS_ID, $statusId), $command->Parameters->Items(0));
	}
}
?>