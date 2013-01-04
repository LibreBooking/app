<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PluginManagerTests extends TestBase
{
	public function setup()
	{
		parent::setup();

		PluginManager::SetInstance(null);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testCanLoadAuthPluginThatExists()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_AUTHENTICATION, 'ActiveDirectory');

		$auth = PluginManager::Instance()->LoadAuthentication();

		$this->assertEquals('ActiveDirectory', get_class($auth));
	}

	public function testLoadsDefaultIfNoPluginConfigured()
	{
		$auth = PluginManager::Instance()->LoadAuthentication();

		$this->assertEquals('Authentication', get_class($auth));
	}

	public function testLoadsDefaultPluginNotFound()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_AUTHENTICATION, 'foo');
		$auth = PluginManager::Instance()->LoadAuthentication();

		$this->assertEquals('Authentication', get_class($auth));
	}

	public function testPreReservationPlugin()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_PRERESERVATION, 'foo');

		$plugin = PluginManager::Instance()->LoadPreReservation();

		$this->assertEquals('PreReservationFactory', get_class($plugin));
	}

	public function testPostReservationPlugin()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_POSTRESERVATION, 'foo');

		$plugin = PluginManager::Instance()->LoadPostReservation();

		$this->assertEquals('PostReservationFactory', get_class($plugin));
	}

	public function testPostRegistrationPlugin()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_POSTREGISTRATION, 'foo');

		$plugin = PluginManager::Instance()->LoadPostRegistration();

		$this->assertEquals('PostRegistration', get_class($plugin));
	}
}

?>