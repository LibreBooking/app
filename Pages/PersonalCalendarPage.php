<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

interface IPersonalCalendarPage
{
	function GetMonth();
	function GetYear();

	function Bind(CalendarMonth $month);
}

class PersonalCalendarPage extends SecurePage implements IPersonalCalendarPage
{
	public function __construct()
	{
	    parent::__construct('MyCalendar');
	}

	public function PageLoad()
	{
		//$reservationRepository = new ReservationViewRepository();
		//$reservationRepository->GetReservationList()
		$week1 = new CalendarWeek($this->GetDays(0));
		$week2 = new CalendarWeek($this->GetDays(7));
		$weeks = array($week1, $week2);
		$this->Set('Weeks', $weeks);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Display('mycalendar.tpl');
	}

	private function GetDays($startDay)
	{
		$days = array();
		$lastDay = $startDay+7;
		for ($i = $startDay; $i < $lastDay; $i++)
		{
			$days[] = new CalendarDay($i);
		}

		return $days;
	}

	public function GetMonth()
	{
		// TODO: Implement GetMonth() method.
	}

	public function GetYear()
	{
		// TODO: Implement GetYear() method.
	}

	public function Bind(CalendarMonth $month)
	{
		// TODO: Implement Bind() method.
	}
}

class CalendarDay
{
	public $Number;

	private $date;
	
	public function __construct(Date $date)
	{
		$this->Number = $date->Day();
		$this->date = $date;
	}

	public function Weekday()
	{
		return $this->date->Weekday();
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

class NullCalendarDay extends CalendarDay
{
	public function __construct()
	{
	    
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
	
	public function Days()
	{
		return $this->days;
	}
}
?>
