<?php

require_once(ROOT_DIR . 'lib/Config/namespace.php');

class ConfigTests extends TestBase
{
	function setup(): void
	{
		parent::setup();

		Configuration::SetInstance(null);
	}

	function testConfigLoadsAllValues()
	{
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_config.php', Configuration::DEFAULT_CONFIG_ID, true);

		$this->assertEquals('US/Central', Configuration::Instance()->GetDefaultTimezone());
		$this->assertEquals(true, Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter()));

		$this->assertEquals('mysql', Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_TYPE ));
		$this->assertEquals('ActiveDirectory', Configuration::Instance()->GetSectionKey('plugins', ConfigKeys::PLUGIN_AUTHENTICATION));
	}

	function testRegistersMultipleConfigFiles()
	{
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_config.php', Configuration::DEFAULT_CONFIG_ID, true);
		Configuration::Instance()->Register(ROOT_DIR . 'tests/data/test_plugin_config.php', 'LDAP');

		$this->assertEquals('US/Central', Configuration::Instance()->GetDefaultTimezone());
		$this->assertEquals('value1', Configuration::Instance()->File('LDAP')->GetKey('key'));
		$this->assertEquals('value2', Configuration::Instance()->File('LDAP')->GetSectionKey('server1', 'key'));
		$this->assertEquals('value3', Configuration::Instance()->File('LDAP')->GetSectionKey('server2', 'key'));
	}

}
