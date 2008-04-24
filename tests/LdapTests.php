<?php
require_once(ROOT_DIR . 'plugins/Auth/Ldap/namespace.php');

class LdapTests extends TestBase 
{
	private $fakeAuth;
	private $fakeLdapOptions;
	private $fakeLdap;
	private $ldapUser;
	
	public function setup()
	{
		parent::setup();
		
		$this->fakeAuth = new FakeAuth();
		$this->fakeLdapOptions = new FakeLdapOptions();
		$this->fakeLdap = new FakeLdapWrapper();
		
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
		$username = 'username';
		$password = 'password';
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($username, $password);
		
		$this->assertEquals($expectedResult, $isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertTrue($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($username, $this->fakeLdap->_LastUsername);
		$this->assertEquals($password, $this->fakeLdap->_LastPassword);
	}
	
	public function testNotValidIfCannotFindUser()
	{
		$username = 'username';
		$password = 'password';
		
		$this->fakeLdap->_ExpectedLdapUser = null;
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($username, $password);
		
		$this->assertFalse($isValid);
		$this->assertTrue($this->fakeLdap->_ConnectCalled);
		$this->assertFalse($this->fakeLdap->_AuthenticateCalled);
	}
	
	public function testNotValidIfValidateFailsAndNotFailingOverToDb()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = false;
		$this->fakeLdap->_ExpectedAuthenticate = $expectedResult;
		
		$username = 'username';
		$password = 'password';
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($username, $password);
		
		$this->assertEquals($expectedResult, $isValid);
	}
	
	public function testFailoverToDbIfConfigured()
	{
		$this->fakeLdapOptions->_RetryAgainstDatabase = true;
		$this->fakeLdap->_ExpectedLdapUser = null;
		
		$authResult = true;
		$this->fakeAuth->_ValidateResult = $authResult;
		
		$username = 'username';
		$password = 'password';
		
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$isValid = $auth->Validate($username, $password);
		
		$this->assertEquals($authResult, $isValid);
		$this->assertFalse($this->fakeLdap->_AuthenticateCalled);
		$this->assertEquals($username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($password, $this->fakeAuth->_LastPassword);
	}
	
	public function testLoginSynchronizesInfoAndCallsAuthLogin()
	{
		$this->markTestIncomplete();
		
		$persist = true;
		$auth = new Ldap($this->fakeAuth, $this->fakeLdap, $this->fakeLdapOptions);
		$auth->Validate($username, $password);
		
		$auth->Login($username, $persist);
		
		$this->assertEquals(new AuthorizationCommand($username), $this->db->_Commands[0]);
	}
	
	public function testDoesNotSyncIfUserWasNotFoundInLdap()
	{
		$this->markTestIncomplete();
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
		
		$expectedLdapConfigFile = dirname(ROOT_DIR . 'plugins/Auth/Ldap/PearLdap.php') . '/Ldap.config.php';
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