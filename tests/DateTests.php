<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class DateTests extends PHPUnit_Framework_TestCase
{
	private $tz;
	
	public function setup()
	{
		$this->tz = new DateTimeZone('GMT');
	}
	
	public function testCanGetNow()
	{
		$format = 'd m y H:i:s';
		
		$now = Date::Now();
		$datenow = new DateTime(date(DATE_W3C, time()), $this->tz);
		
		$this->assertEquals($datenow->format($format), $now->Format($format));
	}
	
	public function testCanAddDays()
	{
		$format = 'd m y H:i:s';
		
		$hour = 11;
		$minute = 40;
		$second = 22;
		$month = 3;
		$day = 21;
		$year = 2007;
		
		$rawdate = mktime($hour, $minute, $second, $month, $day, $year);
		
		$now = new Date($rawdate);
		
		$dateString = date(DATE_W3C, mktime($hour, $minute, $second, $month, $day + 20, $year));
		$twentyDays = new DateTime($dateString, $this->tz);
		
		$twentyDaysDate = $now->AddDays(20);
		
		$this->assertEquals($twentyDays->format($format), $twentyDaysDate->Format($format));	
	}
	
	public function testCanGetAsDateTime()
	{
		$rawdate = mktime();
		
		$now = new Date($rawdate);		
		$datenow = new DateTime(date(DATE_W3C, $rawdate), $this->tz);
		
		$parts = date_parse($datenow->format(DATE_W3C));
		
		$exptected = mktime(
					$parts['hour'], 
					$parts['minute'], 
					$parts['second'], 
					$parts['month'], 
					$parts['day'], 
					$parts['year']
					);
		
		$this->assertEquals($exptected, $now->Timestamp());
	}
	
	public function testCanConvertToTimezone()
	{
		$format = 'd m y H:i:s';
		
		$rawdate = mktime();
		$now = new Date($rawdate);
		
		$datetime = new DateTime(date(DATE_W3C, $rawdate), $this->tz);
		$datetime->setTimezone(new DateTimeZone('US/Central'));
		
		$expected = $datetime->format($format);		
		$adjusted = $now->ToTimezone("US/Central");
		
		$this->assertEquals($expected, $adjusted->Format($format));
	}
}
?>