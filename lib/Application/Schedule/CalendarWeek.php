<?php
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