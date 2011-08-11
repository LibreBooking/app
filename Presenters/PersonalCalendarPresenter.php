<?php

class PersonalCalendarPresenter
{

	/**
	 * @var \IPersonalCalendarPage
	 */private $page;

	public function __construct(IPersonalCalendarPage $page)
	{
		$this->page = $page;
	}
	
	public function PageLoad($userId, $timezone)
	{
		$month = new CalendarMonth($this->page->GetMonth(), $this->page->GetYear(), $timezone);

		$this->page->Bind($month);
	}
}

/// TODO: Move to application
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
		$now = Date::Now();
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
			$calendarDay = new CalendarDay($currentDay);
			
			if ($currentDay->DateEquals($now))
			{
				$calendarDay->Highlight();
			}
			
			$this->weeks[$currentWeek]->AddDay($calendarDay);
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

interface ICalendarDay
{
	public function DayOfMonth();
	public function Weekday();
	public function IsHighlighted();
}

class CalendarDay implements ICalendarDay
{
	/**
	 * @var \Date
	 */
	private $date;

	/**
	 * @var bool
	 */
	private $isHighlighted = false;

	public function __construct(Date $date)
	{
		$this->date = $date;
	}

	/**
	 * @return int
	 */
	public function DayOfMonth()
	{
		return $this->date->Day();
	}
	
	/**
	 * @return int
	 */
	public function Weekday()
	{
		return $this->date->Weekday();
	}

	/**
	 * @return int
	 */
	public function IsHighlighted()
	{
		return $this->isHighlighted;
	}

	/**
	 * @return void
	 */
	public function Highlight()
	{
		$this->isHighlighted = true;
	}
	
	private static $nullInstance = null;

	/**
	 * @static
	 * @return CalendarDay
	 */
	public static function Null()
	{
		if (self::$nullInstance == null)
		{
			self::$nullInstance = new NullCalendarDay();
		}
		return self::$nullInstance;
	}
}

class NullCalendarDay implements ICalendarDay
{
	public function __construct()
	{
	}

	public function Weekday()
	{
		return null;
	}

	public function IsHighlighted()
	{
		return false;
	}

	public function DayOfMonth()
	{
		return null;
	}
}

class CalendarWeek
{
	/**
	 * @var array|CalendarDay[]
	 */
	private $days;

	public function __construct($days = array())
	{
		$this->days = $days;

		if (count($days) != 7)
		{
			for ($i = 0; $i < 7; $i++)
			{
				$this->days[$i] = CalendarDay::Null();
			}
		}
	}

	public function AddDay(CalendarDay $day)
	{
		$this->days[$day->Weekday()] = $day;
	}

	/**
	 * @return array|ICalendarDay[]
	 */
	public function Days()
	{
		return $this->days;
	}
}

?>
