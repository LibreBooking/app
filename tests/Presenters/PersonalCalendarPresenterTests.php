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

class CalendarMonth
{
	private $month;
	private $year;
	private $timezone;
	private $firstDay;
	private $lastDay;

	/**
	 * @var array|CalendarWeek[]
	 */
	private $weeks = array();
	
	public function __construct($month, $year, $timezone)
	{
		$this->month = $month;
		$this->year = $year;
		$this->timezone = $timezone;

		$this->firstDay = Date::Create($this->year, $this->month, 1, 0, 0, 0, $this->timezone);
		$this->lastDay = Date::Create($this->year, $this->month + 1, 1, 0, 0, $this->timezone);

		$daysInMonth = $this->lastDay->AddDays(-1)->Day();
		$weeks = floor($daysInMonth/7);

		for ($week = 0; $week <= $weeks; $week++)
		{
			$this->weeks[$week] = new CalendarWeek();
		}

		for ($dayOffset = 0; $dayOffset < $daysInMonth; $dayOffset++)
		{
			$currentDay = $this->firstDay->AddDays($dayOffset);
			$currentWeek = $this->GetWeekNumber($currentDay);
			$this->weeks[$currentWeek]->AddDay(new CalendarDay($currentDay));
		}
	}

	public function Weeks()
	{
		return $this->weeks;
	}

	public function FirstDay()
	{
		return $this->firstDay;
	}

	public function LastDay()
	{
		return $this->lastDay;
	}

	/**
	 * @param Date $day
	 * @return int
	 */
	private function GetWeekNumber(Date $day)
	{
		$firstWeekday = $this->firstDay->Weekday();

		$week = floor($day->Day()/7);

		if ($day->Day()%7==0)
		{
			$week = $day->Day()/7;
		}
		else
		{
			if ($day->Weekday() < $firstWeekday)
			{
				$week++;
			}
		}

		return intval($week);
	}
}
?>