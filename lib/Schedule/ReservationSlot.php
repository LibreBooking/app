<?php

class ReservationSlot implements IReservationSlot
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
	
	/**
	 * @var ScheduleReservation
	 */
	private $_reservation;
	
	public function __construct(Time $begin, Time $end, $periodSpan)
	{
		//$this->_reservation = $reservation;
		//$reservation->GetStartTime()->ToTimezone;
		$this->_begin = $begin;
		$this->_end = $end;
		$this->_periodSpan = $periodSpan;
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
		return $this->_periodSpan;
	}
	
	public function ToTimezone($timezone)
	{
		return new ReservationSlot($this->Begin()->ToTimezone($timezone), $this->End()->ToTimezone($timezone), $this->PeriodSpan());
	}
}

?>