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
	 * @return DateRange
	 */
	public static function Create(string $begin, string $end, string $timezone)
	{
		return new DateRange(Date::Parse($begin, $timezone), Date::Parse($end, $timezone));
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
	 * @param string $timezone
	 * @return DateRange
	 */
	public function ToTimezone($timezone)
	{
		return new DateRange($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone));
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