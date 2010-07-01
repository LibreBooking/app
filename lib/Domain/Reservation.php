<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class Reservation
{
	/**
	 * @var int
	 */
	private $_userId;

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->_userId;
	}

	/**
	 * @var int
	 */
	private $_resourceId;

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->_resourceId;
	}

	/**
	 * @var string
	 */
	private $_title;

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->_title;
	}

	/**
	 * @var string
	 */
	private $_description;

	/**
	 * @return string
	 */
	public function Description()
	{
		return $this->_description;
	}

	/**
	 * @var Date
	 */
	private $_startDate;
	
	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->_startDate;
	}
	
	/**
	 * @var Date
	 */
	private $_endDate;
	
	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_endDate;
	}
	
	private $_repeatOptions;
	
	public function RepeatOptions()
	{
		return $this->_repeatOptions;
	}
	
	private $_repeatedDates;
	
	public function RepeatedDates()
	{
		return $this->_repeatedDates;
	}
	
	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param string $description
	 */
	public function Update($userId, $resourceId, $title, $description)
	{
		$this->_userId = $userId;
		$this->_resourceId = $resourceId;
		$this->_title = $title;
		$this->_description = $description;
	}

	/**
	 * @param DateRange $duration
	 */
	public function UpdateDuration(DateRange $duration)
	{
		$this->_startDate = $duration->GetBegin()->ToUtc();
		$this->_endDate = $duration->GetEnd()->ToUtc();
	}
	
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		$this->_repeatOptions = $repeatOptions;
		$this->_repeatedDates = $repeatOptions->GetDates();
	}
}

interface IRepeatOptions
{
	function GetDates();
}

class NoRepetion implements IRepeatOptions
{
	public function GetDates()
	{
		return array();
	}
}

class DailyRepeat implements IRepeatOptions
{
	/**
	 * @var int
	 */
	private $_interval;
	
	/**
	 * @var Date
	 */
	private $_terminiationDate;
	
	/**
	 * @var DateRange
	 */
	private $_duration;
	
	public function __construct($interval, $terminiationDate, $duration)
	{
		$this->_interval = $interval;
		$this->_terminiationDate = $terminiationDate;
		
		$this->_duration = $duration;
	}
	
	public function GetDates()
	{
		$dates = array();
		$startDate = $this->_duration->GetBegin()->AddDays($this->_interval);
		$endDate = $this->_duration->GetEnd()->AddDays($this->_interval);

		while ($startDate->Compare($this->_terminiationDate) <= 0)
		{
			$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
			$startDate = $startDate->AddDays($this->_interval);
			$endDate = $endDate->AddDays($this->_interval);
		}
		
		return $dates;
	}
}
	
class WeeklyRepeat implements IRepeatOptions
{
	/**
	 * @var int
	 */
	private $_interval;
	
	/**
	 * @var Date
	 */
	private $_terminiationDate;
	
	/**
	 * @var DateRange
	 */
	private $_duration;
	
	/**
	 * @var array
	 */
	private $_daysOfWeek;
	
	public function __construct($interval, $terminiationDate, $duration, $daysOfWeek)
	{
		$this->_interval = $interval;
		$this->_terminiationDate = $terminiationDate;
		
		$this->_duration = $duration;
		$this->_daysOfWeek = $daysOfWeek;
		sort($this->_daysOfWeek);
	}
	
	public function GetDates()
	{
		$dates = array();
		
		$startDate = $this->_duration->GetBegin();
		$endDate = $this->_duration->GetEnd();
		
		$startWeekday = $startDate->Weekday();
		foreach ($this->_daysOfWeek as $weekday)
		{
			if ($startWeekday < $weekday)
			{
				$startDate = $startDate->AddDays($weekday - $startWeekday);
				$endDate = $endDate->AddDays($weekday - $startWeekday);
				
				$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
			}
		}
		
		$rawStart =  $this->_duration->GetBegin();
		$rawEnd =  $this->_duration->GetEnd();
		
		$week = 1;
		
		while ($startDate->Compare($this->_terminiationDate) <= 0)
		{
			$weekOffset = (7 * $this->_interval * $week);
			
			for ($day = 0; $day < count($this->_daysOfWeek); $day++)
			{
				$intervalOffset = $weekOffset + ($this->_daysOfWeek[$day] - $startWeekday);
				$startDate = $rawStart->AddDays($intervalOffset);
				$endDate = $rawEnd->AddDays($intervalOffset);
			
				if ($startDate->Compare($this->_terminiationDate) <= 0)
				{
					$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
				}
			}
			
			$week++;
		}

		return $dates;
	}
}

class DayOfMonthRepeat implements IRepeatOptions
{
	/**
	 * @var int
	 */
	private $_interval;
	
	/**
	 * @var Date
	 */
	private $_terminiationDate;
	
	/**
	 * @var DateRange
	 */
	private $_duration;
	
	public function __construct($interval, $terminiationDate, $duration)
	{
		$this->_interval = $interval;
		$this->_terminiationDate = $terminiationDate;
		
		$this->_duration = $duration;
	}
	
