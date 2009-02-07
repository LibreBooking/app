<?php
class DateRange
{
	private $_begin;
	private $_end;
	
	public function __construct(Date $begin, Date $end)
	{
		$this->_begin = $begin;	
		$this->_end = $end;	
	}
	
	public static function Create(string $begin, string $end, string $timezone)
	{
		return new DateRange(Date::Parse($begin, $timezone), Date::Parse($end, $timezone));
	}
	
	public function Contains(Date $date)
	{
		return $this->_begin->Compare($date) <= 0 && $this->_end->Compare($date) >= 0;
	}
	
	public function ContainsRange(DateRange $dateRange)
	{
		return $this->_begin->Compare($dateRange->_begin) <= 0 && $this->_end->Compare($dateRange->_end) >= 0;
	}
}
?>