<?php
interface ISchedule
{
	public function GetId();
	public function GetName();
	public function GetIsDefault();
	public function GetWeekdayStart();
	public function GetDaysVisible();
	public function GetTimezone();
	public function GetLayoutId();
}

class Schedule implements ISchedule
{	
	private $_id;
	private $_name;
	private $_isDefault;
	private $_weekdayStart;
	private $_daysVisible;
	private $_timezone;
	private $_layoutId;
	
	public function __construct(
		$id, 
		$name, 
		$isDefault, 
		$weekdayStart, 
		$daysVisible,
		$timezone = null,
		$layoutId = null)
	{
		$this->_id = $id;
		$this->_name = $name;
		$this->_isDefault = $isDefault;
		$this->_weekdayStart = $weekdayStart;
		$this->_daysVisible = $daysVisible;
		$this->_timezone = $timezone;
		$this->_layoutId = $layoutId;
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
		
	public function GetTimezone()
	{
		return $this->_timezone;
	}
	
	public function GetLayoutId()
	{
		return $this->_layoutId;
	}
}
?>