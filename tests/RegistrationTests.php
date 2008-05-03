<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');

class RegistrationTests extends TestBase
{
	private $registration;
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
		parent::setup();

		$this->fakeEncryption = new FakePasswordEncryption();		
		$this->registration = new Registration($this->fakeEncryption);
		
		$this->fakeConfig->SetKey(ConfigKeys::USE_LOGON_NAME, 'true');
	}
	
	public function tearDown()
	{
		parent::teardown();
		$this->registration = null;
	}
	
	public function testRegistersUser()
	{
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->additionalFields);
		
		$command = new RegisterUserCommand(
					$this->login, $this->email, $this->fname, $this->lname, 
					$this->fakeEncryption->_Encrypted, $this->fakeEncryption->_Salt, $this->timezone, 
					$this->additionalFields['phone'], $this->additionalFields['institution'], $this->additionalFields['position']
					);
		
		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertTrue($this->fakeEncryption->_EncryptCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertEquals($this->fakeEncryption->_Salt, $this->fakeEncryption->_LastSalt);
	}
	
	public function testInsertsEmailAddressIntoLoginNameIfNotConfiguredToUseLoginName()
	{
		$this->fakeConfig->SetKey(ConfigKeys::USE_LOGON_NAME, 'false');
		
		$expectedLogin = $this->email;
		$this->login = '';
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->additionalFields);
		
		$command = new RegisterUserCommand(
					$expectedLogin, $this->email, $this->fname, $this->lname, 
					$this->fakeEncryption->_Encrypted, $this->fakeEncryption->_Salt, $this->timezone, 
					$this->additionalFields['phone'], $this->additionalFields['institution'], $this->additionalFields['position']
					);
		
		$this->assertEquals($command, $this->db->_LastCommand);
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