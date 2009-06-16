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
	 * @return DateRange
	 */
	public function ToTimezone(string $timezone)
	{
		return new DateRange($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone));
	}
}
?>