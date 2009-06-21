<?php
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Pages/SchedulePage.php');

class SchedulePresenterTests extends TestBase
{
	/**
	 * @var SchedulePresenter
	 */
	private $presenter;
	private $page;
	private $reservationService;

	public function setup()
	{
		parent::setup();

		Date::_SetNow(mktime());

		$this->page = new FakeSchedulePage();

		$this->presenter = new SchedulePresenter($this->page);
		
		$this->reservationService = $this->getMock('IReservationService');
		$this->presenter->SetReservationService($this->reservationService);
	}

	public function teardown()
	{
		parent::teardown();

		Date::_SetNow(null);
	}
	
	public function testPageLoadBindsAllSchedulesAndProperResourcesWhenNotPostingBack2()
	{
		$user = $this->fakeServer->GetUserSession();
		$scheduleId = 1;
		$numDaysVisible = 10;
		$currentSchedule = new Schedule($scheduleId, 'default', 1, '08:30', '19:00', 1, 1, $numDaysVisible);
		$schedules = array($currentSchedule);
		$resources = array();
		$reservations = array();
		$bindingDates = new DateRange(Date::Now(), Date::Now());
		
		$page = $this->getMock('ISchedulePage');
		$scheduleRepository = $this->getMock('IScheduleRepository');
		$resourceRepository = $this->getMock('IResourceRepository');
		$reservationService = $this->getMock('IReservationService');
		$pageBuilder = $this->getMock('ISchedulePageBuilder');
				
		$presenter = new SchedulePresenter($page);
		$presenter->SetScheduleRepository($scheduleRepository);
		$presenter->SetResourceRepository($resourceRepository);
		$presenter->SetReservationService($reservationService);
		$presenter->SetPageBuilder($pageBuilder);
			
		$scheduleRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($schedules));
		
		$pageBuilder->expects($this->once())
			->method('GetCurrentSchedule')
			->with($this->equalTo($page), $this->equalTo($schedules))
			->will($this->returnValue($currentSchedule));
		
		$pageBuilder->expects($this->once())
			->method('BindSchedules')
			->with($this->equalTo($page), $this->equalTo($schedules), $scheduleId);
		
		$resourceRepository->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($scheduleId))
			->will($this->returnValue($resources));
		
		$pageBuilder->expects($this->once())
			->method('GetScheduleDates')
			->with($this->equalTo($user), $this->equalTo($numDaysVisible))
			->will($this->returnValue($bindingDates));
			
		$pageBuilder->expects($this->once())
			->method('BindDisplayDates')
			->with($this->equalTo($page, $bindingDates));
		
		$reservationService->expects($this->once())
			->method('GetReservations')
			->with($this->equalTo($bindingDates), $this->equalTo($scheduleId), $this->equalTo($user->Timezone))
			->will($this->returnValue($reservations));
		
		$pageBuilder->expects($this->once())
			->method('BindReservations')
			->with($this->equalTo($page), $this->equalTo($resources), $this->equalTo($reservations), $this->equalTo($bindingDates));

		$presenter->PageLoad2();
		
	}
	
	public function testScheduleBuilderBindsAllSchedulesAndSetsActive()
	{
		throw new Exception('#1');
		
		$page->expects($this->once())
			->method('SetSchedules')
			->with($this->equalTo($schedules));
			
		$page->expects($this->once())
			->method('SetScheduleId')
			->with($this->equalTo($activeId));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindSchedules($page, $schedules, $activeId);
	}
	
	public function testScheduleBuilderGetCurrentScheduleReturnsSelectedScheduleOnPostBack()
	{
		$this->markTestIncomplete("need to implement");
		
		$page = $this->getMock('ISchedulePage');
		
		$page->expects($this->once())
			->method('IsPostBack')
			->will($this->returnValue(true));
			
		$page->expects($this->once())
			->method('GetScheduleId')
			->will($this->returnValue($scheduleId));
		
		$pageBuilder = new SchedulePageBuilder();
		$actual = $pageBuilder->GetCurrentSchedule($page, $schedules);

	}
	
	public function testScheduleBuilderGetCurrentScheduleReturnsDefaultSchedule()
	{
		$this->markTestIncomplete("need to implement");
		
		$page = $this->getMock('ISchedulePage');
		
		$page->expects($this->once())
			->method('IsPostBack')
			->will($this->returnValue(false));
		
		$pageBuilder = new SchedulePageBuilder();
		$actual = $pageBuilder->GetCurrentSchedule($page, $schedules);

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
	public $_LastDates = array();

	public $_SetSchedulesCalled = false;
	public $_SetResourcesCalled = false;
	public $_SetReservationsCalled = false;
	public $_SetDatesCalled = false;
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

	public function SetDisplayDates($dates)
	{
		$this->_SetDatesCalled = true;
		$this->_LastDates = $dates;
	}
}

?>