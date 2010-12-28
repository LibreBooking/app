<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class ConfigTests extends TestBase 
{	
	function setup()
	{
		parent::setup();
		
		Configuration::SetInstance(null);
	}
	
	function testConfigLoadsAllValues() 
	{
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_config.php', Configuration::DEFAULT_CONFIG_ID, true);
		
		$this->assertEquals('US/Central', Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE));
		$this->assertEquals(true, Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter()));
		
		$this->assertEquals('mysql', Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_TYPE ));
		$this->assertEquals('Ldap', Configuration::Instance()->GetSectionKey('plugins', ConfigKeys::PLUGIN_AUTH));
	}
	
	function testRegistersMultipleConfigFiles()
	{
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_config.php', Configuration::DEFAULT_CONFIG_ID, true);
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_plugin_config.php', 'LDAP');
		
		$this->assertEquals('US/Central', Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE));
		$this->assertEquals('value1', Configuration::Instance()->File('LDAP')->GetKey('key'));
		$this->assertEquals('value2', Configuration::Instance()->File('LDAP')->GetSectionKey('server1', 'key'));
		$this->assertEquals('value3', Configuration::Instance()->File('LDAP')->GetSectionKey('server2', 'key'));
	}

}
?>