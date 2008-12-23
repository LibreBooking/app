<?php
class SchedulePeriod
{
	/**
	 * @var Time
	 */
	protected $_begin;
	
	/**
	 * @var Time
	 */
	protected $_end;
	
	protected $_label;
	
	public function __construct(Time $begin, Time $end, $label = null)
	{
		$this->_begin = $begin;
		$this->_end = $end;
		$this->_label = $label;
	}
	
	/**
	 * @return Time beginning time for this period
	 */
	public function Begin()
	{
		return $this->_begin;
	}
	
	/**
	 * @return Time ending time for this period
	 */
	public function End()
	{
		return $this->_end;
	}
	
	public function IsReservable()
	{
		return true;
	}
	
	public function ToUtc()
	{
		return new SchedulePeriod($this->_begin->ToUtc(), $this->_end->ToUtc(), $this->_label);	
	}
	
	public function ToTimezone($timezone)
	{
		return new SchedulePeriod($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone), $this->_label);	
	}
}

class NonSchedulePeriod extends SchedulePeriod
{
	public function IsReservable()
	{
		return false;
	}
	
	public function ToUtc()
	{
		return new NonSchedulePeriod($this->_begin->ToUtc(), $this->_end->ToUtc(), $this->_label);
	}
	
	public function ToTimezone($timezone)
	{
		return new NonSchedulePeriod($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone), $this->_label);
	}
}
?>