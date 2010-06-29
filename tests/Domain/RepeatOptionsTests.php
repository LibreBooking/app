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
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-02-11 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-02-11 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 2;
		$terminiationDate = Date::Parse('2010-04-01', $timezone);
		$daysOfWeek = array(1, 3, 5);
		
		$repeatOptions = new WeeklyRepeat($interval, $terminiationDate, $duration, $daysOfWeek);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 10;
		$firstDate = DateRange::Create('2010-02-12 08:30', '2010-02-12 10:30', $timezone);
		$secondDate = DateRange::Create('2010-02-22 08:30', '2010-02-22 10:30', $timezone);
		$thirdDate = DateRange::Create('2010-02-24 08:30', '2010-02-24 10:30', $timezone);
		$forthDate = DateRange::Create('2010-02-26 08:30', '2010-02-26 10:30', $timezone);
		$lastDate = DateRange::Create('2010-03-26 08:30', '2010-03-26 10:30', $timezone);
		
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($secondDate->Equals($repeatedDates[1]), $secondDate->ToString() . ' ' . $repeatedDates[1]->ToString());
		$this->assertTrue($thirdDate->Equals($repeatedDates[2]), $thirdDate->ToString() . ' ' . $repeatedDates[2]->ToString());
		$this->assertTrue($forthDate->Equals($repeatedDates[3]), $forthDate->ToString() . ' ' . $repeatedDates[3]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
	
	public function testWeeklyRepeatCreatesRecurranceOnSingleDayEveryIntervalUntilEndAcrossDST()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-02-11 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-02-11 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 1;
		$terminiationDate = Date::Parse('2010-04-01', $timezone);
		$daysOfWeek = array(3);
		
		$repeatOptions = new WeeklyRepeat($interval, $terminiationDate, $duration, $daysOfWeek);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 7;
		$firstDate = DateRange::Create('2010-02-17 08:30', '2010-02-17 10:30', $timezone);
		$forthDate = DateRange::Create('2010-03-10 08:30', '2010-03-10 10:30', $timezone);
		$lastDate = DateRange::Create('2010-03-31 08:30', '2010-03-31 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($forthDate->Equals($repeatedDates[3]), $forthDate->ToString() . ' ' . $repeatedDates[3]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
	
	public function testMonthlyRepeatDayOfMonthWhenDayIsInAllMonths()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-02-11 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-02-11 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 1;
		$terminiationDate = Date::Parse('2010-10-01', $timezone);
		
		$repeatOptions = new DayOfMonthRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 7;
		$firstDate = DateRange::Create('2010-03-11 08:30', '2010-03-11 10:30', $timezone);
		$secondDate = DateRange::Create('2010-04-11 08:30', '2010-04-11 10:30', $timezone);
		$lastDate = DateRange::Create('2010-09-11 08:30', '2010-09-11 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($secondDate->Equals($repeatedDates[1]), $secondDate->ToString() . ' ' . $repeatedDates[1]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
	
	public function testMonthlyRepeatDayOfMonthWhenDayIsNotInAllMonths()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-03-31 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-03-31 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 1;
		$terminiationDate = Date::Parse('2010-10-01', $timezone);
		
		$repeatOptions = new DayOfMonthRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
		
		$totalDates = 3;
		$firstDate = DateRange::Create('2010-05-31 08:30', '2010-05-31 10:30', $timezone);
		$secondDate = DateRange::Create('2010-07-31 08:30', '2010-07-31 10:30', $timezone);
		$lastDate = DateRange::Create('2010-08-31 08:30', '2010-08-31 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($secondDate->Equals($repeatedDates[1]), $secondDate->ToString() . ' ' . $repeatedDates[1]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
}
?>