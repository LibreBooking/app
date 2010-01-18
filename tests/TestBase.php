<?php

class TestBase extends PHPUnit_Framework_TestCase
{
	/**
	 * @var FakeDatabase
	 */
	public $db;
	
	/**
	 * @var FakeServer
	 */
	public $fakeServer;
	
	/**
	 * @var FakeConfig
	 */
	public $fakeConfig;
	public $fakeResources;
	
	public function setup()
	{
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();
		$this->fakeConfig = new FakeConfig();
        $this->fakeConfig->SetKey(ConfigKeys::SERVER_TIMEZONE, 'US/Central');
                
		$this->fakeResources = new FakeResources();
		
		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		Configuration::SetInstance($this->fakeConfig);
		Resources::SetInstance($this->fakeResources);
	}
	
	public function teardown()
	{
		$this->db = null;
		$this->fakeServer = null;
		Configuration::SetInstance(null);
		$this->fakeResources = null;
		Date::_ResetNow();
	}
}
?>