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
	
	public function testPageLoadBindsAllSchedulesAndProperResourcesWhenNotPostingBack()
	{
		$schedules = new FakeSchedules();
		$this->presenter->SetSchedules($schedules);
		
		$resources = new FakeResourceAccess();
		$this->presenter->SetResourceAccess($resources);
		
		$reservations = new FakeReservations();
		$this->presenter->SetReservationAccess($reservations);
		
		$this->page->_IsPostBack = false;
		
		$startDate = Date::Now();
		$endDate = Date::Now()->AddDays($schedules->_DefaultDaysVisible);
		
		
		$this->presenter->PageLoad();
		
		
		$this->assertTrue($schedules->_GetAllCalled);
		$this->assertEquals($schedules->_AllRows, $this->page->_LastSchedules);
		$this->assertTrue($this->page->_SetSchedulesCalled);
		
		$this->assertTrue($resources->_GetForScheduleCalled);
		$this->assertEquals($schedules->_DefaultScheduleId, $resources->_LastScheduleId);		
		$this->assertEquals($resources->_Resources, $this->page->_LastResources);
		$this->assertTrue($this->page->_SetResourcesCalled);
		
		$this->assertTrue($reservations->_GetWithinCalled);
		$this->assertEquals($startDate, $reservations->_LastStartDate);
		$this->assertEquals($endDate, $reservations->_LastEndDate);
		$this->assertEquals($schedules->_DefaultScheduleId, $reservations->_LastScheduleId);
		$this->assertEquals($reservations->_Reservations, $this->page->_LastReservations);
		$this->assertTrue($this->page->_SetReservationsCalled);
		
	}
	
	public function testPageLoadsDataWhenPostingBack()
	{
		$this->markTestIncomplete("need to handle all the issues with changing schedules/days");
	}
	
	public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsAheadOrBehindByAWeek()
	{
		$this->markTestIncomplete("to do");
	}
}

class FakeSchedulePage extends FakePageBase implements ISchedulePage  
{
	public $_LastSchedules = array();
	public $_LastResources = array();
	public $_LastReservations = array();
	
	public $_SetSchedulesCalled = false;
	public $_SetResourcesCalled = false;
	public $_SetReservationsCalled = false;
	public $_ScheduleId;
	
	public function SetSchedules($schedules)
	{
		$this->_LastSchedules = $schedules;
		$this->_SetSchedulesCalled = true;
	}
	
	public function SetResources($resources)
	{
		$this->_LastResources = $resources;
		$this->_SetResourcesCalled = true;
	}
	
	public function SetReservations($reservations)
	{
		$this->_LastReservations = $reservations;
		$this->_SetReservationsCalled = true;
	}
	
	public function GetScheduleId()
	{
		return $this->_ScheduleId;
	}
}

?>