<?php
require_once('namespace.php');

class Date
{
	private $timestamp;
	private $parts;
	
	public function __construct($timestamp)
	{
		$this->timestamp = $timestamp;
		$this->parts = getdate($timestamp);	
	}
	
	public static function Now()
	{
		return new Date(mktime());
	}
	
	public function Format($format)
	{
		return date($format, $this->timestamp);
	}
	
	public function DateTime()
	{
		return $this->timestamp;
	}
	
	public function AddDays($days)
	{		
		$timestamp = mktime(
							$this->Hour(), 
							$this->Minute(), 
							$this->Second(), 
							$this->Month(), 
							$this->Day() + $days, 
							$this->Year()
							);
			
		return new Date($timestamp);
	}
	
	
	public function Hour()
	{
		return $this->parts['hours'];		
	}
	
	public function Minute()
	{
		return $this->parts['minutes'];
	}
	
	public function Second()
	{
		return $this->parts['seconds'];
	}
	
	public function Month()
	{
		return $this->parts['mon'];
	}
	
	public function Day()
	{
		return $this->parts['mday'];
	}
	
	public function Year()
	{
		return $this->parts['year'];
	}
	
	public function DayOfYear()
	{
		return $this->parts['yday'];
	}
	
	public function DayOfWeek()
	{
		return $this->parts['wday'];
	}
}
?>