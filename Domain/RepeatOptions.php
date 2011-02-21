<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

interface IRepeatOptions
{
	/**
	 * Gets array of DateRange objects
	 * 
	 * @param DateRange $startingDates
	 * @return array[int]DateRange
	 */
	function GetDates(DateRange $startingDates);
	
	function ConfigurationString();
	
	function RepeatType();
	
	function Equals(IRepeatOptions $repeatOptions);
	
	function HasSameConfigurationAs(IRepeatOptions $repeatOptions);
	
	function TerminationDate();
}

abstract class RepeatOptionsAbstract implements IRepeatOptions
{		
	/**
	 * @var int
	 */
	protected $_interval;
	
	/**
	 * @var Date
	 */
	protected $_terminationDate;
	
	/**
	 * @return Date
	 */
	public function TerminationDate()
	{
		return $this->_terminationDate;
	}
	
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 */
	protected function __construct($interval, $terminationDate)
	{
		$this->_interval = $interval;
		$this->_terminationDate = $terminationDate;
	}
	
	public function ConfigurationString() 
	{
		return sprintf("interval=%s|termination=%s", $this->_interval, $this->_terminationDate->ToDatabase());
	}
	
	public function Equals(IRepeatOptions $repeatOptions)
	{
		return $this->ConfigurationString() == $repeatOptions->ConfigurationString();
	}
	
	public function HasSameConfigurationAs(IRepeatOptions $repeatOptions)
	{
		return get_class($this) == get_class($repeatOptions) &&
				$this->_interval == $repeatOptions->_interval;
	}
}

class RepeatType
{
	const None = 'none';
	const Daily = 'daily';
	const Weekly = 'weekly';
	const Monthly = 'monthly';
	const Yearly = 'yearly';
}

class RepeatMonthlyType
{
	const DayOfMonth = 'dayOfMonth';
	const DayOfWeek = 'dayOfWeek';
}

class RepeatNone implements IRepeatOptions
{
	public function GetDates(DateRange $startingDate)
	{
		return array();
	}
	
	public function RepeatType()
	{
		return RepeatType::None;
	}
	
	public function ConfigurationString() 
	{
		return '';
	}
	
	public function Equals(IRepeatOptions $repeatOptions)
	{
		return get_class($this) == get_class($repeatOptions);
	}
	
	public function HasSameConfigurationAs(IRepeatOptions $repeatOptions)
	{
		return $this->Equals($repeatOptions);
	}
	
	public function TerminationDate()
	{
		return Date::Now();
	}
}

class RepeatDaily extends RepeatOptionsAbstract
{
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 */
	public function __construct($interval, $terminationDate)
	{
		parent::__construct($interval, $terminationDate);
	}
	
	public function GetDates(DateRange $startingRange)
	{
		$dates = array();
		$startDate = $startingRange->GetBegin()->AddDays($this->_interval);
		$endDate = $startingRange->GetEnd()->AddDays($this->_interval);

		while ($startDate->DateCompare($this->_terminationDate) <= 0)
		{
			$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
			$startDate = $startDate->AddDays($this->_interval);
			$endDate = $endDate->AddDays($this->_interval);
		}
		
		return $dates;
	}
	
	public function RepeatType()
	{
		return RepeatType::Daily;
	}
}
	
class RepeatWeekly extends RepeatOptionsAbstract
{
	/**
	 * @var array
	 */
	private $_daysOfWeek;
	
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 * @param array $daysOfWeek
	 */
	public function __construct($interval, $terminationDate, $daysOfWeek)
	{
		parent::__construct($interval, $terminationDate);
		
		$this->_daysOfWeek = $daysOfWeek;
		sort($this->_daysOfWeek);
	}
	
	public function GetDates(DateRange $startingRange)
	{
		$dates = array();
		
		$startDate = $startingRange->GetBegin();
		$endDate = $startingRange->GetEnd();
		
		$startWeekday = $startDate->Weekday();
		foreach ($this->_daysOfWeek as $weekday)
		{
			if ($startWeekday < $weekday)
			{
				$start = $startDate->AddDays($weekday - $startWeekday);
				$end = $endDate->AddDays($weekday - $startWeekday);
				
				$dates[] = new DateRange($start->ToUtc(), $end->ToUtc());
			}
		}
		
		$rawStart =  $startingRange->GetBegin();
		$rawEnd =  $startingRange->GetEnd();
		
		$week = 1;
		
		while ($startDate->DateCompare($this->_terminationDate) <= 0)
		{
			$weekOffset = (7 * $this->_interval * $week);
			
			for ($day = 0; $day < count($this->_daysOfWeek); $day++)
			{
				$intervalOffset = $weekOffset + ($this->_daysOfWeek[$day] - $startWeekday);
				$startDate = $rawStart->AddDays($intervalOffset);
				$endDate = $rawEnd->AddDays($intervalOffset);
			
				if ($startDate->DateCompare($this->_terminationDate) <= 0)
				{
					$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
				}
			}
			
			$week++;
		}

		return $dates;
	}
	
