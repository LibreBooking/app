<?php
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class RegistrationTests extends TestBase
{
	/**
	 * @var Registration
	 */
	private $registration;

	/**
	 * @var FakePasswordEncryption
	 */
	private $fakeEncryption;
	
	private $login = 'testlogin';
	private $email = 'test@test.com';
	private $fname = 'First';
	private $lname = 'Last';
	private $additionalFields = array('phone' => '123.123.1234', 'organization' => '', 'position' => '');
	private $password = 'password';
	private $confirm = 'password';
	private $timezone = 'US/Eastern';
	private $language = 'en_US';
	private $homepageId = 1;
	
	public function setUp()
	{
		parent::setup();

		$this->fakeEncryption = new FakePasswordEncryption();		
		$this->registration = new Registration($this->fakeEncryption);
	}
	
	public function tearDown()
	{
		parent::teardown();
		$this->registration = null;
	}
	
	public function testRegistersUser()
	{
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->language, $this->homepageId, $this->additionalFields);
		
		$command = new RegisterUserCommand(
					$this->login, $this->email, $this->fname, $this->lname, 
					$this->fakeEncryption->_Encrypted, $this->fakeEncryption->_Salt, $this->timezone, $this->language, $this->homepageId,
					$this->additionalFields['phone'], $this->additionalFields['organization'], $this->additionalFields['position']
					,AccountStatus::AWAITING_ACTIVATION);
		
		$this->assertEquals($command, $this->db->_Commands[0]);
		$this->assertTrue($this->fakeEncryption->_EncryptCalled);
		$this->assertEquals($this->password, $this->fakeEncryption->_LastPassword);
		$this->assertEquals($this->fakeEncryption->_Salt, $this->fakeEncryption->_LastSalt);
	}
	
	public function testAutoAssignsAllResourcesForThisUser()
	{
		$expectedUserId = 100;
		
		$this->db->_ExpectedInsertId = $expectedUserId;
		$this->registration->Register($this->login, $this->email, $this->fname, $this->lname, $this->password, $this->timezone, $this->language, $this->homepageId, $this->additionalFields);
		
		$command = new AutoAssignPermissionsCommand($expectedUserId);
		
		$this->assertEquals($command, $this->db->_Commands[1]);
	}
}
?>