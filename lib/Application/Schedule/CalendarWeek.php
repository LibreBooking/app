<?php
class CalendarWeek implements ICalendarSegment
{
	/**
	 * @var array|CalendarDay[]
	 */
	private $days = array();

	/**
	 * @var string
	 */
	private $timezone;

	public function __construct($timezone)
	{
		$this->timezone = $timezone;
		
		for ($i = 0; $i < 7; $i++)
		{
			$this->days[$i] = CalendarDay::Null();
		}
	}

	public static function FromDate($year, $month, $day, $timezone)
	{
		$week = new CalendarWeek($timezone);

		return $week;
	}

	public function FirstDay()
	{
		for ($i = 0; $i < 7; $i++)
		{
			if ($this->days[$i] != CalendarDay::Null())
			{
				return $this->days[$i]->Date();
			}
		}

		return NullDate::Instance();
	}

	public function LastDay()
	{
		for ($i = 6; $i >=0; $i--)
		{
			if ($this->days[$i] != CalendarDay::Null())
			{
				return $this->days[$i]->Date();
			}
		}

		return NullDate::Instance();
	}

	public function AddReservations($reservations)
	{
		/** @var $reservation ReservationItemView */
		foreach ($reservations as $reservation)
		{
			foreach ($this->Days() as $day)
			{
				$day->AddReservation(CalendarReservation::FromView($reservation, $this->timezone));
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

	/**
	 * @param $reservation CalendarReservation
	 * @return void
	 */
	public function AddReservation($reservation)
	{
		/** @var $day CalendarDay */
		foreach ($this->days as $day)
		{
			$day->AddReservation($reservation);
		}
	}
}

?>