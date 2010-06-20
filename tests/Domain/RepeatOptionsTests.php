<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class RepeatOptionsTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testNoRepeatNeverHasRepeatDates()
	{
		$duration = DateRange::Create('2010-01-12', '2010-02-12', 'UTC');

		$repeatOptions = new NoRepetion();
		$repeatedDates = $repeatOptions->GetDates();
		
		$this->assertEquals(0, count($repeatedDates));
	}
	
	public function testDailyRepeatCreatesRecurranceEverySpecifiedDayUntilEndAcrossDST()
	{
		$reservationStart = Date::Parse('2010-02-12 08:30', 'CST');
		$reservationEnd = Date::Parse('2010-02-12 10:30', 'CST');
		$duration = new DateRange($reservationStart, $reservationEnd);	

		$interval = 2;
		$terminiationDate = Date::Parse('2010-04-02', 'CST');
		
		$repeatOptions = new DailyRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 8 + 15 + 1;
		$firstDate = DateRange::Create('2010-02-14 08:30', '2010-02-14 10:30', 'CST');
		$lastDate = DateRange::Create('2010-04-01 08:30', '2010-04-01 10:30', 'CST');
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
	
	public function testWeeklyRepeatCreatesRecurranceOnSpecifiedDaysEveryIntervalUntilEndAcrossDST()
	{
		$reservationStart = Date::Parse('2010-02-12 08:30', 'CST');
		$reservationEnd = Date::Parse('2010-02-12 10:30', 'CST');
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 2;
		$terminiationDate = Date::Parse('2010-04-02', 'CST');
		
		throw new Exception('working on it');
		
		// maybe figure out the day of week difference from first date for each repeat day, the create the ranges per day?
		
		$repeatOptions = new WeeklyRepeat($interval, $terminiationDate, $duration, $daysOfWeek);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 0;
		$firstDate = null;;
		$lastDate = null;;
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
}
?>