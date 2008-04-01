<?php

class ConfigTests extends TestBase 
{	
	function testConfigLoadsAllValues() 
	{
		Configuration::Register(dirname(__FILE__) . '/data/test_config.php', Configuration::DEFAULT_CONFIG_ID);
		
		$this->assertEquals('US/Central', Configuration::GetKey(ConfigKeys::SERVER_TIMEZONE));
		$this->assertEquals(true, Configuration::GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter()));
		
		$this->assertEquals('mysql', Configuration::GetSectionKey('database', ConfigKeys::DATABASE_TYPE ));
		$this->assertEquals('Ldap', Configuration::GetSectionKey('plugins', ConfigKeys::PLUGIN_AUTH));
		
		//$this->assertEquals('mysql', Configuration::Section('database')->GetKey(ConfigKeys::DATABASE_TYPE ));
	}

}
?>