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
		if ($timezone == null) {
			$this->timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
		}
	}

	/**
	 * Creates a new Date object with the given year, month, day, and optional $hour, $minute, $secord and $timezone
	 * @return Date
	 */
	public static function Create($year, $month, $day, $hour = 0, $minute = 0, $second = 0, $timezone = null)
	{
		if ($month > 12)
		{
			$yearOffset = floor($month/12);
			$year = $year + $yearOffset;
			$month = $month - ($yearOffset * 12);
		}
		
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
		if (isset(self::$_Now)) {
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
		if ($this->Timezone() == $timezone) {
			return $this->Copy();
		}

		$date = new DateTime($this->timestring, new DateTimeZone($this->timezone));

		$date->setTimezone(new DateTimeZone($timezone));
		$adjustedDate = $date->format(Date::SHORT_FORMAT);

		return new Date($adjustedDate, $timezone);
	}

	/**
	 * @return Date
	 */
	public function Copy()
	{
		return new Date($this->timestring, $this->Timezone());
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
		if (empty($databaseValue)) {
			return NullDate::Instance();
		}
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
		if ($date2->Timezone() != $this->Timezone()) {
			$date2 = $date->ToTimezone($this->timezone);
		}

		if ($this->Timestamp() < $date2->Timestamp()) {
			return -1;
		}
		else if ($this->Timestamp() > $date2->Timestamp()) {
			return 1;
		}

		return 0;
	}

	/**
	 * Compares the time component of this date to the one passed in
	 * Returns:
	 * -1 if this time is less than the passed in time
	 * 0 if the times are equal
	 * 1 if this times is greater than the passed in times
	 * @param Date $date
	 * @return int comparison result
	 */
	public function CompareTime(Date $date)
	{
		$date2 = $date;
		if ($date2->Timezone() != $this->Timezone()) {
			$date2 = $date->ToTimezone($this->timezone);
		}

		$hourCompare = ($this->Hour() - $date2->Hour());
		$minuteCompare = ($this->Minute() - $date2->Minute());
		$secondCompare = ($this->Second() - $date2->Second());

		if ($hourCompare < 0 || ($hourCompare == 0 && $minuteCompare < 0) || ($hourCompare == 0 && $minuteCompare == 0 && $secondCompare < 0)) {
			return -1;
		}
		else if ($hourCompare > 0 || ($hourCompare == 0 && $minuteCompare > 0) || ($hourCompare == 0 && $minuteCompare == 0 && $secondCompare > 0)) {
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
		if ($date2->Timezone() != $this->Timezone()) {
			$date2 = $date->ToTimezone($this->timezone);
		}

		return ($this->Day() == $date2->Day() && $this->Month() == $date2->Month() && $this->Year() == $date2->Year());
	}

	public function DateCompare(Date $date)
	{
		$date2 = $date;
		if ($date2->Timezone() != $this->Timezone()) {
			$date2 = $date->ToTimezone($this->timezone);
		}

		$d1 = (int)$this->Format('Ymd');
		$d2 = (int)$date2->Format('Ymd');

		if ($d1 > $d2) {
			return 1;
		}
		if ($d1 < $d2) {
			return -1;
		}
		return 0;
	}

	/**
	 * @return bool
	 */
	public function IsMidnight()
	{
		return $this->Hour() == 0 && $this->Minute() == 0 && $this->Second() == 0;
	}

	/**
	 * @param int $days
	 * @return Date
	 */
	public function AddDays($days)
	{
		// can also use DateTime->modify()
		return new Date($this->Format(self::SHORT_FORMAT) . " +" . $days . " days", $this->timezone);
	}

	/**
	 * @param int $months
	 * @return Date
	 */
	public function AddMonths($months)
	{
		return new Date($this->Format(self::SHORT_FORMAT) . " +" . $months . " months", $this->timezone);
	}

	/**
	 * @param Time $time
	 * @return Date
	 */
	public function SetTime(Time $time)
	{
		return Date::Create($this->Year(), $this->Month(), $this->Day(), $time->Hour(), $time->Minute(), $time->Second(), $this->Timezone());
	}

	/**
	 * @param string $time
	 * @return Date
	 */
	public function SetTimeString($time)
	{
		return $this->SetTime(Time::Parse($time, $this->Timezone()));
	}

	/**
	 * @param Date $date
	 * @return DateDiff
	 */
	public function GetDifference(Date $date)
	{
		return DateDiff::BetweenDates($this, $date);
	}

	/**
	 * @param DateDiff $difference
	 * @return Date
	 */
	public function ApplyDifference(DateDiff $difference)
	{
		if ($difference->IsNull())
		{
			return $this->Copy();
		}
		
		$newTimestamp = $this->Timestamp() + $difference->TotalSeconds();
		$dateStr = gmdate(self::SHORT_FORMAT, $newTimestamp);
		$date = new DateTime($dateStr, new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone($this->Timezone()));
			
		return new Date($date->format(self::SHORT_FORMAT), $this->Timezone());
	}

	private function InitializeParts()
	{
		list($date, $time) = explode(' ', $this->Format('w-' . self::SHORT_FORMAT));
		list($weekday, $year, $month, $day) = explode("-", $date);
		list($hour, $minute, $second) = explode(":", $time);

		$this->parts['hours'] = intval($hour);
		$this->parts['minutes'] = intval($minute);
		$this->parts['seconds'] = intval($second);
		$this->parts['mon'] = intval($month);
		$this->parts['mday'] = intval($day);
		$this->parts['year'] = intval($year);
		$this->parts['wday'] = intval($weekday);
	}

	/**
	 * @return int
	 */
	public function Hour()
	{
		return $this->parts['hours'];
	}

	/**
	 * @return int
	 */
	public function Minute()
	{
		return $this->parts['minutes'];
	}

	/**
	 * @return int
	 */
	public function Second()
	{
		return $this->parts['seconds'];
	}

	/**
	 * @return int
	 */
	public function Month()
	{
		return $this->parts['mon'];
	}

	/**
	 * @return int
	 */
	public function Day()
	{
		return $this->parts['mday'];
	}

	/**
	 * @return int
	 */
	public function Year()
	{
		return $this->parts['year'];
	}

	/**
	 * @return int
	 */
	public function Weekday()
	{
		return $this->parts['wday'];
	}

	public function Timezone()
	{
		return $this->timezone;
	}

	/**
	 * Only used for unit testing
	 * @param Date $date
	 */
	public static function _SetNow(Date $date)
	{
		if (is_null($date)) {
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

class NullDate extends Date
{
	/**
	 * @var NullDate
	 */
	private static $date;
	
	public function __construct()
	{
		parent::__construct();
	}


	public static function Instance()
	{
		if (self::$date == null)
		{
			self::$date = new NullDate();
		}

		return self::$date;
	}

	public function Format($format)
	{
		return '';
	}

	public function ToString()
	{
		return '';
	}
}

class DateDiff
{
	/**
	 * @var int
	 */
	private $seconds = 0;

	/**
	 * @param int $seconds
	 */
	public function __construct($seconds)
	{
	    $this->seconds = $seconds;
	}

	/**
	 * @return int
	 */
	public function TotalSeconds()
	{
		return $this->seconds;
	}

	public function Hours()
	{
		$hours = intval(intval($this->seconds) / 3600);
		return $hours;
	}

	public function Minutes()
	{
		$minutes = intval(($this->seconds / 60) % 60);
		return $minutes;
	}

	/**
	 * @static
	 * @param Date $date1
	 * @param Date $date2
	 * @return DateDiff
	 */
	public static function BetweenDates(Date $date1, Date $date2)
	{
		if ($date1->Equals($date2))
		{
			return DateDiff::Null();
		}
		
		$compareDate = $date2;
		if ($date1->Timezone() != $date2->Timezone())
		{
			$compareDate = $date2->ToTimezone($date1->Timezone());
		}

		return new DateDiff($compareDate->Timestamp() - $date1->Timestamp());
	}

	/**
	 * @static
	 * @param $timeString
	 * @return DateDiff
	 */
	public static function FromTimeString($timeString)
	{
		$parts = explode(':', $timeString);

		$hour = $parts[0];
		$minute = $parts[1];
		$second = 0;

		if (count($parts) > 2)
		{
			$second = $parts[2];
		}

		return new DateDiff(($hour * 60 * 60) + ($minute * 60) + $second);
	}

	/**
	 * @static
	 * @return DateDiff
	 */
	public static function Null()
	{
		return new DateDiff(0);
	}

	/**
	 * @return bool
	 */
	public function IsNull()
	{
		return $this->seconds == 0;
	}

	/**
	 * @param DateDiff $diff
	 * @return DateDiff
	 */
	public function Add(DateDiff $diff)
	{
		return new DateDiff($this->seconds + $diff->seconds);
	}

	/**
	 * @param DateDiff $diff
	 * @return bool
	 */
	public function GreaterThan(DateDiff $diff)
	{
		return $this->seconds > $diff->seconds;
	}
}
?>