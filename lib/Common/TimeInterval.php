<?php
class TimeInterval
{
	/**
	 * @var string
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
			$this->interval = DateDiff::FromTimeString($timeString);
//			$timeParts = explode(':', $timeString);
//
//			if (count($timeParts) > 1)
//			{
//				$h = $timeParts[0];
//				$m = $timeParts[1];
//
//				$this->interval = sprintf('%s:%s', $h, $m);
//				//$intervalSpec = sprintf("PT%sH%sM", $h, $m);
//				//$this->interval = new DateInterval($intervalSpec);
//			}
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
			return sprintf('%s:%s', $this->interval->Hours(), $this->interval->Minutes());
		}
		
		return '';
	}
}
?>