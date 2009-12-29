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
	private $showInaccessibleResources = 'true';

	public function setup()
	{
		parent::setup();

		$this->scheduleId = 1;
		$this->numDaysVisible = 10;
		$this->currentSchedule = new Schedule($this->scheduleId, 'default', 1, '08:30', '19:00', 1, 1, $this->numDaysVisible);
		$otherSchedule = new Schedule(2, 'not default', 0, '08:30', '19:00', 1, 1, $this->numDaysVisible);
		
		$this->schedules = array($this->currentSchedule, $otherSchedule);
		$this->fakeConfig->SetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, $this->showInaccessibleResources);
	}

	public function teardown()
	{
		parent::teardown();

		Date::_ResetNow();
	}
	
	public function testPageLoadBindsAllSchedulesAndProperResourcesWhenNotPostingBack2()
	{
		$user = $this->fakeServer->GetUserSession();
		$userId = $user->UserId;
		$resources = array();
		$reservations = $this->getMock('IReservationListing');
		$layout = $this->getMock('IScheduleLayout');
		$bindingDates = new DateRange(Date::Now(), Date::Now());
		
		$page = $this->getMock('ISchedulePage');
		$scheduleRepository = $this->getMock('IScheduleRepository');
		$resourceService = $this->getMock('IResourceService');
		$pageBuilder = $this->getMock('ISchedulePageBuilder');
		$permissionService = $this->getMock('IPermissionService');
		$permissionServiceFactory = $this->getMock('IPermissionServiceFactory');
		$reservationService = $this->getMock('IReservationService');
		$dailyLayoutFactory = $this->getMock('IDailyLayoutFactory');
		$dailyLayout = $this->getMock('IDailyLayout');
				
		$presenter = new SchedulePresenter($page, $scheduleRepository, $resourceService, $pageBuilder, $permissionServiceFactory, $reservationService, $dailyLayoutFactory);

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
			->with($this->equalTo($page), $this->equalTo($this->schedules), $this->equalTo($this->currentSchedule));
		
		$permissionServiceFactory->expects($this->once())
			->method('GetPermissionService')
			->with($this->equalTo($userId))
			->will($this->returnValue($permissionService));
			
		$resourceService->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($this->scheduleId), $this->equalTo((bool)$this->showInaccessibleResources), $this->equalTo($permissionService))
			->will($this->returnValue($resources));
		
		$pageBuilder->expects($this->once())
			->method('GetScheduleDates')
			->with($this->equalTo($user), $this->equalTo($this->currentSchedule), $this->equalTo($page))
			->will($this->returnValue($bindingDates));
			
		$pageBuilder->expects($this->once())
			->method('BindDisplayDates')
			->with($this->equalTo($page), $this->equalTo($bindingDates), $this->equalTo($user));
		
		$reservationService->expects($this->once())
			->method('GetReservations')
			->with($this->equalTo($bindingDates), $this->equalTo($this->scheduleId), $this->equalTo($user->Timezone))
			->will($this->returnValue($reservations));
		
		$pageBuilder->expects($this->once())
			->method('BindLayout')
			->with($this->equalTo($page), $this->equalTo($layout));
		
		$dailyLayoutFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($reservations), $this->equalTo($layout))
			->will($this->returnValue($dailyLayout));
		
		$pageBuilder->expects($this->once())
			->method('BindReservations')
			->with($this->equalTo($page), $this->equalTo($resources), $this->equalTo($dailyLayout));
			
		$presenter->PageLoad();
		
	}
	
	public function testScheduleBuilderBindsAllSchedulesAndSetsActive()
	{
		$activeId = 100;
		$activeName = 'super active';
		
		$schedule = $this->getMock('ISchedule');
		$page = $this->getMock('ISchedulePage');
		
		$schedule->expects($this->once())
			->method('GetId')
			->will($this->returnValue($activeId));
			
		$schedule->expects($this->once())
			->method('GetName')
			->will($this->returnValue($activeName));
		
		$page->expects($this->once())
			->method('SetSchedules')
			->with($this->equalTo($this->schedules));
			
		$page->expects($this->once())
			->method('SetScheduleId')
			->with($this->equalTo($activeId));
			
		$page->expects($this->once())
			->method('SetScheduleName')
			->with($this->equalTo($activeName));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindSchedules($page, $this->schedules, $schedule);
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
		$expectedEnd = $expectedStart->AddDays($daysVisible -1);
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
		$expectedEnd = $expectedStart->AddDays($daysVisible -1);
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
		$expectedEnd = $expectedStart->AddDays($daysVisible -1);
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
		$expectedEnd = $expectedStart->AddDays($daysVisible -1);
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
		$selectedDate = Date::Create(2009, 07, 18, 00, 00, 00, 'CST');
		
		$startDay = 0;
		$daysVisible = 6;
		
		// previous sunday
		$expectedStart = Date::Create(2009, 07, 12, 00, 00, 00, 'CST')->ToUtc();
		$expectedEnd = $expectedStart->AddDays($daysVisible -1);
		$expectedScheduleDates = new DateRange($expectedStart, $expectedEnd);
		
		$user = new UserSession(1);
		$user->Timezone = 'CST';
		$this->fakeConfig->SetTimezone('CST');
		
		$schedule = $this->getMock('ISchedule');
		$schedulePage = $this->getMock('ISchedulePage');
		
		$schedulePage->expects($this->once())
			->method('GetSelectedDate')
			->will($this->returnValue($selectedDate->Format("Y-m-d")));	
		
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
		$dailyLayout = $this->getMock('IDailyLayout');
		$resources = array();
		
		$page->expects($this->once())
			->method('SetResources')
			->with($this->equalTo($resources));
			
		$page->expects($this->once())
			->method('SetDailyLayout')
			->with($this->equalTo($dailyLayout));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindReservations($page, $resources, $dailyLayout);
	}
	
	public function testBindDisplayDatesSetsPageToArrayOfDatesInUserTimezoneForRange()
	{
		$user = new UserSession(1);
		$user->Timezone = 'EST';
		$page = $this->getMock('ISchedulePage');
		
		$daysDisplayed = 5;
		$startWeekday = 1;
		
		$displayRange = new DateRange(Date::Now(), Date::Now()->AddDays(1));
		$expectedRange = $displayRange->ToTimezone('EST');
		
		$expectedPrev = $expectedRange->GetBegin()->AddDays(-7);
		$expectedNext = $expectedRange->GetBegin()->AddDays(7);
		
		$page->expects($this->once())
			->method('SetDisplayDates')
			->with($this->equalTo($expectedRange));
		
		$page->expects($this->once())
			->method('SetPreviousNextDates')
			->with($this->equalTo($expectedPrev), $this->equalTo($expectedNext));
			
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindDisplayDates($page, $displayRange, $user);
	}
	
	public function testBindLayoutSetsLayoutOnPage()
	{
		$page = $this->getMock('ISchedulePage');
		$layout = $this->getMock('IScheduleLayout');
		
		$periods = array();
		
		$layout->expects($this->once())
			->method('GetLayout')
			->will($this->returnValue($periods));
			
		$page->expects($this->once())
			->method('SetLayout')
			->with($this->equalTo($periods));
		
		$pageBuilder = new SchedulePageBuilder();
		$pageBuilder->BindLayout($page, $layout);
	}
}

?>