	public function RepeatType()
	{
		return RepeatType::Weekly;
	}
	
	public function ConfigurationString() 
	{
		$config = parent::ConfigurationString();
		return sprintf("%s|days=%s", $config, implode(',', $this->_daysOfWeek));
	}
	
	public function HasSameConfigurationAs(IRepeatOptions $repeatOptions)
	{
		return parent::HasSameConfigurationAs($repeatOptions) &&
			$this->_daysOfWeek == $repeatOptions->_daysOfWeek;
	}
}

class RepeatDayOfMonth extends RepeatOptionsAbstract
{
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 */
	public function __construct($interval, $terminationDate)
	{
		parent::__construct($interval, $terminationDate);
	}
	
	public function GetDates(DateRange $startingRange)
	{
		$dates = array();
		
		$startDate = $startingRange->GetBegin();
		$endDate = $startingRange->GetEnd();

		$rawStart = $startingRange->GetBegin();
		$rawEnd = $startingRange->GetEnd();
		
		$monthsFromStart = 1;
		while ($startDate->DateCompare($this->_terminationDate) <= 0)
		{
			$monthAdjustment = $monthsFromStart * $this->_interval;
			if ($this->DayExistsInNextMonth($rawStart, $monthAdjustment))
			{
				$startDate = $this->GetNextMonth($rawStart, $monthAdjustment);
				$endDate = $this->GetNextMonth($rawEnd, $monthAdjustment);
				if ($startDate->DateCompare($this->_terminationDate) <= 0)
				{
					$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
				}
			}
			$monthsFromStart++;
		}
		
		return $dates;
	}
	
	public function RepeatType()
	{
		return RepeatType::Monthly;
	}
	
	public function ConfigurationString() 
	{
		$config = parent::ConfigurationString();
		return sprintf("%s|type=%s", $config, RepeatMonthlyType::DayOfMonth);
	}
	
	private function DayExistsInNextMonth($date, $monthsFromStart)
	{
		$dateToCheck = Date::Create($date->Year(), $date->Month(), 1, 0, 0, 0, $date->Timezone());
		$nextMonth = $this->GetNextMonth($dateToCheck, $monthsFromStart);
		
		$daysInMonth = $nextMonth->Format('t');
		return $date->Day() <= $daysInMonth;
	}
	
	/**
	 * @var Date $date
	 * @return Date
	 */
	private function GetNextMonth($date, $monthsFromStart)
	{
		$yearOffset = 0;
		$computedMonth = $date->Month() + $monthsFromStart;
		$month = $computedMonth;
		
		if ($computedMonth > 12)
		{	
			$yearOffset = (int)$computedMonth/12;
			$month = $computedMonth % 12 + 1;
		}

		return Date::Create($date->Year() + $yearOffset, $month, $date->Day(), $date->Hour(), $date->Minute(), $date->Second(), $date->Timezone());
	}
}

class RepeatWeekDayOfMonth extends RepeatOptionsAbstract
{	
	private $_typeList = array (1 => 'first', 2 => 'second', 3 => 'third', 4 => 'fourth', 5 => 'fifth');
	private $_dayList = array(0 => 'sunday', 1 => 'monday', 2 => 'tuesday', 3 => 'wednesday', 4 => 'thursday', 5 => 'friday', 6 => 'saturday');
	
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 */
	public function __construct($interval, $terminationDate)
	{
		parent::__construct($interval, $terminationDate);
	}
	
