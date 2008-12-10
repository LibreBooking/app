<?php

class ScheduleReservation
{
	private $_reservationId;
	
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
	
	const SERVER_TIMEZONE = 'GMT';
	
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
	
	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		return $this->_startDate;
	}
	
	/**
	 * @param string $value
	 */
	public function SetStartDate($value)
	{
		$this->_startDate = Date::Parse($value, ScheduleReservation::SERVER_TIMEZONE);
	}
	
	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		return $this->_endDate;
	}
	
	/**
	 * @param string $value
	 */
	public function SetEndDate($value)
	{
		$this->_endDate = Date::Parse($value, ScheduleReservation::SERVER_TIMEZONE);
	}
	
	/**
	 * @return Time
	 */
	public function GetStartTime()
	{
		return $this->_startTime;
	}
	
	/**
	 * @param string $value
	 */
	public function SetStartTime($value)
	{
		$this->_startTime = Time::Parse($value, ScheduleReservation::SERVER_TIMEZONE);
	}
	
	/**
	 * @return Time
	 */
	public function GetEndTime()
	{
		return $this->_endTime;
	}
	
	/**
	 * @param string $value
	 */
	public function SetEndTime($value)
	{
		$this->_endTime = Time::Parse($value, ScheduleReservation::SERVER_TIMEZONE);
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