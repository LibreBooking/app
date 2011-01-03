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
	
	/**
	 * @var FakeResources
	 */
	public $fakeResources;
	
	/**
	 * @var FakeEmailService
	 */
	public $fakeEmailService;
	
	public function setup()
	{
		Date::_SetNow(Date::Now());
		
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();
		$this->fakeEmailService = new FakeEmailService();
		$this->fakeConfig = new FakeConfig();
        $this->fakeConfig->SetKey(ConfigKeys::SERVER_TIMEZONE, 'US/Central');
                
		$this->fakeResources = new FakeResources();
		
		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		ServiceLocator::SetEmailService($this->fakeEmailService);
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