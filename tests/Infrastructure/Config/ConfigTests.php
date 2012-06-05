<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
		$this->assertEquals('ActiveDirectory', Configuration::Instance()->GetSectionKey('plugins', ConfigKeys::PLUGIN_AUTHENTICATION));
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