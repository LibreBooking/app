<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class RepeatOptionsTests extends TestBase
{
	//http://www.timeanddate.com/calendar/
	
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
	
	public function testMonthlyRepeatDayOfWeekWhenWeekIsInAllMonths()
	{
		//http://www.timeanddate.com/calendar/
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-03-01 08:30', $timezone); // first monday
		$reservationEnd = Date::Parse('2010-03-01 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 1;
		$terminiationDate = Date::Parse('2010-10-01', $timezone);
		
		$repeatOptions = new WeekDayOfMonthRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
	
		$totalDates = 6;
		$firstDate = DateRange::Create('2010-04-05 08:30', '2010-04-05 10:30', $timezone);
		$secondDate = DateRange::Create('2010-05-03 08:30', '2010-05-03 10:30', $timezone);
		$lastDate = DateRange::Create('2010-09-06 08:30', '2010-09-06 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($secondDate->Equals($repeatedDates[1]), $secondDate->ToString() . ' ' . $repeatedDates[1]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}
	
	public function testMonthlyRepeatDayOfWeekWhenWeekIsNotInAllMonths()
	{
		//http://www.timeanddate.com/calendar/
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-03-31 08:30', $timezone); // fifth wednesday
		$reservationEnd = Date::Parse('2010-03-31 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 1;
		$terminiationDate = Date::Parse('2010-10-01', $timezone);
		
		$repeatOptions = new WeekDayOfMonthRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
	
		$totalDates = 2;
		$firstDate = DateRange::Create('2010-06-30 08:30', '2010-06-30 10:30', $timezone);
		$lastDate = DateRange::Create('2010-09-29 08:30', '2010-09-29 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}	
	
	public function testYearlyRepeat()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-03-31 08:30', $timezone); // fifth wednesday
		$reservationEnd = Date::Parse('2010-03-31 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);
		
		$interval = 2;
		$terminiationDate = Date::Parse('2016-03-30', $timezone);
		
		$repeatOptions = new YearlyRepeat($interval, $terminiationDate, $duration);
		$repeatedDates = $repeatOptions->GetDates();
	
		$totalDates = 2;
		$firstDate = DateRange::Create('2012-03-31 08:30', '2012-03-31 10:30', $timezone);
		$lastDate = DateRange::Create('2014-03-31 08:30', '2014-03-31 10:30', $timezone);
		
		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	
	}
	
	public function testFactoryCreatesDailyRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('daily', 1, null, null, null, null);
		
		$this->assertType('DailyRepeat', $options);
	}
	
	public function testFactoryCreatesWeeklyRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('weekly', 1, null, null, array(), null);
		
		$this->assertType('WeeklyRepeat', $options);
	}
	
	public function testFactoryCreatesDayOfMonthRepeatOptions()
	{
		$intial = DateRange::Create('2010-01-01', '2010-01-01', 'cst');
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('monthly', 1, null, $intial, null, 'dayOfMonth');
		
		$this->assertType('DayOfMonthRepeat', $options);
	}
	
	public function testFactoryCreatesWeekDayOfMonthRepeatOptions()
	{
		$intial = DateRange::Create('2010-01-01', '2010-01-01', 'cst');
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('monthly', 1, null, $intial, null, null);
		
		$this->assertType('WeekDayOfMonthRepeat', $options);
	}
	
	public function testFactoryCreatesYearlyRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('yearly', 1, null, null, null, null);
		
		$this->assertType('YearlyRepeat', $options);
	}
	
	public function testFactoryCreatesNoRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('none', 1, null, null, null, null);
		
		$this->assertType('NoRepetion', $options);
	}
	
	public function testConfigurationStringCanBeDeserialized()
	{
		$terminationDate = Date::Parse('2010-12-12 01:06:07', 'UTC');
		$dateString = $terminationDate->ToDatabase();
		$interval = 10;
		
		// none
		$config = RepeatConfiguration::Create(RepeatType::None, '');
		$this->assertEquals(RepeatType::None, $config->Type);
		
		// daily
		$daily = new DailyRepeat($interval, $terminationDate, null);
		$config = RepeatConfiguration::Create($daily->RepeatType(), $daily->ConfigurationString());
		$this->assertEquals(RepeatType::Daily, $config->Type);
		$this->assertEquals(10, $config->Interval);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		
		// weekly
		$weekdays = array(1, 3, 4, 5);
		$weekly = new WeeklyRepeat($interval, $terminationDate, null, $weekdays);
		$config = RepeatConfiguration::Create($weekly->RepeatType(), $weekly->ConfigurationString());
		$this->assertEquals(RepeatType::Weekly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals($weekdays, $config->Weekdays);
		
		// day of month
		$dayOfMonth = new DayOfMonthRepeat($interval, $terminationDate, null);
		$config = RepeatConfiguration::Create($dayOfMonth->RepeatType(), $dayOfMonth->ConfigurationString());
		$this->assertEquals(RepeatType::Monthly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals(RepeatMonthlyType::DayOfMonth, $config->MonthlyType);
		
		// weekday of month
		$weekOfMonth = new WeekDayOfMonthRepeat($interval, $terminationDate, null);
		$config = RepeatConfiguration::Create($weekOfMonth->RepeatType(), $weekOfMonth->ConfigurationString());
		$this->assertEquals(RepeatType::Monthly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals(RepeatMonthlyType::DayOfWeek, $config->MonthlyType);
		
		// yearly
		$yearly = new YearlyRepeat($interval, $terminationDate, null);
		$config = RepeatConfiguration::Create($yearly->RepeatType(), $yearly->ConfigurationString());
		$this->assertEquals(RepeatType::Yearly, $config->Type);
		$this->assertEquals(10, $config->Interval);
		$this->assertEquals($terminationDate, $config->TerminationDate);
	}
}
?>