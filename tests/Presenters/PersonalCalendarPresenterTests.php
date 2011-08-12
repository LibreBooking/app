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
		$startsBeforeMonth = new ReservationItemView();
		$startsBeforeMonth->StartDate = Date::Parse('2011-11-25', 'UTC');
		$startsBeforeMonth->EndDate = Date::Parse('2011-12-01 12:25', 'UTC');
		$startsBeforeMonth->ResourceName = 'Something Fun';
		$startsBeforeMonth->UserLevelId = ReservationUserLevel::OWNER;

		$endsAfterMonth = new ReservationItemView();;
		$endsAfterMonth->StartDate = Date::Parse('2011-12-25', 'UTC');
		$endsAfterMonth->EndDate = Date::Parse('2012-01-25', 'UTC');
		$endsAfterMonth->ResourceName = 'Something Fun';
		$endsAfterMonth->UserLevelId = ReservationUserLevel::PARTICIPANT;
		
		$firstDayOnly = new ReservationItemView();
		$firstDayOnly->StartDate = Date::Parse('2011-12-01 14:00', 'UTC');
		$firstDayOnly->EndDate = Date::Parse('2011-12-01 16:25', 'UTC');
		$firstDayOnly->ResourceName = 'Something Fun';
		$firstDayOnly->UserLevelId = ReservationUserLevel::OWNER;
		
		$secondAndThirdDay = new ReservationItemView();
		$secondAndThirdDay->StartDate = Date::Parse('2011-12-02 14:00', 'UTC');
		$secondAndThirdDay->EndDate = Date::Parse('2011-12-03 16:25', 'UTC');
		$secondAndThirdDay->ResourceName = 'Something Fun';
		$secondAndThirdDay->UserLevelId = ReservationUserLevel::INVITEE;
		
		$notInMonth = new ReservationItemView();
		$notInMonth->StartDate = Date::Parse('2011-11-02 14:00', 'UTC');
		$notInMonth->EndDate = Date::Parse('2011-11-03 16:25', 'UTC');
		$notInMonth->ResourceName = 'Something Fun';
		$notInMonth->UserLevelId = ReservationUserLevel::OWNER;

		$reservations = array($startsBeforeMonth, $endsAfterMonth, $firstDayOnly, $secondAndThirdDay, $notInMonth);
		
		$timezone = 'America/Chicago';
		
		$month = new CalendarMonth(12, 2011, $timezone);

		$month->AddReservations($reservations);
		
		$expectedFirstDay = Date::Parse('2011-12-01', $timezone);
		$expectedLastDay = Date::Parse('2012-01-01', $timezone);
		
		$this->assertEquals($expectedFirstDay, $month->FirstDay());
		$this->assertEquals($expectedLastDay, $month->LastDay());

		$nullDay = CalendarDay::Null();
		$day1 = new CalendarDay($expectedFirstDay);
		$day1->AddReservation($startsBeforeMonth);
		$day1->AddReservation($firstDayOnly);
		$day2 = new CalendarDay($expectedFirstDay->AddDays(1));
		$day2->AddReservation($secondAndThirdDay);
		$day3 = new CalendarDay($expectedFirstDay->AddDays(2));
		$day3->AddReservation($secondAndThirdDay);

		$weeks = $month->Weeks();
		/** @var $actualWeek1 CalendarWeek */
		$actualWeek1 = $weeks[0];
		/** @var $actualDays array|CalendarDay[] */
		$actualDays = $actualWeek1->Days();
		
		$this->assertEquals(5, count($weeks));
		$this->assertEquals(7, count($actualDays));
		$this->assertEquals($nullDay, $actualDays[0]);
		$this->assertEquals($nullDay, $actualDays[1]);
		$this->assertEquals($nullDay, $actualDays[2]);
		$this->assertEquals($nullDay, $actualDays[3]);

		$this->assertEquals(2, count($actualDays[4]->Reservations()));
		$this->assertEquals($day1, $actualDays[4]);
		$this->assertEquals($day2, $actualDays[5]);
		$this->assertEquals($day3, $actualDays[6]);

		$lastWeekDays = $weeks[4]->Days();
		$lastDayReservations = $lastWeekDays[6]->Reservations();
		$this->assertEquals($endsAfterMonth, $lastDayReservations[0]);
	}
}
?>