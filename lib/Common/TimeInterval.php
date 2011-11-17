<?php
class TimeInterval
{
	/**
	 * @var DateDiff
	 */
	private $interval = null;
	
	/**
	 * @param int $seconds
	 */
	public function __construct($seconds)
	{
		$this->interval = null;
		
		if (!empty($seconds))
		{
			$this->interval = new DateDiff($seconds);
		}
	}

	/**
	 * @static
	 * @param string|int $interval string interval in format: #d#h#m ie: 22d4h12m or total seconds
	 * @return DateDiff
	 */
	public static function Parse($interval)
	{
		if (empty($interval))
		{
			return new TimeInterval(0);
		}

		if (!is_numeric($interval))
		{
			$seconds = DateDiff::FromTimeString($interval)->TotalSeconds();
		}
		else
		{
			$seconds = $interval;
		}

		return new TimeInterval($seconds);
	}

	/**
	 * @return int
	 */
	public function Days()
	{
		return $this->Interval()->Days();
	}

	/**
	 * @return int
	 */
	public function Hours()
	{
		return $this->Interval()->Hours();
	}

	/**
	 * @return int
	 */
	public function Minutes()
	{
		return $this->Interval()->Minutes();
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

	/**
	 * @return null|int
	 */
	public function ToDatabase()
	{
		if ($this->interval != null && !$this->interval->IsNull())
		{
			return $this->interval->TotalSeconds();
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		if ($this->interval != null)
		{
			return $this->interval->__toString();
		}
		
		return '';
	}
}
?>