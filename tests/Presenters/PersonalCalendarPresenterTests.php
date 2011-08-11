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

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IPersonalCalendarPage');
		$this->presenter = new PersonalCalendarPresenter($this->page);
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
		
		$this->page->expects($this->once())
				->method('GetMonth')
				->will($this->returnValue($requestedMonth));

		$this->page->expects($this->once())
				->method('GetYear')
				->will($this->returnValue($requestedYear));

		$month = new CalendarMonth($requestedMonth, $requestedYear, $userTimezone);
		
		$this->page->expects($this->once())
			->method('Bind')
			->with($this->equalTo($month));

		$this->presenter->PageLoad($userId, $userTimezone);
	}

	public function testAddsReservationsToCalendar()
	{
		$timezone = 'America/Chicago';
		
		$month = new CalendarMonth(12, 2011, $timezone);

		$expectedFirstDay = Date::Parse('2011-12-01', $timezone);
		$expectedLastDay = Date::Parse('2012-01-01', $timezone);
		
		$this->assertEquals($expectedFirstDay, $month->FirstDay());
		$this->assertEquals($expectedLastDay, $month->LastDay());

		$nullDay = CalendarDay::Null();
		$day1 = new CalendarDay($expectedFirstDay);
		$day2 = new CalendarDay($expectedFirstDay->AddDays(1));
		$day3 = new CalendarDay($expectedFirstDay->AddDays(2));

		$week1 = new CalendarWeek(array($nullDay, $nullDay, $nullDay, $nullDay, $day1, $day2, $day3));
		$weeks = $month->Weeks();
		$this->assertEquals(5, count($weeks));
		$this->assertEquals($week1, $weeks[0]);
	}
}
?>