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
		$this->parts = date_parse($this->date->format(DATE_W3C));	
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
		return new Date(mktime($hour, $minute, $second, $month, $day, $year), $timezone);
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
        $date = new DateTime(date(Date::SHORT_FORMAT, $this->timestamp), new DateTimeZone($this->timezone));
                
        $date->setTimezone(new DateTimeZone($timezone));
        $adjustedDate = strtotime($date->format(Date::SHORT_FORMAT));

        return new Date($adjustedDate, $timezone);
	}
    
    /**
     * Returns the Date adjusted into GMT
     *
     * @return Date
     */
    public function Gmt()
    {
        return $this->ToTimezone('GMT');
    }
	
	/**
	 * Formats the Date into a format that is accepted by the database
	 *
	 * @return string
	 */
	public function ToDatabase()
	{
		return $this->Gmt()->Format('Y-m-d H:i:s');
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
		$date2 = $date->ToTimezone($this->timezone);
		
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
		return $this->parts['hour'];		
	}
	
	public function Minute()
	{
		return $this->parts['minute'];
	}
	
	public function Second()
	{
		return $this->parts['second'];
	}
	
	public function Month()
	{
		return $this->parts['month'];
	}
	
	public function Day()
	{
		return $this->parts['day'];
	}
	
	public function Year()
	{
		return $this->parts['year'];
	}
	
	/**
	 * Only used for unit testing
	 */
	public function _SetNow($datetime)
	{
		if (is_null($datetime))
		{
			self::$_Now = null;
		}
		else
		{
			self::$_Now = new Date($datetime);
		}
	}
	
	public function ToString()
	{
		return $this->Format('Y-m-d H:i:s');
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