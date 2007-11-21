<?php
require_once('../Presenters/RegistrationPresenter.php');
require_once('../Pages/RegistrationPage.php');
require_once('../lib/Common/namespace.php');
require_once('fakes/FakeServer.php');

class RegisterPresenterTests extends PHPUnit_Framework_TestCase
{
	private $page;
	private $server;
	
	public function setup()
	{
		$this->page = new FakeRegistrationPage();
		$this->server = new FakeServer();
		
		ServiceLocator::SetServer($this->server);
	}
	
	public function teardown()
	{
		$this->auth = null;
		$this->page = null;
		$resources =& Resources::GetInstance();
		$resources = null;
		
		$this->server = null;
	}
	
	
	public function testToDo()
	{
		$this->markTestIncomplete("need to start doing the registration");
	}
}

class FakeRegistrationPage implements IRegistrationPage
{	
	public function PageLoad()
	{
		$this->_PageLoadWasCalled = true;
	}
}
?>