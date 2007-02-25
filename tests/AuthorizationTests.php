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
	var $cols;
	var $username;
	var $password;
	var $db;
	var $config;
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
		$this->cols = new ColumnNames();
		
		$this->username = 'LoGInName';
		$this->password = 'password';
		$this->id = 'someexpectedid';
		$this->fname = 'Test';
		$this->lname = 'Name';
		$this->email = 'my@email.com';
		$this->isAdmin = true;
		$this->timezone = 2;
		
		$this->config = new Configuration();
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();	
	}
	
	function teardown()
	{
		$this->db = null;
		$this->config->Reset();
	}
	
	function testValidateChecksAgainstDB()
	{	
		$rows = array('count' => 1);
		$reader = new FakeDBResult($rows);
			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db, $this->fakeServer);
		$authenticated = $auth->Validate($this->username, $this->password);
		
		$command = new AuthorizationCommand(strtolower($this->username), $this->password);
		
		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertTrue($authenticated);
	}
	
	function testLoginGetsUserDataFromDatabase()
	{
		$time = new LoginTime();
		$time->Now = mktime();
		
		$reader = new FakeDBResult($this->GetRows());			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db, $this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$command1 = new LoginCommand(strtolower($this->username));
		$command2 = new UpdateLoginTimeCommand($this->id, $time->Now());
		
		$this->assertEquals(2, count($this->db->_Commands));
		$this->assertEquals($command1, $this->db->_Commands[0]);	
		$this->assertEquals($command2, $this->db->_Commands[1]);
	}
	
	function testLoginSetsUserInSession()
	{
		$serverTz = -1;
		$configKeys = new ConfigKeys();
		$this->config->SetKey($configKeys->SERVER_TIMEZONE, $serverTz);
		
		$timeOffset = $this->timezone - $serverTz;
		
		$keys = new SessionKeys();
		$user = new UserSession($this->id);	
		$user->FirstName = $this->fname;
		$user->LastName = $this->lname;
		$user->Email = $this->email;
		$user->IsAdmin = $this->isAdmin;
		$user->TimeOffset = $timeOffset;
		
		$reader = new FakeDBResult($this->GetRows());			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db, $this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$this->assertEquals($user, $this->fakeServer->GetSession($keys->USER_SESSION));
	}
	
	function testUserIsAdminIfEmailMatchesConfigEmail()
	{
		$configKeys = new ConfigKeys();
		$keys = new SessionKeys();
		$this->config->SetKey($configKeys->ADMIN_EMAIL, $this->email);
		
		$this->isAdmin = false;
		
		$reader = new FakeDBResult($this->GetRows());			
		$this->db->SetReader($reader);
		
		$auth = new Authorization($this->db, $this->fakeServer);
		$authenticated = $auth->Login(strtolower($this->username), false);
		
		$user = $this->fakeServer->GetSession($keys->USER_SESSION);
		$this->assertTrue($user->IsAdmin);
	}
	
	function GetRows()
	{
		$row = array(
					$this->cols->USER_ID => $this->id,
					$this->cols->FIRST_NAME => $this->fname,
					$this->cols->LAST_NAME => $this->lname,
					$this->cols->EMAIL => $this->email,
					$this->cols->IS_ADMIN => $this->isAdmin,
					$this->cols->TIMEZONE => $this->timezone
					);
		
		return array($row);
	}
		
}
?>