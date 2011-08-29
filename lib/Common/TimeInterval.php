<?php
class TimeInterval
{
	/**
	 * @var string
	 */
	private $interval = null;
	
	/**
	 * @param string $timeString in format hh:mm (seconds are ignored)
	 */
	public function __construct($timeString)
	{
		$this->interval = null;
		
		if (!empty($timeString))
		{
			$this->interval = DateDiff::FromTimeString($timeString);
		}
	}

	/**
	 * @return DateDiff
	 */
	public function Interval()
	{
		if ($this->interval != null)
		{
			return $this->interval;
		}

		return DateDiff::Null();
	}
	
	public function ToDatabase()
	{
		return $this->__toString();
	}
	
	public function __toString()
	{
		if ($this->interval != null)
		{
			return sprintf('%02d:%02d', $this->interval->Hours(), $this->interval->Minutes());
		}
		
		return null;
	}
}
?>