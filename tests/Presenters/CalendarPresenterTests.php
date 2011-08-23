<?php
require_once(ROOT_DIR . 'Pages/CalendarPage.php');
require_once(ROOT_DIR . 'Presenters/CalendarPresenter.php');

class CalendarPresenterTests extends TestBase
{
	/**
	 * @var ICalendarPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var CalendarPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var ICalendarFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $calendarFactory;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;
	
	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('ICalendarPage');
		$this->repository = $this->getMock('IReservationRepository');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->calendarFactory = $this->getMock('ICalendarFactory');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new CalendarPresenter(
			$this->page,
			$this->calendarFactory,
			$this->repository,
			$this->scheduleRepository,
			$this->resourceRepository);
	}

	public function testBindsDefaultScheduleByMonthWhenNothingSelected()
	{
		$userId = 100;
		$defaultScheduleId = 10;
		$userTimezone = "America/New_York";

		$calendarType = CalendarTypes::Month;

		$requestedDay = 4;
		$requestedMonth = 3;
		$requestedYear = 2011;

		$month = new CalendarMonth($requestedMonth, $requestedYear, $userTimezone);

		$startDate = Date::Parse('2011-01-01', 'UTC');
		$endDate = Date::Parse('2011-01-02', 'UTC');
		$summary = 'foo summary';
		$resourceId = 3;
		$fname = 'fname';
		$lname = 'lname';
		$referenceNumber = 'refnum';
		$resourceName = 'resource name';
		
		$res = new ScheduleReservation(1, $startDate, $endDate, null, $summary, $resourceId, $userId, $fname, $lname, $referenceNumber);

		$r1 = new FakeBookableResource(1, 'dude1');
		$r2 = new FakeBookableResource($resourceId, $resourceName);

		$reservations = array($res);
		$resources = array($r1, $r2);
		$schedules = array(
			new Schedule(1, null, false, null, null),
			new Schedule($defaultScheduleId, null, true, null, null),
		);

		$this->repository->expects($this->once())
			->method('GetWithin')
			->with($this->equalTo($month->FirstDay()), $this->equalTo($month->LastDay()), $this->equalTo($defaultScheduleId))
			->will($this->returnValue($reservations));

		$this->scheduleRepository->expects($this->once())
				->method('GetAll')
				->will($this->returnValue($schedules));

		$this->resourceRepository->expects($this->once())
				->method('GetResourceList')
				->will($this->returnValue($resources));

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue(null));

		$this->page->expects($this->once())
				->method('GetResourceId')
				->will($this->returnValue(null));

		$this->page->expects($this->once())
				->method('GetCalendarType')
				->will($this->returnValue($calendarType));

		$this->page->expects($this->once())
				->method('GetDay')
				->will($this->returnValue($requestedDay));

		$this->page->expects($this->once())
				->method('GetMonth')
				->will($this->returnValue($requestedMonth));

		$this->page->expects($this->once())
				->method('GetYear')
				->will($this->returnValue($requestedYear));

		$this->calendarFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($calendarType), $this->equalTo($requestedYear), $this->equalTo($requestedMonth), $this->equalTo($requestedDay), $this->equalTo($userTimezone))
			->will($this->returnValue($month));

		$this->page->expects($this->once())
			->method('BindCalendar')
			->with($this->equalTo($month));

		$calendarFilters = new CalendarFilters($schedules, $resources, $defaultScheduleId, null);
		$this->page->expects($this->once())
				->method('BindFilters')
				->with($this->equalTo($calendarFilters));

		$this->presenter->PageLoad($userId, $userTimezone);

		$actualReservations = $month->Reservations();

		$expectedReservations = CalendarReservation::FromScheduleReservationList($reservations, $resources, $userTimezone);

		$this->assertEquals($expectedReservations, $actualReservations);
	}
}
?>