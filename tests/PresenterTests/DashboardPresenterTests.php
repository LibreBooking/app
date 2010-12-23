<?php
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');
require_once(ROOT_DIR . 'Pages/DashboardPage.php');

class DashboardPresenterTests extends TestBase
{
	private $presenter;
	private $page;
	
	public function setup()
	{
		parent::setup();
		
		Date::_SetNow(mktime());
		
		$this->page = new FakeDashboardPage();
		
		$this->presenter = new DashboardPresenter($this->page);
	}
	
	public function teardown()
	{
		parent::teardown();
		
		Date::_SetNow(null);
	}
}

class FakeDashboardPage implements IDashboardPage 
{
}

?>