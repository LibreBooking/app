<?php

class ScheduleReservation
{
	private $_reservationId;
	private $_startDate;
	private $_endDate;
	private $_startTime;
	private $_endTime;
	private $_reservationType;
	private $_summary;
	private $_parentId;
	private $_resourceId;
	private $_userId;
	private $_firstName;
	private $_lastName;
	
	public function __construct($reservationId,
							$startDate,
							$endDate,
							$startTime,
							$endTime,
							$reservationType,
							$summary,
							$parentId,
							$resourceId,
							$userId,
							$firstName,
							$lastName)
	{
		$this->SetReservationId($reservationId);
		$this->SetStartDate($startDate);
		$this->SetEndDate($endDate);
		$this->SetStartTime($startTime);
		$this->SetEndTime($endTime);
		$this->SetReservationType($reservationType);
		$this->SetSummary($summary);
		$this->SetParentId($parentId);
		$this->SetResourceId($resourceId);
		$this->SetUserId($userId);
		$this->SetFirstName($firstName);
		$this->SetLastName($lastName);
	}
	
	public function GetReservationId()
	{
		return $this->_reservationId;
	}
	
	public function SetReservationId($value)
	{
		$this->_reservationId = $value;
	}
	
	public function GetStartDate()
	{
		return $this->_startDate;
	}
	
	public function SetStartDate($value)
	{
		$this->_startDate = $value;
	}
	
	public function GetEndDate()
	{
		return $this->_endDate;
	}
	
	public function SetEndDate($value)
	{
		$this->_endDate = $value;
	}
	
	public function GetStartTime()
	{
		return $this->_startTime;
	}
	
	public function SetStartTime($value)
	{
		$this->_startTime = $value;
	}
	
	public function GetEndTime()
	{
		return $this->_endTime;
	}
	
	public function SetEndTime($value)
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
}
?>