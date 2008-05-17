<?php
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Pages/SchedulePage.php');

class SchedulePresenterTests extends TestBase
{
	private $presenter;
	private $page;
	
	public function setup()
	{
		parent::setup();
		
		Date::_SetNow(mktime());
		
		$this->page = new FakeSchedulePage();
		
		$this->presenter = new SchedulePresenter($this->page);
	}
	
	public function teardown()
	{
		parent::teardown();
		
		Date::_SetNow(null);
	}
	
	public function testSetsDefaultScheduleId()
	{
		$schedules = new FakeSchedules();
		$this->presenter->SetSchedules($schedules);
		
		$this->presenter->PageLoad();
		
		$this->assertTrue($schedules->_GetAllCalled);
		$this->assertEquals($schedules->_AllRows, $this->page->_LastSchedules);
		$this->assertTrue($this->page->_SetSchedulesCalled);
	}
}

class FakeSchedulePage implements ISchedulePage  
{
	public $_LastSchedules = array();
	public $_SetSchedulesCalled = false;
	
	public function SetSchedules($schedules)
	{
		$this->_LastSchedules = $schedules;
		$this->_SetSchedulesCalled = true;
	}
}

?>