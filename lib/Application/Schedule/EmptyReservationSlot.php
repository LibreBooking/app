<?php

class EmptyReservationSlot implements IReservationSlot
{
	/**
	 * @var Date
	 */
	protected $_begin;
	
	/**
	 * @var Date
	 */
	protected $_end;
	
	/**
	 * @var Date
	 */
	protected $_date;
	
	/**
	 * @var $_isReservable
	 */
	protected $_isReservable;
	
	/**
	 * @var int
	 */
	protected $_periodSpan;
	
	public function __construct(Date $begin, Date $end, Date $displayDate, $isReservable)
	{
		$this->_begin = $begin;
		$this->_end = $end;
		$this->_date = $displayDate;
		$this->_isReservable = $isReservable;
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_begin->GetTime();
	}
	
	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->_end->GetTime(0);	
	}
	
	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->_date;	
	}
	
	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return 1;
	}
	
	public function Label()
	{
		return '&nbsp;';
	}
	
	public function IsReservable()
	{
		return $this->_isReservable;
	}
	
	public function IsReserved()
	{
		return false;
	}
	
	public function IsPastDate(Date $date)
	{
		return $this->_date->SetTime($this->Begin())->LessThan($date);
	}
	
	public function ToTimezone($timezone)
	{
		return new EmptyReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->End()->ToTimezone($timezone));
	}
}

?>