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
    private $timestring;
    
    const SHORT_FORMAT = "Y-m-d H:i:s";
	
	// Only used for testing
	private static $_Now = null;
	
	/**
	 * Creates a Date with the provided timestamp and timezone
	 * Defaults to current time
	 * Defaults to server.timezone configuration setting
	 *
	 * @param string $timestring
	 * @param string $timezone
	 */
	public function __construct($timestring = null, $timezone = null)
	{
        $this->InitializeTimezone($timezone);
                       
		$this->date = new DateTime($timestring, new DateTimeZone($this->timezone));
		$this->timestring = $this->date->format(self::SHORT_FORMAT); 
		$this->timestamp = $this->date->format('U');
		$this->InitializeParts();
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
		return new Date(sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, $second), $timezone);
	}
	
	/**
	* Creates a new Date object from the given string and $timezone
	* @return Date
	*/
	public static function Parse($dateString, $timezone = null)
	{
		return new Date($dateString, $timezone);
	}
	
	/**
	 * Returns a Date object representing the current date/time in the server's timezone
	 *
	 * @return Date
	 */
	public static function Now()
	{
		if (isset(self::$_Now))
		{
			return self::$_Now;
		}

		return new Date('now');
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
			return new Date($this->timestring, $this->Timezone());
		}
		
        $date = new DateTime($this->timestring, new DateTimeZone($this->timezone));
                
        $date->setTimezone(new DateTimeZone($timezone));
        $adjustedDate = $date->format(Date::SHORT_FORMAT);

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
	 * @param string $databaseValue
	 * @return Date
	 */
	public static function FromDatabase($databaseValue)
	{
		return Date::Parse($databaseValue, 'UTC');
	}
	
	/**
	 * Returns the current Date as a timestamp
	 *
	 * @return int
	 */
	public function Timestamp()
	{
		return $this->timestamp;
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
	 * Compares this date to the one passed in
	 * @param Date $end
	 * @return bool if the current object is greater than the one passed in
	 */
	public function GreaterThan(Date $end)
	{
		return $this->Compare($end) > 0;
	}
	
	/**
	 * Compares this date to the one passed in
	 * @param Date $end
	 * @return bool if the current object is less than the one passed in
	 */
	public function LessThan(Date $end)
	{
		return $this->Compare($end) < 0;
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
		// can also use DateTime->modify()
		return new Date($this->Format(self::SHORT_FORMAT) . " +$days days", $this->timezone);
	}	
	
    private function InitializeParts()
    {
    	list($date, $time) = explode(' ', $this->Format('w-' . self::SHORT_FORMAT));
    	list($weekday, $year, $month, $day) = explode("-", $date);
    	list($hour, $minute, $second) = explode(":", $time);
    	
    	$this->parts['hours'] = $hour;
    	$this->parts['minutes'] = $minute;
    	$this->parts['seconds'] = $second;
    	$this->parts['mon'] = $month;
    	$this->parts['mday'] = $day;
    	$this->parts['year'] = $year;
    	$this->parts['wday'] = $weekday;
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
	 * @param Date $date
	 */
	public static function _SetNow(Date $date)
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
	
	/**
	 * Only used for unit testing
	 */
	public static function _ResetNow()
	{
		self::$_Now = null;
	}
	
	public function ToString()
	{
		return $this->Format('Y-m-d H:i:s') . ' ' . $this->timezone;
	}
	
	public function __toString() 
	{
      return $this->ToString();
  	}
}
?>