	public function GetDates(DateRange $startingRange)
	{
		$dates = array();
		
		$startDate = $startingRange->GetBegin();
		$endDate = $startingRange->GetEnd();
		
		$durationStart = $startingRange->GetBegin();
		$firstWeekdayOfMonth = date('w', mktime(0, 0, 0, $durationStart->Month(), 1, $durationStart->Year()));
		
		$weekNumber = $this->GetWeekNumber($durationStart, $firstWeekdayOfMonth);
		$dayOfWeek = $durationStart->Weekday();
		$startMonth = $durationStart->Month();
		$startYear = $durationStart->Year();
		
		$monthsFromStart = 1;
		while ($startDate->DateCompare($this->_terminationDate) <= 0)
		{
			$monthAdjustment = $startMonth + $monthsFromStart * $this->_interval;
			$month = $monthAdjustment % 12;
			$year = $startYear + floor($monthAdjustment/12);
			
			$weekNumber = $this->GetWeekNumberOfMonth($weekNumber, $month, $year, $dayOfWeek);

			$dayOfMonth = strtotime("{$this->_typeList[$weekNumber]} {$this->_dayList[$dayOfWeek]} $year-$month-01");
			$calculatedDate =  date('Y-m-d', $dayOfMonth);
			$calculatedMonth = explode('-', $calculatedDate);
			
			$startDateString = $calculatedDate . " {$startDate->Hour()}:{$startDate->Minute()}:{$startDate->Second()}";
			$startDate = Date::Parse($startDateString, $startDate->Timezone());
				
			if ($month == $calculatedMonth[1])
			{
				if ($startDate->DateCompare($this->_terminationDate) <= 0)
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
	
	public function RepeatType()
	{
		return RepeatType::Monthly;
	}
	
	public function ConfigurationString() 
	{
		$config = parent::ConfigurationString();
		return sprintf("%s|type=%s", $config, RepeatMonthlyType::DayOfWeek);
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

class RepeatYearly extends RepeatOptionsAbstract
{
	/**
	 * @param int $interval
	 * @param Date $terminationDate
	 */
	public function __construct($interval, $terminationDate)
	{
		parent::__construct($interval, $terminationDate);
	}
	
	public function GetDates(DateRange $startingRange)
	{
		$dates = array();
		$begin = $startingRange->GetBegin();		
		$end = $startingRange->GetEnd();
		
		$nextStartYear = $begin->Year();
		$nextEndYear = $end->Year();
		$timezone = $begin->Timezone();
		
		$startDate = $begin;
		
		while ($startDate->DateCompare($this->_terminationDate) <= 0)
		{
			$nextStartYear = $nextStartYear + $this->_interval;
			$nextEndYear = $nextEndYear + $this->_interval;
			
			$startDate = Date::Create($nextStartYear, $begin->Month(), $begin->Day(), $begin->Hour(), $begin->Minute(), $begin->Second(), $timezone);
			$endDate = Date::Create($nextEndYear, $end->Month(), $end->Day(), $end->Hour(), $end->Minute(), $end->Second(), $timezone);
			
			if ($startDate->DateCompare($this->_terminationDate) <= 0)
			{
				$dates[] = new DateRange($startDate->ToUtc(), $endDate->ToUtc());
			}
		}
		
		return $dates;
	}
	
	public function RepeatType()
	{
		return RepeatType::Yearly;
	}
}

class RepeatOptionsFactory
{
	/**
	 * @param string $repeatType must be option in RepeatType enum
	 * @param int $interval
	 * @param Date $terminationDate
	 * @param array $weekdays
	 * @param string $monthlyType
	 * @return IRepeatOptions
	 */
	public function Create($repeatType, $interval, $terminationDate, $weekdays, $monthlyType)
	{
		switch ($repeatType)
		{
			case RepeatType::Daily : 
				return new RepeatDaily($interval, $terminationDate);
				
			case RepeatType::Weekly : 
				return new RepeatWeekly($interval, $terminationDate, $weekdays);
				
			case RepeatType::Monthly : 
				return ($monthlyType == RepeatMonthlyType::DayOfMonth) ? 
					new RepeatDayOfMonth($interval, $terminationDate) : 
					new RepeatWeekDayOfMonth($interval, $terminationDate);
					
			case RepeatType::Yearly : 
				return new RepeatYearly($interval, $terminationDate);
		}
		
		return new RepeatNone();
	}
}

class RepeatConfiguration
{
	/**
	 * @var string
	 */
	public $Type;
	
	/**
	 * @var string
	 */
	public $Interval;
	
	/**
	 * @var Date
	 */
	public $TerminationDate;
	
	/**
	 * @var array
	 */
	public $Weekdays;
	
	/**
	 * @var string
	 */
	public $MonthlyType;
	
	/**
	 * @param string $repeatType
	 * @param string $configurationString
	 * @return RepeatConfiguration
	 */
	public static function Create($repeatType, $configurationString)
	{
		$allparts = explode('|', $configurationString);
		$configParts = array();
		
		if (!empty($allparts[0]))
		{
			foreach($allparts as $part)
			{
				$keyValue = explode('=', $part);
				
				if (!empty($keyValue[0]))
				{
					$configParts[$keyValue[0]] = $keyValue[1];
				}
			}
		}
		
		$config = new RepeatConfiguration();
		$config->Type = $repeatType;
		
		$config->Interval = self::Get($configParts, 'interval');
		$config->SetTerminationDate(self::Get($configParts, 'termination'));
		$config->SetWeekdays(self::Get($configParts, 'days'));
		$config->MonthlyType = self::Get($configParts, 'type');

		return $config;
	}
	
	protected function __construct()
	{}
	
	private function Get($array, $key)
	{
		if (isset($array[$key]))
		{
			return $array[$key];
		}
		
		return null;
	}
	
	private function SetTerminationDate($terminationDateString)
	{
		if (!empty($terminationDateString))
		{
			$this->TerminationDate = Date::FromDatabase($terminationDateString);			
		}
	}
	
	private function SetWeekdays($weekdays)
	{
		if (!empty($weekdays))
		{
			$this->Weekdays = explode(',', $weekdays);
		}
	}
}
?>