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
	
	protected $_beginDisplayTime;
	protected $_endDisplayTime;
	
	public function __construct(Date $begin, Date $end, Date $displayDate, $isReservable)
	{
		$this->_begin = $begin;
		$this->_end = $end;
		$this->_date = $displayDate;
		$this->_isReservable = $isReservable;
		
		$this->_beginDisplayTime = $this->_begin->GetTime();
		if (!$this->_begin->DateEquals($displayDate))
		{
			$this->_beginDisplayTime = $displayDate->GetDate()->GetTime();
		}
		
		$this->_endDisplayTime = $this->_end->GetTime();
		if (!$this->_end->DateEquals($displayDate))
		{
			$this->_endDisplayTime = $displayDate->GetDate()->GetTime();
		}
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_beginDisplayTime;
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
		return $this->_endDisplayTime;	
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

	public function IsPending()
	{
		return false;
	}
	
	public function IsPastDate(Date $date)
	{
		return $this->_date->SetTime($this->Begin())->LessThan($date);
	}
	
	public function ToTimezone($timezone)
	{
		return new EmptyReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->End()->ToTimezone($timezone), $this->Date(), $this->_isReservable);
	}

	public function IsOwnedBy(UserSession $session)
	{
		return false;
	}
}

?>