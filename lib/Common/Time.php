<?php
class Time
{
	private $_hour;
	private $_minute;
	private $_second;
	public $_date;
	
	public function __construct($hour, $minute, $second = null, $timezone = null)
	{
		$this->_hour = $hour;
		$this->_minute = $minute;
		$this->_second = is_null($second) ? 0 : $second;

		$parts = getdate(strtotime("$this->_hour:$this->_minute:$this->_second"));
		
		$this->_date = new Date("{$parts['year']}-{$parts['mon']}-{$parts['mday']} $this->_hour:$this->_minute:$this->_second", $timezone);
	}
    
	 /**
     * Returns the Time adjusted into the provided timezone
     *
     * @param string $timezone
     * @return Time
     */
    public function ToTimezone($timezone)
    {
    	$date = $this->_date->ToTimezone($timezone);
    	
    	return new Time($date->Hour(), $date->Minute(), $date->Second(), $timezone);
    }
    
    /**
     * Returns the Time adjusted into UTC
     *
     * @return Time
     */
    public function ToUtc()
    {
    	return $this->ToTimezone('UTC');
    }
    
    /**
     * @param string $time
     * @param string $timezone, defaults to server timezone if not provided
     * @return Time
     */
    public static function Parse($time, $timezone = null)
    {
    	$parts = getdate(strtotime($time));
    	
    	return new Time($parts['hours'], $parts['minutes'], $parts['seconds'], $timezone);
    }
	
	public function Hour()
	{
		return $this->_hour;
	}
	
	public function Minute()
	{
		return $this->_minute;
	}
	
	public function Second()
	{
		return $this->_second;
	}
	
	public function Timezone()
	{
		return $this->_date->Timezone();
	}
	
	public function Timestamp()
	{
		return $this->_date->Timestamp();
	}
	
	/**
	 * Compares this time to the one passed in
	 * Returns:
	 * -1 if this time is less than the passed in time
	 * 0 if the times are equal
	 * 1 if this time is greater than the passed in time
	 * @param Time time
	 * @return int comparison result
	 */
	public function Compare(Time $time)
	{
		return $this->_date->Compare($time->_date);
	}
	
	/**
	 * Compares this time to the one passed in
	 * @param Time $time
	 * @return bool if the current object is greater than the one passed in
	 */
	public function GreaterThan(Time $time)
	{
		return $this->_date->Compare($time->_date) > 0;
	}
	
	/**
	 * Compares this time to the one passed in
	 * @param Time $time
	 * @return bool if the current object is less than the one passed in
	 */
	public function LessThan(Time $time)
	{
		return $this->_date->Compare($time->_date) < 0;
	}
	
	/**
	 * Compare the 2 times
	 *
	 * @param Time $time
	 * @return bool
	 */
	public function Equals(Time $time)
	{
		return $this->Compare($time) == 0;
	}
	
	public function ToString()
	{
		return sprintf("%d:%02d:%02d", $this->_hour, $this->_minute, $this->_second);
	}
	
	public function __toString() 
	{
      return $this->ToString();
  	}
}
?>