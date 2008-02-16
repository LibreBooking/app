<?php
require_once('../lib/Authorization/namespace.php');
require_once('fakes/FakeServer.php');
require_once('fakes/FakePasswordEncryption.php');

class RegistrationTests extends PHPUnit_Framework_TestCase
{
	private $registration;
	private $db;
	private $fakeServer;
	private $fakeEncryption;
	
	private $login = 'testlogin';
	private $email = 'test@test.com';
	private $fname = 'First';
	private $lname = 'Last';
	private $additionalFields = array('phone' => '123.123.1234', 'institution' => '', 'position' => '');
	private $password = 'password';
	private $confirm = 'password';
	private $timezone = 'US/Eastern';
	
	public function setUp()
	{
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();
		$this->fakeEncryption = new FakePasswordEncryption();

		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		
		$this->registration = new Registration($this->fakeEncryption);
	}
	
	public function tearDown()
	{
		$this->db = null;
		$this->fakeServer = null;
		$this->registration = null;
		
		ServiceLocator::SetDatabase(null);
		ServiceLocator::SetServer(null);
	}
	
	public function testRegistersUser()
	{
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->additionalFields);
		
		$command = new RegisterUserCommand(
					$this->login, $this->email, $this->fname, $this->lname, 
					$this->fakeEncryption->_Encrypt, $this->fakeEncryption->_Salt, $this->timezone, 
					$this->additionalFields['phone'], $this->additionalFields['institution'], $this->additionalFields['position']
					);
		
		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertTrue($this->fakeEncryption->_EncryptCalled);
		$this->assertTrue($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertTrue($this->fakeEncryption->_Salt, $this->fakeEncryption->_LastSalt);
	}
	
//	public function testChecksIfUserAlreadyRegistered()
//	{
//		$loginName = 'loginname';
//		$emailAddress = 'email@address';
//	    
//		$rows = array(array());
//		$this->db->SetRows($rows);
//		
//		$exists = $this->registration->UserExists($loginName, $emailAddress);
//		
//		$this->assertEquals(new CheckUserExistanceCommand($loginName, $emailAddress), $this->db->_LastCommand);
//		$this->assertFalse($exists);
//		
//		$rows = array(array(ColumnNames::USER_ID => 100));
//		$this->db->SetRows($rows);
//		
//		$exists = $this->registration->UserExists($loginName, $emailAddress);
//		$this->assertTrue($exists);
//	}
}
?>