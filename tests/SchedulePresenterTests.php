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
	
	private $scheduleId;
	private $currentSchedule;
	private $schedules;
	private $numDaysVisible;

	public function setup()
	{
		parent::setup();

		$this->scheduleId = 1;
		$this->numDaysVisible = 10;
		$this->currentSchedule = new Schedule($this->scheduleId, 'default', 1, '08:30', '19:00', 1, 1, $this->numDaysVisible);
		$otherSchedule = new Schedule(2, 'not default', 0, '08:30', '19:00', 1, 1, $this->numDaysVisible);
		
		$this->schedules = array($this->currentSchedule, $otherSchedule);
	}

	public function teardown()
	{
		parent::teardown();

		Date::_SetNow(null);
	}
	
	public function testPageLoadBindsAllSchedulesAndProperResourcesWhenNotPostingBack2()
	{
		$user = $this->fakeServer->GetUserSession();
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
			->will($this->returnValue($this->schedules));
		
		$pageBuilder->expects($this->once())
			->method('GetCurrentSchedule')
			->with($this->equalTo($page), $this->equalTo($this->schedules))
			->will($this->returnValue($this->currentSchedule));
		
		$pageBuilder->expects($this->once())
			->method('BindSchedules')
			->with($this->equalTo($page), $this->equalTo($this->schedules), $this->scheduleId);
		
		$resourceRepository->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($this->scheduleId))
			->will($this->returnValue($resources));
		
		$pageBuilder->expects($this->once())
			->method('GetScheduleDates')
			->with($this->equalTo($user), $this->equalTo($this->currentSchedule))
			->will($this->returnValue($bindingDates));
			
		$pageBuilder->expects($this->once())
			->method('BindDisplayDates')
			->with($this->equalTo($page, $bindingDates));
		
		$reservationService->expects($this->once())
			->method('GetReservations')
			->with($this->equalTo($bindingDates), $this->equalTo($this->scheduleId), $this->equalTo($user->Timezone))
			->will($this->returnValue($reservations));
		
		$pageBuilder->expects($this->once())
			->method('BindReservations')
			->with($this->equalTo($page), $this->equalTo($resources), $this->equalTo($reservations), $this->equalTo($bindingDates));

		$presenter->PageLoad2();
		
	}
	
	public function testScheduleBuilderBindsAllSchedulesAndSetsActive()
	{
		$activeId = 100;
		
		$page = $this->getMock('ISchedulePage');
		
		$page->expects($this->once())
			->method('SetSchedules')
			->with($this->equalTo($this->schedules));
			
		$page->expects($this->once())
			->method('SetScheduleId')
			->with($this->equalTo($activeId));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindSchedules($page, $this->schedules, $activeId);
	}
	
	public function testScheduleBuilderGetCurrentScheduleReturnsSelectedScheduleOnPostBack()
	{
		$s1 = $this->getMock('ISchedule');
		$s2 = $this->getMock('ISchedule');
		
		$s1->expects($this->once())
			->method('GetId')
			->will($this->returnValue(11));
			
		$s2->expects($this->once())
			->method('GetId')
			->will($this->returnValue(10));
		
		$schedules = array($s1, $s2);
				
		$page = $this->getMock('ISchedulePage');
		
		$page->expects($this->once())
			->method('IsPostBack')
			->will($this->returnValue(true));
			
		$page->expects($this->once())
			->method('GetScheduleId')
			->will($this->returnValue(10));
		
		$pageBuilder = new SchedulePageBuilder();
		$actual = $pageBuilder->GetCurrentSchedule($page, $schedules);
		
		$this->assertEquals($s2, $actual);
	}
	
	public function testScheduleBuilderGetCurrentScheduleReturnsDefaultScheduleWhenInitialLoad()
	{
		$s1 = $this->getMock('ISchedule');
		$s2 = $this->getMock('ISchedule');
		
		$s1->expects($this->once())
			->method('GetIsDefault')
			->will($this->returnValue(false));
			
		$s2->expects($this->once())
			->method('GetIsDefault')
			->will($this->returnValue(true));
		
		$schedules = array($s1, $s2);
		
		$page = $this->getMock('ISchedulePage');
		
		$page->expects($this->once())
			->method('IsPostBack')
			->will($this->returnValue(false));
		
		$pageBuilder = new SchedulePageBuilder();
		$actual = $pageBuilder->GetCurrentSchedule($page, $schedules);
		
		$this->assertEquals($s2, $actual);
	}
	
	public function testBindReservationsDisablesResourcesWithoutPermission()
	{
		throw new Exception("need to implement all security pieces");
				
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindReservations();

		// schedule security
		// resource security
		// need to change data access to only pull schedules, resources with access
	}

	public function testGetScheduleDatesStartsOnConfiguredDayOfWeek()
	{
		// saturday
		$currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 1;
		$daysVisible = 6;
		
		// sunday
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'CST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule);
		
		echo $expectedScheduleDates->ToString();
		echo $utcDates->ToString();
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsAheadByAWeek()
	{
		$this->markTestIncomplete('need to get the base case working first');
		
		// saturday
		$currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 1;
		$daysVisible = 5;
		
		// next week
		$expectedStart = Date::Create(2009, 07, 19, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession();
		$user->Timezone = 'EST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule);
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsBehindByAWeek()
	{
		$this->markTestIncomplete('need to get the base case working first');
		
		
		// sunday
		$currentServerDate = Date::Create(2009, 07, 19, 00, 30, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 1;
		$daysVisible = 3;
		
		// last week
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession();
		$user->Timezone = 'PST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule);
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testProvidedStartDateIsUsedIfSpecified()
	{
		
	}
}

//class FakeSchedulePage extends FakePageBase implements ISchedulePage
//{
//	public $_LastSchedules = array();
//	public $_LastResources = array();
//	public $_LastReservations = array();
//	public $_LastDates = array();
//
//	public $_SetSchedulesCalled = false;
//	public $_SetResourcesCalled = false;
//	public $_SetReservationsCalled = false;
//	public $_SetDatesCalled = false;
//	public $_ScheduleId;
//
//	public function SetSchedules($this->schedules)
//	{
//		$this->_LastSchedules = $this->schedules;
//		$this->_SetSchedulesCalled = true;
//	}
//
//	public function SetResources($resources)
//	{
//		$this->_LastResources = $resources;
//		$this->_SetResourcesCalled = true;
//	}
//
//	public function SetReservations($reservations)
//	{
//		$this->_LastReservations = $reservations;
//		$this->_SetReservationsCalled = true;
//	}
//
//	public function GetScheduleId()
//	{
//		return $this->_ScheduleId;
//	}
//
//	public function SetDisplayDates($dates)
//	{
//		$this->_SetDatesCalled = true;
//		$this->_LastDates = $dates;
//	}
//}

?>