<?php
class TimeInterval
{
	/**
	 * @var DateInterval
	 */
	private $interval = null;
	
	/**
	 * @param string $timeString in format hh:mm (seconds are ignored)
	 * @return unknown_type
	 */
	public function __construct($timeString)
	{
		$this->interval = null;
		
		if (!empty($timeString))
		{
			$timeParts = explode(':', $timeString);
			
			if (count($timeParts) > 1)
			{
				$h = $timeParts[0];
				$m = $timeParts[1];
				
				$intervalSpec = sprintf("PT%sH%sM", $h, $m);
				$this->interval = $interval = new DateInterval($intervalSpec);
			}
		}
	}
	
	public function Interval()
	{
		if ($this->interval != null)
		{
			return $this->interval;
		}
		
		return new DateInterval("PT0H0M");
	}
	
	public function ToDatabase()
	{
		return $this->__toString();
	}
	
	public function __toString()
	{
		if ($this->interval != null)
		{
			return $this->interval->format("%H:%I");
		}
		
		return '';
	}
}
?>