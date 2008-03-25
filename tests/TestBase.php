<?php

class TestBase extends PHPUnit_Framework_TestCase
{
	public $db;
	public $fakeServer;
	
	public function setup()
	{
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();

		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
	}
	
	function teardown()
	{
		$this->db = null;
		$this->fakeServer = null;
		Configuration::Reset();
	}
}
?>