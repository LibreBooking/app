<?php
require_once('PHPUnit/Framework.php');
require_once('../lib/Authorization/namespace.php');
require_once('../lib/Common/namespace.php');
require_once('../lib/Server/namespace.php');
require_once('../lib/Config/namespace.php');
require_once('fakes/DBFakes.php');
require_once('fakes/FakeServer.php');

class AuthorizationTests extends PHPUnit_Framework_TestCase
{
	var $username;
	var $password;
	var $db;
	var $id;
	var $fname;
	var $lname;
	var $email;
	var $isAdmin;
	var $timeOffset;
	var $fakeServer;
	var $timezone;
	
	function setup()
	{
		$this->username = 'LoGInName';
		$this->password = 'password';
		$this->id = 'someexpectedid';
		$this->fname = 'Test';
		$this->lname = 'Name';
		$this->email = 'my@email.com';
		$this->isAdmin = true;
		$this->timezone = 2;
		
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();	
		
		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		
	}
	
	function teardown()
	{
		$this->db = null;
		$this->fakeServer = null;
		Configuration::Reset();
	}
	
	function testValidateChecksAgainstDB()
	{	
		$encryption = new PasswordEncryption();
		$salt = $encryption->Salt();
		$expectedPassword = $encryption->Encrypt($this->password, $salt);
		
		$rows = array(array(ColumnNames::USER_ID => 1, ColumnNames::PASSWORD => $expectedPassword, ColumnNames::SALT => $salt));
		$reader = new Mdb2Reader(new FakeDBResult($rows));
			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->fakeServer);
		$authenticated = $auth->Validate($this->username, $this->password);
		
		$command = new AuthorizationCommand(strtolower($this->username), $this->password);
		
		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertTrue($authenticated);
	}
	
	function testLoginGetsUserDataFromDatabase()
	{
		LoginTime::$Now = time();
		
		$rows = $this->GetRows();
		$reader = new Mdb2Reader(new FakeDBResult($rows));			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$command1 = new LoginCommand(strtolower($this->username));
		$command2 = new UpdateLoginTimeCommand($this->id, LoginTime::Now());
		
		$this->assertEquals(2, count($this->db->_Commands));
		$this->assertEquals($command1, $this->db->_Commands[0]);	
		$this->assertEquals($command2, $this->db->_Commands[1]);
	}
	
	function testLoginSetsUserInSession()
	{
		$serverTz = -1;
		Configuration::SetKey(ConfigKeys::SERVER_TIMEZONE, $serverTz);
		
		$timeOffset = $this->timezone - $serverTz;
		
		$user = new UserSession($this->id);	
		$user->FirstName = $this->fname;
		$user->LastName = $this->lname;
		$user->Email = $this->email;
		$user->IsAdmin = $this->isAdmin;
		$user->TimeOffset = $timeOffset;
		
		$rows = $this->GetRows();		
		$reader = new Mdb2Reader(new FakeDBResult($rows));			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$this->assertEquals($user, $this->fakeServer->GetSession(SessionKeys::USER_SESSION));
	}
	
	function testUserIsAdminIfEmailMatchesConfigEmail()
	{
		Configuration::SetKey(ConfigKeys::ADMIN_EMAIL, $this->email);
		
		$this->isAdmin = false;
		
		$rows = $this->GetRows();		
		$reader = new Mdb2Reader(new FakeDBResult($rows));				
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$user = $this->fakeServer->GetSession(SessionKeys::USER_SESSION);
		$this->assertTrue($user->IsAdmin);
	}
	
	function testMigratesPasswordWhenSaltIsNotSetButPasswordIsInOldFormat()
	{
		$id = 1;
		$password = 'plaintext';
	
		$oldPassword = md5($password);
		$encryption = new PasswordEncryption();		
		$expectedPassword = $encryption->Encrypt($password, $encryption->Salt());
		
		$rows = array(array(ColumnNames::USER_ID => $id, ColumnNames::PASSWORD => $expectedPassword, ColumnNames::SALT => null, ColumnNames::OLD_PASSWORD => $oldpassword));
		$reader = new Mdb2Reader(new FakeDBResult($rows));
		$this->db->SetReader($reader);
		
		$fakeMigrator = new FakeMigrator();
		
		$auth = new Authorization();
		$auth->SetMigration($fakeMigrator);
		$auth->Validate($username, $password);
		
		$this->assertEquals($oldPassword, $fakeMigration->_LastOldPassword, "did not pass correct value for old password");
		$this->assertEquals($password, $fakeMigration->_PlainText, "did not pass correct value for plain text");
		$this->assertTrue($fakeMigrator->_MigrateCalled);
	}
	
//	function testCanPersistLogin()
//	{	
//		$this->assertEquals(false, true, "Need to get the cookie stuff working");
//		
//		$auth = new Authorization();
//		$auth->Login($username, true);
//		
//		$expectedCookie = new Cookie(CookieKeys::PERSIST_LOGIN, $hashedValue, $expiration, $path);
//		$this->assertEquals($expectedCookie, $this->fakeServer->Cookies[CookieKeys::PERSIST_LOGIN]);
//	}
	
	function testToDo()
	{
		// TODO
		//$this->assertEquals("Implement cookie login", "");
		//$this->assertEquals("Implement password re-hash", "");
	}
	
	function GetRows()
	{
		$row = array(
					ColumnNames::USER_ID => $this->id,
					ColumnNames::FIRST_NAME => $this->fname,
					ColumnNames::LAST_NAME => $this->lname,
					ColumnNames::EMAIL => $this->email,
					ColumnNames::IS_ADMIN => $this->isAdmin,
					ColumnNames::TIMEZONE => $this->timezone
					);
		
		return array($row);
	}
		
}
?>