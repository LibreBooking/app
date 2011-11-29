<?php
class DateRange
{
	/**
	 * @var Date
	 */
	private $_begin;
	
	/**
	 * @var Date
	 */
	private $_end;

	/**
	 * @param Date $begin
	 * @param Date $end
	 */
	public function __construct(Date $begin, Date $end)
	{
		$this->_begin = $begin;
		$this->_end = $end;
	}

	/**
	 * @param string $beginString
	 * @param string $endString
	 * @param string $timezoneString
	 * @return DateRange
	 */
	public static function Create($beginString, $endString, $timezoneString)
	{
		return new DateRange(Date::Parse($beginString, $timezoneString), Date::Parse($endString, $timezoneString));
	}

	/**
	 * Whether or not the $date is within the range.  Range boundaries are inclusive
	 * @param Date $date
	 * @return bool
	 */
	public function Contains(Date $date)
	{
		return $this->_begin->Compare($date) <= 0 && $this->_end->Compare($date) >= 0;
	}

	/**
	 * @param DateRange $dateRange
	 * @return bool
	 */
	public function ContainsRange(DateRange $dateRange)
	{
		return $this->_begin->Compare($dateRange->_begin) <= 0 && $this->_end->Compare($dateRange->_end) >= 0;
	}

	/**
	 * Whether or not the date ranges overlap.  Dates that start or end on boundaries are excluded
	 * @param DateRange $dateRange
	 * @return bool
	 */
	public function Overlaps(DateRange $dateRange)
	{
		return ($this->Contains($dateRange->GetBegin()) || $this->Contains($dateRange->GetEnd()) ||
				$dateRange->Contains($this->GetBegin()) || $dateRange->Contains($this->GetEnd())) &&
				(!$this->GetBegin()->Equals($dateRange->GetEnd()) && !$this->GetEnd()->Equals($dateRange->GetBegin()));

	}

	/**
	 * Whether or not any date within this range occurs on the provided date
	 * @param Date $date
	 * @return bool
	 */
	public function OccursOn(Date $date)
	{
		$timezone = $date->Timezone();
		$compare = $this->ToTimezone($timezone);
		$beginMidnight = $compare->GetBegin();

		if ($this->GetEnd()->IsMidnight())
		{
			$endMidnight = $compare->GetEnd();
		}
		else
		{
			$endMidnight = $compare->GetEnd()->AddDays(1);
		}

		return ($beginMidnight->DateCompare($date) <= 0 &&
				$endMidnight->DateCompare($date) > 0);
	}

	/**
	 * @return Date
	 */
	public function GetBegin()
	{
		return $this->_begin;	
	}

	/**
	 * @return Date
	 */
	public function GetEnd()
	{
		return $this->_end;
	}
	
	/**
	 * @return array[int]Date
	 */
	public function Dates()
	{
		$current = $this->_begin->GetDate();
		$end = $this->_end->GetDate();
		
		$dates = array($current);
		
		for($day = 0; $current->Compare($end) < 0; $day++)
		{
			$current = $current->AddDays(1);
			$dates[] = $current;
		}
		
		return $dates;
	}
	
	/**
	 * @param DateRange $otherRange
	 * @return bool
	 */
	public function Equals(DateRange $otherRange)
	{
		return $this->_begin->Equals($otherRange->GetBegin()) && $this->_end->Equals($otherRange->GetEnd());
	}
	
	/**
	 * @param string $timezone
	 * @return DateRange
	 */
	public function ToTimezone($timezone)
	{
		return new DateRange($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone));
	}
	
	/**
	 * @return DateRange
	 */
	public function ToUtc()
	{
		return new DateRange($this->_begin->ToUtc(), $this->_end->ToUtc());
	}
	
	/**
	 * @param int $days
	 * @return DateRange
	 */
	public function AddDays($days)
	{
		return new DateRange($this->_begin->AddDays($days), $this->_end->AddDays($days));
	}
	
	/**
	 * @return string
	 */
	public function ToString()
	{
		return "\nBegin: " . $this->_begin->ToString() . " End: " . $this->_end->ToString() . "\n";
	}
	
	public function __toString()
	{
		return $this->ToString();
	}
}

class NullDateRange extends DateRange
{
	protected static $instance;
	
	public function __construct()
	{
		parent::__construct(Date::Now(), Date::Now());
	}
	
	/**
	 * @return NullDateRange
	 */
	public static function Instance()
	{
		if(self::$instance == null)
		{
			self::$instance = new NullDateRange();
		}
		
		return self::$instance;
	}
}
?>