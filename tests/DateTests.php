<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class DateTests extends TestBase
{
	private $tz;
	private $datestring;                                  
	
	public function setup()
	{
        parent::setup();  
        
        $this->datestring = date(DATE_W3C, time());
		$this->tz = new DateTimeZone('UTC');
	}
	
	public function testCanGetNow()
	{
		$format = 'd m y H:i:s';
		
		$now = Date::Now();
		$datenow = new DateTime(date(Date::SHORT_FORMAT, time()));
		
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
		
		$string = "$year-$month-$day $hour:$minute:$second";
		$now = new Date($string);
		
		$expectedTS = mktime($hour, $minute, $second, $month, $day + 20, $year);
		
		$twentyDaysDate = $now->AddDays(20);
		
		$this->assertEquals($expectedTS, $twentyDaysDate->Timestamp());		
	}
	
	public function testCanSubtractDays()
	{
		$format = 'd m y H:i:s';
		
		$hour = 11;
		$minute = 40;
		$second = 22;
		$month = 3;
		$day = 21;
		$year = 2007;
		
		$now = new Date("$year-$month-$day $hour:$minute:$second");
		
		$expectedTS = mktime($hour, $minute, $second, $month, $day -20, $year);
		$twentyDaysDate = $now->AddDays(-20);
		
		$this->assertEquals($expectedTS, $twentyDaysDate->Timestamp());	
	}
	
	public function testCanGetAsDateTime()
	{
		$now = new Date($this->datestring);		
		$datenow = new DateTime($this->datestring);
		
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
		
		$now = new Date($this->datestring);
		
		$datetime = new DateTime($this->datestring);
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
		
        $actual = new Date($this->datestring, $tzName);
		
        $datetime = new DateTime($this->datestring, $baseTz);
        
        $expected = $datetime->format($format);      
        
        $this->assertEquals($expected, $actual->Format($format));    
	}
    
    public function testGmtConvertsDateToGMT()
    {
    	$format = 'd m y H:i:s';
        
        $date = new Date($this->datestring);
        
        $datetime = new DateTime($this->datestring);
        $datetime->setTimezone(new DateTimeZone('UTC'));
        
        $expected = $datetime->format($format);      
        
        $this->assertEquals($expected, $date->ToUtc()->Format($format));    
    }
    
    public function testDatePartsAreParsedCorrectly()
    {
        $hour = 11;
        $minute = 40;
        $second = 22;
        $month = 3;
        $day = 21;
        $year = 2007;
        
        $date = new Date("$year-$month-$day $hour:$minute:$second", 'US/Central');
        
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
        $date = new Date($this->datestring);
        
        $datetime = new DateTime($this->datestring);
        $datetime->setTimezone(new DateTimeZone('UTC'));
        
        $expected = $datetime->format($databaseformat);      
        
        $this->assertEquals($expected, $date->ToDatabase());    
    }
    
    public function testCanCreateTimeInServerTimezone()
    {
    	$hour = 10;
    	$min = 22;
    	$sec = 21;
    	
    	$time = new Time($hour, $min, $sec);
    	
    	$this->assertEquals("$hour:$min:$sec", $time->ToString());
    	$this->assertEquals($hour, $time->Hour());
    	$this->assertEquals($min, $time->Minute());
    	$this->assertEquals($sec, $time->Second());
    	
    	$time = new Time($hour, $min);
    	
    	$this->assertEquals("$hour:$min:00", $time->ToString());
    	$this->assertEquals($hour, $time->Hour());
    	$this->assertEquals($min, $time->Minute());
    	$this->assertEquals(0, $time->Second());
    }
    
    public function testTimeCreatedInEasternCanBeConvertedToCentral()
    {
    	$hour = 10;
    	$min = 10;
    	$sec = 10;
    	
    	$time = new Time($hour, $min, $sec, 'US/Eastern');
    	$converted = $time->ToTimezone('US/Central');
    	
    	$this->assertEquals($hour - 1, $converted->Hour());
    	$this->assertEquals($min, $converted->Minute());
    	$this->assertEquals($sec, $converted->Second());
    	
    	$time = new Time(0, $min, $sec, 'US/Eastern');
    	$converted = $time->ToTimezone('US/Central');
    	$this->assertEquals(23, $converted->Hour());
    	
    	$time = new Time(1, $min, $sec, 'US/Eastern');
    	$converted = $time->ToTimezone('US/Central');
    	$this->assertEquals(0, $converted->Hour());
    }
    
    public function testCanParseTimeFromString()
    {
    	$time = Time::Parse('10:11:12', 'UTC');
    	
    	$this->assertEquals(10, $time->Hour());
    	$this->assertEquals(11, $time->Minute());
    	$this->assertEquals(12, $time->Second());
    	$this->assertEquals('UTC', $time->Timezone());
    	
    	$time = Time::Parse('13:11:12', 'UTC');
    	
    	$this->assertEquals(13, $time->Hour());
    	$this->assertEquals(11, $time->Minute());
    	$this->assertEquals(12, $time->Second());
    	$this->assertEquals('UTC', $time->Timezone());
    	
    	$time = Time::Parse('10:11:12 PM', 'UTC');
    	
    	$this->assertEquals(22, $time->Hour());
    	$this->assertEquals(11, $time->Minute());
    	$this->assertEquals(12, $time->Second());
    	$this->assertEquals('UTC', $time->Timezone());
    	
    	$time = Time::Parse('10:11:12 AM', 'UTC');
    	
    	$this->assertEquals(10, $time->Hour());
    	$this->assertEquals(11, $time->Minute());
    	$this->assertEquals(12, $time->Second());
    	$this->assertEquals('UTC', $time->Timezone());
    	
    	$time = Time::Parse('10:11 AM', 'UTC');
    	
    	$this->assertEquals(10, $time->Hour());
    	$this->assertEquals(11, $time->Minute());
    	$this->assertEquals(00, $time->Second());
    	$this->assertEquals('UTC', $time->Timezone());
    }
    
    public function testTimesCanBeCompared()
    {
    	$early = Time::Parse('10:11');
    	$late = Time::Parse('12:11');
    	
    	$this->assertEquals(-1, $early->Compare($late));
    	$this->assertEquals(1, $late->Compare($early));
    	
    	$early = Time::Parse('10:11', 'CST');
    	$late = Time::Parse('10:11', 'PST');
    	
    	$this->assertEquals(-1, $early->Compare($late));
    }
    
    public function testCanCompareDateEquality()
    {
    	$date1 = Date::Parse('2008-01-01 11:00:00', 'CST');
    	$date2 = Date::Parse('2008-01-01 11:00:00', 'EST');
    	
    	$this->assertTrue($date1->DateEquals($date2));
    	
    	$date1 = Date::Parse('2008-01-01 00:00:00', 'CST');
    	$date2 = Date::Parse('2008-01-01 00:00:00', 'EST');
    	
    	$this->assertFalse($date1->DateEquals($date2));
    }
    
    public function testCreateBuildsDateObjectCorectly()
    {
    	$date = Date::Create(2008, 10, 9, 8, 7, 6, 'CST');
    	
    	$this->assertEquals(2008, $date->Year());
    	$this->assertEquals(10, $date->Month());
    	$this->assertEquals(9, $date->Day());
    	$this->assertEquals(8, $date->Hour());
    	$this->assertEquals(7, $date->Minute());
    	$this->assertEquals(6, $date->Second());
    	$this->assertEquals('CST', $date->Timezone());
    }
    
    public function testCanCompareDateRelativity() 
    {
    	$date1 = Date::Parse('2008-01-01 11:00:00', 'CST');
    	$date2 = Date::Parse('2008-01-01 11:00:00', 'EST');
    	
    	$this->assertEquals(0, $date1->DateCompare($date2));
    	
    	$date1 = Date::Parse('2008-01-01 00:00:00', 'CST');
    	$date2 = Date::Parse('2008-01-01 00:00:00', 'EST');
    	
    	$this->assertEquals(1, $date1->DateCompare($date2), 'midnight eastern is 11pm central');
    	
    	$date1 = Date::Parse('2008-01-01 00:00:00', 'CST');
    	$date2 = Date::Parse('2008-01-01 22:00:00', 'PST');
    	
    	$this->assertEquals(-1, $date1->DateCompare($date2), 'midnight pacific is 2 am central');
    }
    
    public function GetDateReturnsDateAsOfMidnight()
    {
    	$date = new Date('2009-10-10 10:10:10');
    	$onlyDate = $date->GetDate();
    	
    	$this->assertEquals(0, $onlyDate->Hour());
    	$this->assertEquals(0, $onlyDate->Minute());
    	$this->assertEquals(0, $onlyDate->Second());
    }
    
	public function testDateIsWithinRange()
	{
		$begin = Date::Create(2008, 09, 9, 10, 11, 12, 'UTC');
		$end = Date::Create(2008, 10, 9, 10, 11, 12, 'UTC');
		
		$range = new DateRange($begin, $end);
		
		$within = $begin->AddDays(10);
		$notWithin = $begin->AddDays(-10);
		$exactStart = $begin;
		$exactEnd = $end;
		
		$this->assertTrue($range->Contains($within));
		$this->assertTrue($range->Contains($exactStart));
		$this->assertTrue($range->Contains($exactEnd));
		$this->assertFalse($range->Contains($notWithin));
	}
	
	public function testDateRangeIsWithinRange()
	{
		$begin = Date::Create(2008, 9, 9, 10, 11, 12, 'UTC');
		$end = Date::Create(2008, 10, 9, 10, 11, 12, 'UTC');
		
		$range = new DateRange($begin, $end);
		
		$within = new DateRange($begin->AddDays(10), $end->AddDays(-10));
		$notWithin = new DateRange($begin->AddDays(-10), $end->AddDays(-1));
		
		$exact = new DateRange($begin, $end);
		
		$this->assertTrue($range->ContainsRange($within));
		$this->assertTrue($range->ContainsRange($exact));
		$this->assertFalse($range->ContainsRange($notWithin));
	}
	
	public function testDateRangeReturnsAllDatesForRangeWithoutTime()
	{
		$begin = Date::Create(2008, 9, 9, 10, 11, 12, 'UTC');
		$end = Date::Create(2008, 9, 12, 10, 11, 12, 'UTC');
		
		$range = new DateRange($begin, $end);
		
		$expected[] = $begin->GetDate();
		$expected[] = $begin->AddDays(1)->GetDate();
		$expected[] = $begin->AddDays(2)->GetDate();
		$expected[] = $begin->AddDays(3)->GetDate();
		
		$actual = $range->Dates();
		
//		foreach ($expected as $d)
//		{
//			echo $d->ToString();
//			echo "\n";
//		}
//		
//		echo "\n";
//		
//		foreach ($actual as $d)
//		{
//			echo $d->ToString();
//			echo "\n";
//		}
		
//		$this->assertEquals($expected, $actual);
		$this->assertEquals(count($expected), count($actual));
		$this->assertTrue($expected[0]->Equals($actual[0]), "Dates[0] are not equal");
		$this->assertTrue($expected[1]->Equals($actual[1]), "Dates[1] are not equal");
		$this->assertTrue($expected[2]->Equals($actual[2]), "Dates[2] are not equal");
		$this->assertTrue($expected[3]->Equals($actual[3]), "Dates[3] are not equal");
	}
}
?>