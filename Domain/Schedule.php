<?php
interface ISchedule
{
	public function GetId();
	public function GetName();
	public function GetIsDefault();
	public function GetWeekdayStart();
	public function GetDaysVisible();
}

class Schedule implements ISchedule
{	
	private $_id;
	private $_name;
	private $_isDefault;
	private $_weekdayStart;
	private $_daysVisible;
	
	public function __construct(
		$id, 
		$name, 
		$isDefault, 
		$weekdayStart, 
		$daysVisible)
	{
		$this->_id = $id;
		$this->_name = $name;
		$this->_isDefault = $isDefault;
		$this->_weekdayStart = $weekdayStart;
		$this->_daysVisible = $daysVisible;
	}
	
	public function GetId()
	{
		return $this->_id;
	}
	
	public function SetId($value)
	{
		$this->_id = $value;
	}
	
	public function GetName()
	{
		return $this->_name;
	}
	
	public function SetName($value)
	{
		$this->_name = $value;
	}
	
	public function GetIsDefault()
	{
		return $this->_isDefault;
	}
	
	public function SetIsDefault($value)
	{
		$this->_isDefault = $value;
	}
	
	public function GetWeekdayStart()
	{
		return $this->_weekdayStart;
	}
	
	public function SetWeekdayStart($value)
	{
		$this->_weekdayStart = $value;
	}
	
	public function GetDaysVisible()
	{
		return $this->_daysVisible;
	}
	
	public function SetDaysVisible($value)
	{
		$this->_daysVisible = $value;
	}
	
}
?>