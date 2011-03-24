<?php

class ReservationSlot implements IReservationSlot
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
	 * @var int
	 */
	protected $_periodSpan;
	
	/**
	 * @var ScheduleReservation
	 */
	private $_reservation;
	
	public function __construct(Date $begin, Date $end, Date $displayDate, $periodSpan, $reservation)
	{
		$this->_reservation = $reservation;
		$this->_begin = $begin;
		$this->_date = $displayDate;
		$this->_end = $end;
		$this->_periodSpan = $periodSpan;
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_begin->GetTime();
	}
	
	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->_begin;
	}
	
	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->_end->GetTime();	
	}
	
	/**
	 * @return Date
	 */
	public function EndDate()
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
		return new ReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->EndDate()->ToTimezone($timezone), $this->PeriodSpan());
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