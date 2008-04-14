<?php
//require_once(ROOT_DIR . 'lib/Common/namespace.php');
//require_once(ROOT_DIR . 'lib/Server/namespace.php');
//require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'plugins/Auth/Ldap/namespace.php');

class LdapTests extends TestBase 
{
	private $ldap;
	
	public function setup()
	{
		parent::setup();
	}
	
//	public function testCanValidateUser()
//	{
//		$fakeAuth = new FakeAuth();
//		
//		$auth = new Ldap($fakeAuth);
//	}	
	
	public function testZendLdapConstructionsOptionsCorrectly()
	{
		$host = 'localhost, localhost.2';
		$port = '389';
		$username = 'uname';
		$password = 'pw';
		$base = '';
		$starttls = 'false';
		$filter = '(objectclass=*)';
		$scope = 'sub';
		$version = '';
		
		$configFile = new FakeConfigFile();
		$configFile->SetKey(LdapConfig::HOST, $host);
		$configFile->SetKey(LdapConfig::PORT, $port);
		$configFile->SetKey(LdapConfig::USERNAME, $username);
		$configFile->SetKey(LdapConfig::PASSWORD, $password);
		$configFile->SetKey(LdapConfig::BASE, $base);
		$configFile->SetKey(LdapConfig::START_TLS, $starttls);
		$configFile->SetKey(LdapConfig::FILTER, $filter);
		$configFile->SetKey(LdapConfig::SCOPE, $scope);
		$configFile->SetKey(LdapConfig::VERSION, $version);
		
		$this->fakeConfig->SetFile(LdapConfig::CONFIG_ID, $configFile);
		
		$pearLdap = new PearLdapOptions();	
		$options = $pearLdap->ConstructOptions();
		
		$expectedLdapConfigFile = dirname(ROOT_DIR . 'plugins/Auth/Ldap/PearLdap.php') . '/Ldap.config.php';
		$this->assertNotNull($this->fakeConfig->_RegisteredFiles[LdapConfig::CONFIG_ID]);
		$this->assertEquals(array('localhost', 'localhost.2'), $options['host'], "comma seperated values should become array");
		$this->assertEquals($port, $options['port']);
		$this->assertEquals($username, $options['binddn']);
		$this->assertEquals($password, $options['bindpw']);
		$this->assertFalse(array_key_exists('base', $options), "empty values should not be added to options");
		$this->assertEquals(false, $options['starttls']);
		$this->assertEquals($filter, $options['filter']);
		$this->assertEquals($scope, $options['scope']);
		$this->assertFalse(array_key_exists('version', $options), "empty values should not be added to options");
	}
	
	function testConfigurationIsAccessable()
	{
		//Configuration::Section['Ldap'] = LdapConfiguraiton;
	}
}