<?php

class ScheduleReservation
{
	private $_reservationId;
	const SERVER_TIMEZONE = 'UTC';
		
	/**
	 * @var Date
	 */
	private $_startDate;
	
	/**
	 * @var Date
	 */
	private $_endDate;
	
	/**
	 * @var Time
	 */
	private $_startTime;
	
	/**
	 * @var Time
	 */
	private $_endTime;
	private $_reservationType;
	private $_summary;
	private $_parentId;
	private $_resourceId;
	private $_userId;
	private $_firstName;
	private $_lastName;
	private $_referenceNumber;
	
	public function __construct($reservationId,
							Date $startDate,
							Date $endDate,
							$reservationType,
							$summary,
							$parentId,
							$resourceId,
							$userId,
							$firstName,
							$lastName,
							$referenceNumber)
	{
		$this->SetReservationId($reservationId);
		$this->SetStartDate($startDate);
		$this->SetEndDate($endDate);
		$this->SetStartTime($startDate->GetTime());
		$this->SetEndTime($endDate->GetTime());
		$this->SetReservationType($reservationType);
		$this->SetSummary($summary);
		$this->SetParentId($parentId);
		$this->SetResourceId($resourceId);
		$this->SetUserId($userId);
		$this->SetFirstName($firstName);
		$this->SetLastName($lastName);
		$this->SetReferenceNumber($referenceNumber);
	}
	
	public function GetReservationId()
	{
		return $this->_reservationId;
	}
	
	public function SetReservationId($value)
	{
		$this->_reservationId = $value;
	}
	
	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		return $this->_startDate;
	}
	
	/**
	 * @param Date $value
	 */
	public function SetStartDate(Date $value)
	{
		$this->_startDate = $value;
		$this->_startTime = $value->GetTime();
	}
	
	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		return $this->_endDate;
	}
	
	/**
	 * @param Date $value
	 */
	public function SetEndDate(Date $value)
	{
		$this->_endDate = $value;
		$this->_endTime = $value->GetTime();
	}
	
	/**
	 * @return Time
	 */
	public function GetStartTime()
	{
		return $this->_startTime;
	}
	
	/**
	 * @param Time $value
	 */
	public function SetStartTime(Time $value)
	{
		$this->_startTime = $value;
	}
	
	/**
	 * @return Time
	 */
	public function GetEndTime()
	{
		return $this->_endTime;
	}
	
	/**
	 * @param Time $value
	 */
	public function SetEndTime(Time $value)
	{
		$this->_endTime = $value;
	}
	
	public function GetReservationType()
	{
		return $this->_reservationType;
	}
	
	public function SetReservationType($value)
	{
		$this->_reservationType = $value;
	}
	
	public function GetSummary()
	{
		return $this->_summary;
	}
	
	public function SetSummary($value)
	{
		$this->_summary = $value;
	}
	
	public function GetParentId()
	{
		return $this->_parentId;
	}
	
	public function SetParentId($value)
	{
		$this->_parentId = $value;
	}
	
	public function GetResourceId()
	{
		return $this->_resourceId;
	}
	
	public function SetResourceId($value)
	{
		$this->_resourceId = $value;
	}
	
	public function GetUserId()
	{
		return $this->_userId;
	}
	
	public function SetUserId($value)
	{
		$this->_userId = $value;
	}
	
	public function GetFirstName()
	{
		return $this->_firstName;
	}
	
	public function SetFirstName($value)
	{
		$this->_firstName = $value;
	}
	
	public function GetLastName()
	{
		return $this->_lastName;
	}
	
	public function SetLastName($value)
	{
		$this->_lastName = $value;
	}
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->_referenceNumber = $referenceNumber;
	}
	
	public function GetReferenceNumber()
	{
		return $this->_referenceNumber;
	}
	
	public function OccursOn(Date $date)
	{
		$timezone = $date->Timezone();
		$beginMidnight = $this->_startDate->ToTimezone($timezone)->GetDate();
		
		if ($this->_endDate->ToTimezone($timezone)->IsMidnight())
		{
			$endMidnight = $this->_endDate;
		}
		else
		{
			$endMidnight = $this->_endDate->ToTimezone($timezone)->GetDate()->AddDays(1);
		}
		
		return ($beginMidnight->Compare($date) <= 0 && 
				$endMidnight->Compare($date) > 0);
	}
}
?>