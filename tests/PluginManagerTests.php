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
		$this->fakeConfig->SetKey(ConfigKeys::PLUGIN_AUTH, 'Ldap');
		
		$auth = PluginManager::Instance()->LoadAuth();
		
		$this->assertEquals('Ldap', get_class($auth));
	}
	
	public function testLoadsDefaultIfNoPluginConfigured()
	{
		$auth = PluginManager::Instance()->LoadAuth();
		
		$this->assertEquals('Authorization', get_class($auth));
	}
	
	public function testLoadsDefaultPluginNotFound()
	{
		$this->fakeConfig->SetKey(ConfigKeys::PLUGIN_AUTH, 'foo');
		$auth = PluginManager::Instance()->LoadAuth();
		
		$this->assertEquals('Authorization', get_class($auth));
	}
}
?>