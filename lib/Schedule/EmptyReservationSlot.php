<?php

class EmptyReservationSlot implements IReservationSlot
{
	/**
	 * @var Time
	 */
	protected $_begin;
	
	/**
	 * @var Time
	 */
	protected $_end;
	
	protected $_periodSpan;
	
	public function __construct(Time $begin, Time $end)
	{
		$this->_begin = $begin;
		$this->_end = $end;
		//$this->_periodSpan = $periodSpan;
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_begin;
	}
	
	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->_end;	
	}
	
	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return 1;
	}
	
	public function ToTimezone($timezone)
	{
		return new EmptyReservationSlot($this->Begin()->ToTimezone($timezone), $this->End()->ToTimezone($timezone));
	}
}

?>