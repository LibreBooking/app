<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PluginManagerTests extends TestBase
{	
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testCanLoadAuthPluginThatExists()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PLUGINS, ConfigKeys::PLUGIN_AUTHENTICATION, 'Ldap');
		
		$auth = PluginManager::Instance()->LoadAuthentication();
		
		$this->assertEquals('Ldap', get_class($auth));
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
}
?>