	public function GetDates()
	{
		$dates = array();
		
		$startDate = $this->_duration->GetBegin();
		$endDate = $this->_duration->GetEnd();

		$rawStart = $this->_duration->GetBegin();
		$rawEnd = $this->_duration->GetEnd();
		
		$monthsFromStart = 1;
		while ($startDate->Compare($this->_terminiationDate) <= 0)
		{
			$monthAdjustment = $monthsFromStart * $this->_interval;
			if ($this->DayExistsInNextMonth($rawStart, $monthAdjustment))
			{
				$startDate = $this->GetNextMonth($rawStart, $monthAdjustment);
				$endDate = $this->GetNextMonth($rawEnd, $monthAdjustment);
				if ($startDate->Compare($this->_terminiationDate) <= 0)
				{
					$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
				}
			}
			$monthsFromStart++;
		}
		
		return $dates;
	}
	
	private function DayExistsInNextMonth($date, $monthsFromStart)
	{
		$nextMonth = Date::Create($date->Year(), $date->Month() + $monthsFromStart, 1, 0, 0, 0, $date->Timezone());
		
		$daysInMonth = $nextMonth->Format('t');
		return $date->Day() <= $daysInMonth;
	}
	
	/**
	 * @var Date $date
	 * @return Date
	 */
	private function GetNextMonth($date, $monthsFromStart)
	{
		return Date::Create($date->Year(), $date->Month() + $monthsFromStart, $date->Day(), $date->Hour(), $date->Minute(), $date->Second(), $date->Timezone());
	}
}

class WeekDayOfMonthRepeat implements IRepeatOptions
{
	/**
	 * @var int
	 */
	private $_interval;
	
	/**
	 * @var Date
	 */
	private $_terminiationDate;
	
	/**
	 * @var DateRange
	 */
	private $_duration;
	
	public function __construct($interval, $terminiationDate, $duration)
	{
		$this->_interval = $interval;
		$this->_terminiationDate = $terminiationDate;
		
		$this->_duration = $duration;
	}
	
	public function GetDates()
	{
		$dates = array();
		
		// TODO: Move this into the constructor
		$durationStart = $this->_duration->GetBegin();
		$firstWeekdayOfMonth = date('w', mktime(0, 0, 0, $durationStart->Month(), 1, $durationStart->Year()));
		$dayOfWeek = $durationStart->Weekday();
		$startMonth = $durationStart->Month();
		$startYear = $durationStart->Year();
		
		$week = $this->GetWeekNumber($durationStart, $firstWeekdayOfMonth);
			
		$type = array (1 => 'first', 2 => 'second', 3 => 'third', 4 => 'fourth', 5 => 'fifth');
		$day = array(0 => 'sunday', 1 => 'monday', 2 => 'tuesday', 3 => 'wednesday', 4 => 'thursday', 5 => 'friday', 6 => 'saturday');
		
		$startDate = $this->_duration->GetBegin();
		$endDate = $this->_duration->GetEnd();
		
		$monthsFromStart = 1;
		while ($startDate->Compare($this->_terminiationDate) <= 0)
		{
			$monthAdjustment = $startMonth + $monthsFromStart * $this->_interval;
			$month = $monthAdjustment % 12;
			$year = $startYear + floor($monthAdjustment/12);
			
			$weekNumber = $this->GetWeekNumberOfMonth($week, $month, $year, $dayOfWeek);

			$dayOfMonth = strtotime("{$type[$weekNumber]} {$day[$dayOfWeek]} $year-$month");
			$calculatedDate =  date('Y-m-d', $dayOfMonth);
			$calculatedMonth = explode('-', $calculatedDate);
			
			$startDateString = $calculatedDate . " {$startDate->Hour()}:{$startDate->Minute()}:{$startDate->Second()}";
			$startDate = Date::Parse($startDateString, $startDate->Timezone());
				
			if ($month == $calculatedMonth[1])
			{
				if ($startDate->Compare($this->_terminiationDate) <= 0)
				{
					$endDateString =  $calculatedDate . " {$endDate->Hour()}:{$endDate->Minute()}:{$endDate->Second()}";
					$endDate = Date::Parse($endDateString, $endDate->Timezone());
			
					$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
				}
			}

			$monthsFromStart++;
		}
		
		return $dates;
	}
	
	private function GetWeekNumber(Date $firstDate, $firstWeekdayOfMonth)
	{
		$week = ceil($firstDate->Day()/7);
		if ($firstWeekdayOfMonth > $firstDate->Weekday())
		{
			$week++;
		}
		
		return $week;
	}
	
	private function GetWeekNumberOfMonth($week, $month, $year, $desiredDayOfWeek)
	{
		$firstWeekdayOfMonth = date('w', mktime(0, 0, 0, $month, 1, $year));
	
		$weekNumber = $week;
		if ($firstWeekdayOfMonth == $desiredDayOfWeek)
		{
			$weekNumber--;
		}
		
		return $weekNumber;
	}
}
?>