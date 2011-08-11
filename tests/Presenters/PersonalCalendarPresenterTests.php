<?php
require_once(ROOT_DIR . 'Pages/PersonalCalendarPage.php');
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

class PersonalCalendarPresenterTests extends TestBase
{
	/**
	 * @var IPersonalCalendarPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var PersonalCalendarPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var ICalendarFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $calendarFactory;
	
	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IPersonalCalendarPage');
		$this->repository = $this->getMock('IReservationViewRepository');
		$this->calendarFactory = $this->getMock('ICalendarFactory');

		$this->presenter = new PersonalCalendarPresenter($this->page, $this->repository, $this->calendarFactory);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testBindsEmptyCalendarToPageWhenNoReservationsAreFound()
	{
		$userId = 10;
		$userTimezone = "America/New_York";

		$requestedMonth = 3;
		$requestedYear = 2011;

		$month = new CalendarMonth($requestedMonth, $requestedYear, $userTimezone);

		$reservations = array();

		$this->repository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($month->FirstDay()), $this->equalTo($month->LastDay()), $this->equalTo($userId), $this->equalTo(ReservationUserLevel::ALL))
			->will($this->returnValue($reservations));
		
		$this->page->expects($this->once())
				->method('GetMonth')
				->will($this->returnValue($requestedMonth));

		$this->page->expects($this->once())
				->method('GetYear')
				->will($this->returnValue($requestedYear));

		$this->calendarFactory->expects($this->once())
			->method('GetMonth')
			->with($this->equalTo($requestedYear), $this->equalTo($requestedMonth), $this->equalTo($userTimezone))
			->will($this->returnValue($month));

		$this->page->expects($this->once())
			->method('Bind')
			->with($this->equalTo($month));

		$this->presenter->PageLoad($userId, $userTimezone);
	}

	public function testAddsReservationsToCalendar()
	{
		$startsBeforeMonth = null;
		$endsAfterMonth = null;
		$firstDayOnly = null;
		$secondAndThirdDay = null;
		$notInMonth = null;

		$reservations = array();
		
		$timezone = 'America/Chicago';
		
		$month = new CalendarMonth(12, 2011, $timezone);

		$month->AddReservations($reservations);
		
		$expectedFirstDay = Date::Parse('2011-12-01', $timezone);
		$expectedLastDay = Date::Parse('2012-01-01', $timezone);
		
		$this->assertEquals($expectedFirstDay, $month->FirstDay());
		$this->assertEquals($expectedLastDay, $month->LastDay());

		$nullDay = CalendarDay::Null();
		$day1 = new CalendarDay($expectedFirstDay);
		$day2 = new CalendarDay($expectedFirstDay->AddDays(1));
		$day3 = new CalendarDay($expectedFirstDay->AddDays(2));

		$expectedWeek1 = new CalendarWeek(array($nullDay, $nullDay, $nullDay, $nullDay, $day1, $day2, $day3));
		$weeks = $month->Weeks();
		$this->assertEquals(5, count($weeks));
		/** @var $actualWeek1 CalendarWeek */
		$actualWeek1 = $weeks[0];
		$this->assertEquals($expectedWeek1, $actualWeek1);

		$actualDays = $actualWeek1->Days();

		$day1Reservations = $actualDays[4]->Reservations();

		$this->assertEquals(2, count($day1Reservations));
	}
}
?>