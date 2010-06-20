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
	 * @return string
	 */
	public function ToString()
	{
		return "\nBegin: " . $this->_begin->ToString() . " End: " . $this->_end->ToString() . "\n";
	}
}
?>