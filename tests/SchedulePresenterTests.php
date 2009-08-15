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
		$reservations = $this->getMock('IReservationListing');
		$bindingDates = new DateRange(Date::Now(), Date::Now());
		
		$page = $this->getMock('ISchedulePage');
		$scheduleRepository = $this->getMock('IScheduleRepository');
		$resourceService = $this->getMock('IResourceService');
		$reservationService = $this->getMock('IReservationService');
		$pageBuilder = $this->getMock('ISchedulePageBuilder');
		$layout = $this->getMock('IScheduleLayout');
				
		$presenter = new SchedulePresenter($page);
		$presenter->SetScheduleRepository($scheduleRepository);
		$presenter->SetResourceService($resourceService);
		$presenter->SetReservationService($reservationService);
		$presenter->SetPageBuilder($pageBuilder);

		$scheduleRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($this->schedules));
		
		$scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($this->scheduleId))
			->will($this->returnValue($layout));
		
		$pageBuilder->expects($this->once())
			->method('GetCurrentSchedule')
			->with($this->equalTo($page), $this->equalTo($this->schedules))
			->will($this->returnValue($this->currentSchedule));
		
		$pageBuilder->expects($this->once())
			->method('BindSchedules')
			->with($this->equalTo($page), $this->equalTo($this->schedules), $this->scheduleId);
		
		$resourceService->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($this->scheduleId))
			->will($this->returnValue($resources));
		
		$pageBuilder->expects($this->once())
			->method('GetScheduleDates')
			->with($this->equalTo($user), $this->equalTo($this->currentSchedule), $this->equalTo($page))
			->will($this->returnValue($bindingDates));
			
		$pageBuilder->expects($this->once())
			->method('BindDisplayDates')
			->with($this->equalTo($page, $bindingDates));
		
		$reservationService->expects($this->once())
			->method('GetReservations')
			->with($this->equalTo($bindingDates), $this->equalTo($this->scheduleId), $this->equalTo($user->Timezone), $this->equalTo($layout))
			->will($this->returnValue($reservations));
		
		$pageBuilder->expects($this->once())
			->method('BindLayout')
			->with($this->equalTo($layout));
		
		$pageBuilder->expects($this->once())
			->method('BindReservations')
			->with($this->equalTo($page), $this->equalTo($resources), $this->equalTo($reservations));

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

	public function testGetScheduleDatesStartsOnConfiguredDayOfWeekWhenStartDayIsPriorToToday()
	{
		// saturday
		$currentServerDate = Date::Create(2009, 07, 18, 11, 00, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 0;
		$daysVisible = 6;
		
		// previous sunday
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'CST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
			
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue(null));	
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);
		
		//echo $expectedScheduleDates->ToString();
		//echo $utcDates->ToString();
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testGetScheduleDatesStartsOnConfiguredDayOfWeekWhenStartDayIsAfterToday()
	{
		// tuesday
		$currentServerDate = Date::Create(2009, 07, 14, 11, 00, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 3;
		$daysVisible = 6;
		
		// previous wednesday
		$expectedStart = Date::Create(2009, 07, 8, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'CST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
			
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue(null));	
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);
		
		//echo $expectedScheduleDates->ToString();
		//echo $utcDates->ToString();
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsAheadByAWeek()
	{
		// saturday
		$currentServerDate = Date::Create(2009, 07, 18, 23, 00, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 0;
		$daysVisible = 5;
		
		// sunday of next week
		$expectedStart = Date::Create(2009, 07, 19, 00, 00, 00, 'EST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'EST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
			
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue(null));	
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);
		
		//echo $expectedScheduleDates->ToString();
		//echo $utcDates->ToString();
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testCorrectDatesAreUsedWhenTheUsersTimezoneIsBehindByAWeek()
	{
		// sunday
		$currentServerDate = Date::Create(2009, 07, 19, 00, 30, 00, 'CST');
		Date::_SetNow($currentServerDate);
		
		$startDay = 0;
		$daysVisible = 3;
		
		// previous sunday
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'PST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'PST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
			
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue(null));	
			
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testProvidedStartDateIsUsedIfSpecified()
	{
		// saturday
		$selectedDate = Date::Create(2009, 07, 18, 00, 00, 00, 'UTC');
		
		$startDay = 0;
		$daysVisible = 6;
		
		// previous sunday
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'CST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
		
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue($selectedDate->Timestamp()));	
		
		$schedule->expects($this->once())
			->method('GetWeekdayStart')
			->will($this->returnValue($startDay));	

		$schedule->expects($this->once())
			->method('GetDaysVisible')
			->will($this->returnValue($daysVisible));	
		
		$pageBuilder = new SchedulePageBuilder();
		$utcDates = $pageBuilder->GetScheduleDates($user, $schedule, $schedulePage);
		
		//echo $expectedScheduleDates->ToString();
		//echo $utcDates->ToString();
		
		$this->assertEquals($expectedScheduleDates, $utcDates);
	}
	
	public function testBindReservationsSetsReservationsAndResourcesOnPage()
	{
		$page = $this->getMock('ISchedulePage');
		$reservations = $this->getMock('IReservationListing');
		$resources = array();
		
		$page->expects($this->once())
			->method('SetResources')
			->with($this->equalTo($resources));
			
		$page->expects($this->once())
			->method('SetReservations')
			->with($this->equalTo($reservations));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindReservations($page, $resources, $reservations);
	}
	
	public function testBindDisplayDatesSetsDatesOnPage()
	{
		$page = $this->getMock('ISchedulePage');
		
		$displayDates = new DateRange(Date::Now(), Date::Now());
		
		$page->expects($this->once())
			->method('SetDisplayDates')
			->with($this->equalTo($displayDates));
			
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindDisplayDates($page, $displayDates);
	}
	
	public function testBindLayoutSetsLayoutOnPage()
	{
		$page = $this->getMock('ISchedulePage');
		$layout = $this->getMock('IScheduleLayout');
		
		$page->expects($this->once())
			->method('BindLayout')
			->with($this->equalTo($layout));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindLayout($page, $layout);
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

class FakeResource implements IResource
{
	public $_id;
	public $_name;
	
	public function __construct($id, $name)
	{
		$this->_id = $id;
		$this->_name = $name;
	}
	
	public function GetResourceId()
	{
		return $this->_id;
	}
	
	public function GetName()
	{
		return $this->_name;
	}
}

interface IPermissionService
{
	public function CanAccessResource(IResource $resource);	
}
?>