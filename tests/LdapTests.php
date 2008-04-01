<?php
require_once($root . 'lib/Common/namespace.php');
require_once($root . 'lib/Server/namespace.php');
require_once($root . 'lib/Config/namespace.php');
require_once($root . 'plugins/Auth/Ldap/Ldap.php');
require_once($root . 'lib/pear/Config.php');

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
		
		$auth = new Ldap($fakeAuth);
	}
	
	public function testCreateConfiguration()
	{
		
		$config = new Config();
		
		$conf = new Config_Container('section', 'settings');
		
		$conf_DB = $conf->createSection('database');
		$dbtype = $conf_DB->createDirective(ConfigKeys::DATABASE_TYPE, 'mysql');
		$conf_DB->createComment('Type of database', 'before', $dbtype);
		
		$conf->createComment('phpScheduleIt database user');
		$conf_DB->createDirective(ConfigKeys::DATABASE_USER, 'root');
		$conf_DB->createDirective(ConfigKeys::DATABASE_PASSWORD , 'password');
		$conf_DB->createDirective(ConfigKeys::DATABASE_HOSTSPEC , 'localhost');
		$conf_DB->createDirective(ConfigKeys::DATABASE_NAME , 'phpscheduleit');
		
		$config->setRoot($conf);

		// write configuration to file
		$config->writeConfig("test_config.php", "PHPArray");
		
		
		/***********************/
		
		$readConfig = new Config();
		$readContainer = $readConfig->parseConfig(dirname(__FILE__) . "/test_config.php", "PHPArray");
		
		$settings = $readContainer->getItem("section", 'settings');
		$dbsection = $settings->getItem("section", 'database');
		
		//echo 'dbsection:   ';
		//var_dump($dbsection);
		
		$configValues = $settings->toArray();

		//var_dump($configValues);
		
		$type = $dbsection->getItem("directive", ConfigKeys::DATABASE_TYPE);
		$type->setContent('new value');
		
		$readConfig->writeConfig("test_config.php", "PHPArray");
		
		//$this->assertEquals('mysql', $configValues['database'][ConfigKeys::DATABASE_TYPE]);
		
	}
	
	
	public function testZendLdapConstructionsOptionsCorrectly()
	{
		$this->markTestIncomplete('This test has not been implemented yet.');
        
		$zendLdap = new ZendLdap();	
		$options = $zendLdap->ConstructOptions();	// do this through relfection to keep the method private

		$server1_host = 'server1host';
		$server1_port = 'server1port';
		$server1_useSsl = 'server1useSsl';
		$server1_username = 'server1username';
		$server1_password = 'server1password';
		$server1_bindRequiresDn = 'server1bindRequiresDn';
		$server1_baseDn = 'server1baseDn';
		$server1_accountCanonicalForm = 'server1accountCanonicalForm';
		$server1_accountDomainName = 'server1accountDomainName';
		$server1_accountDomainNameShort = 'server1accountDomainNameShort';
		$server1_accountFilterFormat = 'server1accountFilterFormat';
		
		Configuration::SetKey(LdapConfig::HOST, $server1_host);
		Configuration::SetKey(LdapConfig::PORT, $server1_port);
		Configuration::SetKey(LdapConfig::USESSL, $server1_useSsl);
		Configuration::SetKey(LdapConfig::USERNAME, $server1_username);
		Configuration::SetKey(LdapConfig::PASSWORD, $server1_password);
		Configuration::SetKey(LdapConfig::BIND_REQUIRES_DN, $server1_bindRequiresDn);
		Configuration::SetKey(LdapConfig::BASE_DN, $server1_baseDn);
		Configuration::SetKey(LdapConfig::ACCOUNT_CANONICAL_FORM, $server1_accountCanonicalForm);
		Configuration::SetKey(LdapConfig::ACCOUNT_DOMAIN_NAME, $server1_accountDomainName);
		Configuration::SetKey(LdapConfig::ACCOUNT_DOMAIN_NAME_SHORT, $server1_accountDomainNameShort);
		Configuration::SetKey(LdapConfig::ACCOUNT_FILTER_FORMAT, $server1_accountFilterFormat);
		
		$this->assertEquals($server1_host, $options['server1']['host']);
		$this->assertEquals($server1_port, $options['server1']['port']);
		$this->assertEquals($server1_useSsl, $options['server1']['useSsl']);
		$this->assertEquals($server1_username, $options['server1']['username']);
		$this->assertEquals($server1_password, $options['server1']['bindRequiresDn']);
		$this->assertEquals($server1_bindRequiresDn, $options['server1']['baseDn']);
		$this->assertEquals($server1_baseDn, $options['server1']['accountCanonicalForm']);
		$this->assertEquals($server1_accountCanonicalForm, $options['server1']['accountDomainName']);
		$this->assertEquals($server1_accountDomainName, $options['server1']['accountDomainName']);
		$this->assertEquals($server1_accountDomainNameShort, $options['server1']['accountDomainNameShort']);
		$this->assertEquals($server1_accountFilterFormat, $options['server1']['accountFilterFormat']);
		
//host
//port
//useSsl
//username
//password
//bindRequiresDn
//baseDn
//accountCanonicalForm
//accountDomainName
//accountDomainNameShort
//accountFilterFormat
	}
	
	function testConfigurationIsAccessable()
	{
		//Configuration::Section['Ldap'] = LdapConfiguraiton;
	}
}

class ZendLdap
{
	public function ConstructOptions()
	{
		return array();
	}
	
}