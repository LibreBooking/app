<?php
class TimeInterval
{
	/**
	 * @var DateInterval
	 */
	private $interval = null;
	
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
				$s = count($timeParts) > 2 ? $timeParts[2] : 0;
				
				$intervalSpec = sprintf("PT%sH%sM%sS", $h, $m, $s);
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
		
		return new DateInterval("PT0H0M0S");
	}
	
	public function ToDatabase()
	{
		return $this->__toString();
	}
	
	public function __toString()
	{
		if ($this->interval != null)
		{
			return $this->interval->format("%H:%I:%S");
		}
		
		return null;
	}
}
?>