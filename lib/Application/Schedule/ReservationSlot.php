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
	
	/**
	 * @var Date
	 */
	protected $_date;
	
	/**
	 * @var int
	 */
	protected $_periodSpan;
	
	/**
	 * @var ScheduleReservation
	 */
	private $_reservation;
	
	public function __construct(Time $begin, Time $end, Date $date, $periodSpan, $reservation)
	{
		$this->_reservation = $reservation;
		$this->_begin = $begin;
		$this->_date = $date;
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
		return $this->_periodSpan;
	}
	
	public function Label()
	{
		return $this->_reservation->GetFirstName() . ' ' . $this->_reservation->GetLastName();
	}
	
	public function IsReservable()
	{
		return false;
	}
	
	public function IsReserved()
	{
		return true;
	}
	
	public function IsPastDate(Date $date)
	{
		return $this->_date->SetTime($this->Begin())->LessThan($date);
	}
	
	public function ToTimezone($timezone)
	{
		return new ReservationSlot($this->Begin()->ToTimezone($timezone), $this->End()->ToTimezone($timezone), $this->PeriodSpan());
	}
	
	public function Id()
	{ 
		return $this->_reservation->GetReferenceNumber();	
	}
	
	public function IsOwnedBy(UserSession $user)
	{
		return $this->_reservation->GetUserId() == $user->UserId;
	}
	
	public function __toString() 
	{
       return sprintf("Start: %s, End: %s, Span: %s", $this->Begin(), $this->End(), $this->PeriodSpan());
  	}
}

?>