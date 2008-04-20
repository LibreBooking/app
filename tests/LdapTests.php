<?php
require_once(ROOT_DIR . 'plugins/Auth/Ldap/namespace.php');

class LdapTests extends TestBase 
{
	private $ldap;
	
	public function setup()
	{
		parent::setup();
	}
	
	public function testCanValidateUser()
	{
		$fakeAuth = new FakeAuth();
		$fakeLdapOptions = new FakeLdapOptions();
		$fakeLdap = new FakeLdapWrapper();
		
		$fakeLdapOptions->_RetryAgainstDatabase = false;
		$expectedResult = true;
		$fakeLdap->_ExpectedAuthenticate = $expectedResult;
		
		$auth = new Ldap($fakeAuth, $fakeLdap, $fakeLdapOptions);
		$isValid = $auth->Validate($username, $password);
		
		$this->assertEquals($expectedResult, $isValid);
		$this->assertTrue($fakeLdap->_ConnectCalled);
		$this->assertTrue($fakeLdap->_AuthenticateCalled);
		$this->assertEquals($username, $fakeLdap->_LastUsername);
		$this->assertEquals($password, $fakeLdap->_LastPassword);
	}
	
	public function testNotValidIfValidateFailsAndNotFailingOverToDb()
	{
		$this->markTestIncomplete();
	}
	
	public function testFailoverToDbIfConfigured()
	{
		$this->markTestIncomplete();
	}
	
	public function testLoginSynchronizesInfoAndCallsAuthLogin()
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
		$configFile->SetKey(LdapConfig::USE_SSL, $starttls);
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
