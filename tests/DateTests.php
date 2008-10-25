<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class DateTests extends TestBase
{
	private $tz;                                     
	
	public function setup()
	{
        parent::setup();  
        
		$this->tz = new DateTimeZone('GMT');
	}
	
	public function testCanGetNow()
	{
		$format = 'd m y H:i:s';
		
		$now = Date::Now();
		$datenow = new DateTime(date(DATE_W3C, time()));
		
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
		$expected = new DateTime($dateString);
		
		$twentyDaysDate = $now->AddDays(20);
		
		$this->assertEquals($expected->format($format), $twentyDaysDate->Format($format));	
	}
	
	public function testCanGetAsDateTime()
	{
		$rawdate = mktime();
		
		$now = new Date($rawdate);		
		$datenow = new DateTime(date(DATE_W3C, $rawdate));
		
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
		
		$datetime = new DateTime(date(Date::SHORT_FORMAT, $rawdate));
		$datetime->setTimezone(new DateTimeZone('US/Eastern'));
		
		$expected = $datetime->format($format);		
		$adjusted = $now->ToTimezone("US/Eastern");
		
		$this->assertEquals($expected, $adjusted->Format($format));
	}
	
	public function testDateGetsAdjustedIntoProvidedTimezone()
	{
		$format = 'd m y H:i:s';
        $tzName = 'US/Eastern';
        $baseTz = new DateTimeZone($tzName);
		
        $rawdate = mktime();
		
        $actual = new Date($rawdate, $tzName);
		
        $datetime = new DateTime(date(Date::SHORT_FORMAT, $rawdate), $baseTz);
        
        $expected = $datetime->format($format);      
        
        $this->assertEquals($expected, $actual->Format($format));    
	}
    
    public function testGmtConvertsDateToGMT()
    {
    	$format = 'd m y H:i:s';
        $rawdate = mktime();
        
        $date = new Date($rawdate);
        
        $datetime = new DateTime(date(Date::SHORT_FORMAT, $rawdate));
        $datetime->setTimezone(new DateTimeZone('GMT'));
        
        $expected = $datetime->format($format);      
        
        $this->assertEquals($expected, $date->Gmt()->Format($format));    
    }
    
    public function testDatePartsAreParsedCorrectly()
    {
        $hour = 11;
        $minute = 40;
        $second = 22;
        $month = 3;
        $day = 21;
        $year = 2007;
        
        $rawdate = mktime($hour, $minute, $second, $month, $day, $year);
        $date = new Date($rawdate);
        
        $this->assertEquals($hour, $date->Hour());
        $this->assertEquals($minute, $date->Minute());
        $this->assertEquals($second, $date->Second());
        $this->assertEquals($month, $date->Month());
        $this->assertEquals($day, $date->Day());
        $this->assertEquals($year, $date->Year());

        
        $adjusted = $date->ToTimezone('US/Eastern');
        
        $this->assertEquals($hour + 1, $adjusted->Hour());
        $this->assertEquals($minute, $adjusted->Minute());
        $this->assertEquals($second, $adjusted->Second());
        $this->assertEquals($month, $adjusted->Month());
        $this->assertEquals($day, $adjusted->Day());
        $this->assertEquals($year, $adjusted->Year());
    }
    
    public function testToDatabaseConvertsToGmtThenFormats()
    {
    	$databaseformat = 'Y-m-d H:i:s';
        $rawdate = mktime();
        
        $date = new Date($rawdate);
        
        $datetime = new DateTime(date(Date::SHORT_FORMAT, $rawdate));
        $datetime->setTimezone(new DateTimeZone('GMT'));
        
        $expected = $datetime->format($databaseformat);      
        
        $this->assertEquals($expected, $date->ToDatabase());    
    }
}
?>