<?php
require_once(ROOT_DIR . 'plugins/Authentication/Ldap/namespace.php');

class LdapTests extends TestBase 
{
	private $fakeAuth;
	private $fakeLdapOptions;
	private $fakeLdap;
	private $ldapUser;
	private $fakeRegistration;
	private $encryption;
	
	private $username = 'username';
	private $password = 'password';
	
	public function setup()
	{
		parent::setup();
		
		$this->fakeAuth = new FakeAuth();
		$this->fakeLdapOptions = new FakeLdapOptions();
		$this->fakeLdap = new FakeLdapWrapper();
		$this->fakeRegistration = new FakeRegistration();
		$this->encryption = new FakePasswordEncryption();
		
		$ldapEntry = array(
			"sn" => array('user'), 
			"givenname" => array('test'), 
			"mail" => array('ldap@user.com'), 
			"telephonenumber" => array('000-000-0000'), 
			"physicaldeliveryofficename" => array(''), 
			"title" => array('') );
		
		$this->ldapUser = new LdapUser($ldapEntry);
		
		$this->fakeLdap->_ExpectedLdapUser = $this->ldapUser;
	}
	
	public function testCanValidateUser()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = true;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);
		
		$this->assertEquals($expectedResult, $isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($this->username, $this->fakeLdap->_LastUsername);
		$this->assertEquals($this->password, $this->fakeLdap->_LastPassword);
	}
	
	public function testNotValidIfCannotFindUser()
	{
		$this->fakeLdap->_ExpectedLdapUser = null;
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);
		
		$this->assertFalse($isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertFalse($this->fakeLdap->_AuthenticateCalled);
	}
	
	public function testNotValidIfValidateFailsAndNotFailingOverToDb()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = false;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);
		
		$this->assertEquals($expectedResult, $isValid);
	}
	
	public function testFailoverToDbIfConfigured()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = true;
		$this->fakeLdap->_ExpectedLdapUser = null;
		
		$authResult = true;
		$this->fakeAuth->_ValidateResult = $authResult;
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($this->username, $this->password);
		
		$this->assertEquals($authResult, $isValid);
		$this->assertFalse($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($this->password, $this->fakeAuth->_LastPassword);
	}
	
	public function testLoginSynchronizesInfoAndCallsAuthLogin()
	{	
		$persist = true;
		$this->fakeRegistration->_UserExists = true;
		$encryptedPassword = $this->encryption->_Encrypted;
		$salt = $this->encryption->_Salt;
	
		$email = $this->ldapUser->GetEmail();
		$fname = $this->ldapUser->GetFirstName();
		$lname = $this->ldapUser->GetLastName();
		$phone = $this->ldapUser->GetPhone();
		$inst = $this->ldapUser->GetInstitution();
		$title = $this->ldapUser->GetTitle();
		
		$expectedCommand = new UpdateUserFromLdapCommand(
											$this->username,
											$email,
											$fname,
											$lname,
											$encryptedPassword, 
											$salt,
											$phone,
											$inst,
											$title);
											
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);		
		$auth->SetRegistration($this->fakeRegistration);
		$auth->SetEncryption($this->encryption);
		
		$auth->Validate($this->username, $this->password);
		$auth->Login($this->username, $persist);
			
		
		$this->assertTrue($this->fakeRegistration->_ExistsCalled);	
		$this->assertEquals($this->username, $this->fakeRegistration->_LastLogin);
		$this->assertEquals($this->ldapUser->GetEmail(), $this->fakeRegistration->_LastEmail);
		
		$this->assertEquals($expectedCommand, $this->db->_Commands[0]);
		
		$this->assertTrue($this->encryption->_EncryptCalled);
		$this->assertEquals($this->password, $this->encryption->_LastPassword);
		$this->assertEquals($this->encryption->_Salt, $this->encryption->_LastSalt);
			
		$this->assertFalse($this->fakeRegistration->_RegisterCalled);
		
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($persist, $this->fakeAuth->_LastPersist);
	}
	
	public function testLoginRegistersUserIfDoesNotExistAndCallsAuthLogin()
	{
		$persist = false;
		$this->fakeRegistration->_UserExists = false;
		$encryptedPassword = $this->encryption->_Encrypted;
		$salt = $this->encryption->_Salt;
	
		$email = $this->ldapUser->GetEmail();
		$fname = $this->ldapUser->GetFirstName();
		$lname = $this->ldapUser->GetLastName();
		$phone = $this->ldapUser->GetPhone();
		$inst = $this->ldapUser->GetInstitution();
		$title = $this->ldapUser->GetTitle();
		$additionalFields = array('phone' => $phone, 'institution' => $inst, 'position' => $title);
		$timezone = 'US/Central';
		$this->fakeConfig->SetKey(ConfigKeys::SERVER_TIMEZONE, $timezone);
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->SetRegistration($this->fakeRegistration);
		$auth->SetEncryption($this->encryption);
		$auth->Validate($this->username, $this->password);
		
		$auth->Login($this->username, $persist);
		
		$this->assertTrue($this->fakeRegistration->_ExistsCalled);	
		$this->assertEquals($this->username, $this->fakeRegistration->_LastLogin);
		$this->assertEquals($this->ldapUser->GetEmail(), $this->fakeRegistration->_LastEmail);
		
		$this->assertTrue($this->encryption->_EncryptCalled);
		$this->assertEquals($this->password, $this->encryption->_LastPassword);
		$this->assertEquals($this->encryption->_Salt, $this->encryption->_LastSalt);
			
		$this->assertTrue($this->fakeRegistration->_RegisterCalled);
		$this->assertEquals($this->username, $this->fakeRegistration->_Login);
		$this->assertEquals($email, $this->fakeRegistration->_Email);
		$this->assertEquals($fname, $this->fakeRegistration->_First);
		$this->assertEquals($lname, $this->fakeRegistration->_Last);
		$this->assertEquals($this->password, $this->fakeRegistration->_Password);
		$this->assertEquals($timezone, $this->fakeRegistration->_Timezone);
		$this->assertEquals(Pages::DEFAULT_HOMEPAGE_ID, $this->fakeRegistration->_HomepageId);
		$this->assertEquals($additionalFields, $this->fakeRegistration->_AdditionalFields);
		
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($persist, $this->fakeAuth->_LastPersist);
	}
	
	public function testDoesNotSyncIfUserWasNotFoundInLdap()
	{
		$persist = false;
		$this->fakeLdap->_ExpectedLdapUser = null;
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->Validate($this->username, $this->password);
		
		$auth->Login($this->username, $persist);
		
		$this->assertFalse($this->fakeRegistration->_ExistsCalled);
		$this->assertEquals(0, count($this->db->_Commands));
		$this->assertFalse($this->encryption->_EncryptCalled);
		$this->assertFalse($this->fakeRegistration->_RegisterCalled);
		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($persist, $this->fakeAuth->_LastPersist);
	}
	
	public function testAdLdapConstructsOptionsCorrectly()
	{
		$host = 'localhost, localhost.2';
		$port = '389';
		$username = 'uname';
		$password = 'pw';
		$base = '';
		$usessl = 'false';
		$version = '3';
		$accountSuffix = '';
		
		$configFile = new FakeConfigFile();
		$configFile->SetKey(LdapConfig::HOST, $host);
		$configFile->SetKey(LdapConfig::PORT, $port);
		$configFile->SetKey(LdapConfig::USERNAME, $username);
		$configFile->SetKey(LdapConfig::PASSWORD, $password);
		$configFile->SetKey(LdapConfig::BASEDN, $base);
		$configFile->SetKey(LdapConfig::USE_SSL, $usessl);
		$configFile->SetKey(LdapConfig::VERSION, $version);
		$configFile->SetKey(LdapConfig::ACCOUNT_SUFFIX, $accountSuffix);
		
		$this->fakeConfig->SetFile(LdapConfig::CONFIG_ID, $configFile);
		
		$ldapOptions = new LdapOptions();	
		$options = $ldapOptions->AdLdapOptions();
		
		$expectedLdapConfigFile = dirname(ROOT_DIR . 'plugins/Authentication/Ldap/PearLdap.php') . '/Ldap.config.php';
		$this->assertNotNull($this->fakeConfig->_RegisteredFiles[LdapConfig::CONFIG_ID]);
		$this->assertEquals('localhost', $options['host'], 'get the first host in the list');
		$this->assertEquals(intval($port), $options['port'], 'port should be int');
		$this->assertEquals($username, $options['ad_username']);
		$this->assertEquals($password, $options['ad_password']);
		$this->assertEquals($base, $options['base_dn']);
		$this->assertEquals(false, $options['use_ssl']);
		$this->assertEquals($accountSuffix, $options['account_suffix']);
		$this->assertEquals(intval($version), $options['ldap_version'], "version should be int");
	}

	public function testGetAllHosts()
	{
		$host = 'localhost, localhost.2';
		
		$configFile = new FakeConfigFile();
		$configFile->SetKey(LdapConfig::HOST, $host);
		$this->fakeConfig->SetFile(LdapConfig::CONFIG_ID, $configFile);
		
		$options = new LdapOptions();
		
		$this->assertEquals(array('localhost', 'localhost.2'), $options->Hosts(), "comma seperated values should become array");		
	}
}
?>