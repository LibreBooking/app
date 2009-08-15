<?php
class Date
{
	/**
	 * @var DateTime
	 */
	private $date;
	private $parts;
	private $timezone;
    private $timestamp;
    
    const SHORT_FORMAT = "Y-m-d H:i:s";
	
	// Only used for testing
	private static $_Now = null;
	
	/**
	 * Creates a Date with the provided timestamp and timezone
	 * Defaults to current time
	 * Defaults to server.timezone configuration setting
	 *
	 * @param int $timestamp
	 * @param string $timezone
	 */
	public function __construct($timestamp = null, $timezone = null)
	{
        $this->InitializeTimestamp($timestamp);
        $this->InitializeTimezone($timezone);
                       
		$this->date = new DateTime(date(Date::SHORT_FORMAT, $this->timestamp), new DateTimeZone($this->timezone));
		$this->parts = getdate($timestamp); //date_parse($this->date->format(DATE_W3C));	
	}
    
    private function InitializeTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;        
        if ($timestamp == null)
        {
            $this->timestamp = time();
        }
    }
    
    private function InitializeTimezone($timezone)
    {
        $this->timezone = $timezone;
        if ($timezone == null)
        {
            $this->timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
        }     
    }
	
	/**
	* Creates a new Date object with the given year, month, day, and optional $hour, $minute, $secord and $timezone
	* @return Date
	*/
	public static function Create($year, $month, $day, $hour = 0, $minute = 0, $second = 0, $timezone = null)
	{
		return new Date(mktime(intVal($hour), intVal($minute), intVal($second), intVal($month), intVal($day), intVal($year)), $timezone);
	}
	
	/**
	* Creates a new Date object from the given string and $timezone
	* @return Date
	*/
	public static function Parse($dateString, $timezone = null)
	{
		$parts = getdate(strtotime($dateString));
    	
    	return Date::Create($parts['year'], $parts['mon'], $parts['mday'], $parts['hours'], $parts['minutes'], $parts['seconds'], $timezone);
	}
	
	/**
	 * Returns a Date object representing the current GMT date/time
	 *
	 * @return Date
	 */
	public static function Now()
	{
		if (isset(self::$_Now))
		{
			return self::$_Now;
		}
		return new Date(mktime());
	}
	
	/**
	 * Formats the Date with the provided format
	 *
	 * @param string $format
	 * @return string
	 */
	public function Format($format)
	{
		return $this->date->format($format);
	}
	
	/**
	 * Returns the Date adjusted into the provided timezone
	 *
	 * @param string $timezone
	 * @return Date
	 */
	public function ToTimezone($timezone)
	{
		if ($this->Timezone() == $timezone)
		{
			return new Date($this->Timestamp(), $this->Timezone());
		}
		
        $date = new DateTime(date(Date::SHORT_FORMAT, $this->timestamp), new DateTimeZone($this->timezone));
                
        $date->setTimezone(new DateTimeZone($timezone));
        $adjustedDate = strtotime($date->format(Date::SHORT_FORMAT));

        return new Date($adjustedDate, $timezone);
	}
	    
    /**
     * Returns the Date adjusted into UTC
     *
     * @return Date
     */
    public function ToUtc()
    {
        return $this->ToTimezone('UTC');
    }
	
	/**
	 * Formats the Date into a format that is accepted by the database
	 *
	 * @return string
	 */
	public function ToDatabase()
	{
		return $this->ToUtc()->Format('Y-m-d H:i:s');
	}
	
	/**
	 * Returns the current Date as a timestamp
	 *
	 * @return int
	 */
	public function Timestamp()
	{
		return mktime(
					$this->Hour(), 
					$this->Minute(), 
					$this->Second(), 
					$this->Month(), 
					$this->Day(), 
					$this->Year()
					);
	}
	
	/**
	 * Returns the Time part of the Date
	 * 
	 * @return Time
	 */
	public function GetTime()
	{
		return new Time($this->Hour(), $this->Minute(), $this->Second(), $this->Timezone());
	}
	
	/**
	 * Returns the Date only part of the date.  Hours, Minutes and Seconds will be 0
	 * 
	 * @return Date
	 */
	public function GetDate()
	{
		return Date::Create($this->Year(), $this->Month(), $this->Day(), 0, 0, 0, $this->Timezone());
	}
	
	/**
	 * Compares this date to the one passed in
	 * Returns:
	 * -1 if this date is less than the passed in date
	 * 0 if the dates are equal
	 * 1 if this date is greater than the passed in date
	 * @param Date $date
	 * @return int comparison result
	 */
	public function Compare(Date $date)
	{
		$date2 = $date;
		if ($date2->Timezone() != $this->Timezone())
		{
			$date2 = $date->ToTimezone($this->timezone);
		}
		
		if ($this->Timestamp() < $date2->Timestamp())
		{
			return -1;
		}
		else if ($this->Timestamp() > $date2->Timestamp())
		{
			return 1;
		}
		
		return 0;
	}
	
	/**
	 * Compare the 2 dates
	 *
	 * @param Date $date
	 * @return bool
	 */
	public function Equals(Date $date)
	{
		return $this->Compare($date) == 0;
	}
	
	/**
	 * @param Date $date
	 * @return bool
	 */
	public function DateEquals(Date $date)
	{
		$date2 = $date;
		if ($date2->Timezone() != $this->Timezone())
		{
			$date2 = $date->ToTimezone($this->timezone);
		}
		
		return ($this->Day() == $date2->Day() && $this->Month() == $date2->Month() && $this->Year() == $date2->Year());
	}
	
	public function DateCompare(Date $date)
	{
		$date2 = $date;
		if ($date2->Timezone() != $this->Timezone())
		{
			$date2 = $date->ToTimezone($this->timezone);
		}
		
		$d1 = (int)$this->Format('Ymd');
		$d2 = (int)$date2->Format('Ymd');
		
		if ($d1 > $d2)
		{
			return 1;
		}
		if ($d1 < $d2)
		{
			return -1;
		}
		return 0;
	}
	
	/**
	 * @param int $days
	 * @return Date
	 */
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
			
		return new Date($timestamp, $this->timezone);
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
	
	public function Timezone()
	{
		return $this->timezone;
	}
	
	public function Weekday()
	{
		return $this->parts['wday'];
	}
	
	/**
	 * Only used for unit testing
	 */
	public function _SetNow($date)
	{
		if (is_null($date))
		{
			self::$_Now = null;
		}
		else
		{
			self::$_Now = $date;
		}
	}
	
	public function ToString()
	{
		return $this->Format('Y-m-d H:i:s') . ' ' . $this->timezone;
	}
//	
//	public function DayOfYear()
//	{
//		return $this->parts['yday'];
//	}
//	
//	public function DayOfWeek()
//	{
//		return $this->parts['wday'];
//	}
}
?>