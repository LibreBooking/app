<?php

class TestBase extends PHPUnit_Framework_TestCase
{
	public $db;
	public $fakeServer;
	public $fakeConfig;
	
	public function setup()
	{
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();
		$this->fakeConfig = new FakeConfig();

		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		Configuration::SetInstance($this->fakeConfig);
	}
	
	public function teardown()
	{
		$this->db = null;
		$this->fakeServer = null;
		Configuration::SetInstance(null);
	}
}
?>