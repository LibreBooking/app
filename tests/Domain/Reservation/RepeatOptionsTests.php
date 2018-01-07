<?php
/**
Copyright 2011-2018 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');

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

		$repeatOptions = new RepeatNone();
		$repeatedDates = $repeatOptions->GetDates($duration);

		$this->assertEquals(0, count($repeatedDates));
	}

	public function testTerminationDateIsInclusive()
	{
		$reservationStart = Date::Parse('2010-02-12 08:30', 'CST');
		$reservationEnd = Date::Parse('2010-02-12 10:30', 'CST');
		$duration = new DateRange($reservationStart, $reservationEnd);

		$interval = 1;
		$terminiationDate = Date::Parse('2010-02-14', 'CST');

		$repeatOptions = new RepeatDaily($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

		$this->assertEquals(2, count($repeatedDates));
	}

	public function testRepeatDailyCreatesRecurranceEverySpecifiedDayUntilEndAcrossDST()
	{
		$reservationStart = Date::Parse('2010-02-12 08:30', 'CST');
		$reservationEnd = Date::Parse('2010-02-12 10:30', 'CST');
		$duration = new DateRange($reservationStart, $reservationEnd);

		$interval = 2;
		$terminiationDate = Date::Parse('2010-04-02', 'CST');

		$repeatOptions = new RepeatDaily($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

		$totalDates = 8 + 15 + 1;
		$firstDate = DateRange::Create('2010-02-14 08:30', '2010-02-14 10:30', 'CST');
		$lastDate = DateRange::Create('2010-04-01 08:30', '2010-04-01 10:30', 'CST');

		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}

	public function testRepeatWeeklyCreatesRecurranceOnSpecifiedDaysEveryIntervalUntilEndAcrossDST()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-02-11 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-02-11 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);

		$interval = 2;
		$terminiationDate = Date::Parse('2010-04-01', $timezone);
		$daysOfWeek = array(1, 3, 5);

		$repeatOptions = new RepeatWeekly($interval, $terminiationDate, $daysOfWeek);
		$repeatedDates = $repeatOptions->GetDates($duration);

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

	public function testRepeatWeeklyCreatesRecurranceOnSingleDayEveryIntervalUntilEndAcrossDST()
	{
		$timezone = 'EST';
		$reservationStart = Date::Parse('2010-02-11 08:30', $timezone);
		$reservationEnd = Date::Parse('2010-02-11 10:30', $timezone);
		$duration = new DateRange($reservationStart, $reservationEnd);

		$interval = 1;
		$terminiationDate = Date::Parse('2010-04-01', $timezone);
		$daysOfWeek = array(3);

		$repeatOptions = new RepeatWeekly($interval, $terminiationDate, $daysOfWeek);
		$repeatedDates = $repeatOptions->GetDates($duration);

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
		$terminiationDate = Date::Parse('2011-10-01', $timezone);

		$repeatOptions = new RepeatDayOfMonth($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

		$totalDates = 19;
		$firstDate = DateRange::Create('2010-03-11 08:30', '2010-03-11 10:30', $timezone);
		$secondDate = DateRange::Create('2010-04-11 08:30', '2010-04-11 10:30', $timezone);
		$lastDate = DateRange::Create('2011-09-11 08:30', '2011-09-11 10:30', $timezone);

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

		$repeatOptions = new RepeatDayOfMonth($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

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
		$terminiationDate = Date::Parse('2011-10-01', $timezone);

		$repeatOptions = new RepeatWeekDayOfMonth($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

		$totalDates = 18;
		$firstDate = DateRange::Create('2010-04-05 08:30', '2010-04-05 10:30', $timezone);
		$secondDate = DateRange::Create('2010-05-03 08:30', '2010-05-03 10:30', $timezone);
		$lastDate = DateRange::Create('2011-09-05 08:30', '2011-09-05 10:30', $timezone);

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

		$repeatOptions = new RepeatWeekDayOfMonth($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

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

		$repeatOptions = new RepeatYearly($interval, $terminiationDate);
		$repeatedDates = $repeatOptions->GetDates($duration);

		$totalDates = 2;
		$firstDate = DateRange::Create('2012-03-31 08:30', '2012-03-31 10:30', $timezone);
		$lastDate = DateRange::Create('2014-03-31 08:30', '2014-03-31 10:30', $timezone);

		$this->assertEquals($totalDates, count($repeatedDates));
		$this->assertTrue($firstDate->Equals($repeatedDates[0]), $firstDate->ToString() . ' ' . $repeatedDates[0]->ToString());
		$this->assertTrue($lastDate->Equals($repeatedDates[$totalDates-1]), $lastDate->ToString() . ' ' . $repeatedDates[$totalDates-1]->ToString());
	}

	public function testFactoryCreatesRepeatDailyOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('daily', 1, null, null, null);

		$this->assertInstanceOf('RepeatDaily', $options);
	}

	public function testFactoryCreatesRepeatWeeklyOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('weekly', 1, null, array(), null);

		$this->assertInstanceOf('RepeatWeekly', $options);
	}

	public function testFactoryCreatesDayOfMonthRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('monthly', 1, null, null, 'dayOfMonth');

		$this->assertInstanceOf('RepeatDayOfMonth', $options);
	}

	public function testFactoryCreatesWeekDayOfMonthRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('monthly', 1, null, null, null);

		$this->assertInstanceOf('RepeatWeekDayOfMonth', $options);
	}

	public function testFactoryCreatesYearlyRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('yearly', 1, null, null, null);

		$this->assertInstanceOf('RepeatYearly', $options);
	}

	public function testFactoryCreatesNoRepeatOptions()
	{
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create('none', 1, null, null, null);

		$this->assertInstanceOf('RepeatNone', $options);
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
		$daily = new RepeatDaily($interval, $terminationDate);
		$config = RepeatConfiguration::Create($daily->RepeatType(), $daily->ConfigurationString());
		$this->assertEquals(RepeatType::Daily, $config->Type);
		$this->assertEquals(10, $config->Interval);
		$this->assertEquals($terminationDate, $config->TerminationDate);

		// weekly
		$weekdays = array(1, 3, 4, 5);
		$weekly = new RepeatWeekly($interval, $terminationDate, $weekdays);
		$config = RepeatConfiguration::Create($weekly->RepeatType(), $weekly->ConfigurationString());
		$this->assertEquals(RepeatType::Weekly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals($weekdays, $config->Weekdays);

		// day of month
		$dayOfMonth = new RepeatDayOfMonth($interval, $terminationDate);
		$config = RepeatConfiguration::Create($dayOfMonth->RepeatType(), $dayOfMonth->ConfigurationString());
		$this->assertEquals(RepeatType::Monthly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals(RepeatMonthlyType::DayOfMonth, $config->MonthlyType);

		// weekday of month
		$weekOfMonth = new RepeatWeekDayOfMonth($interval, $terminationDate);
		$config = RepeatConfiguration::Create($weekOfMonth->RepeatType(), $weekOfMonth->ConfigurationString());
		$this->assertEquals(RepeatType::Monthly, $config->Type);
		$this->assertEquals($terminationDate, $config->TerminationDate);
		$this->assertEquals(RepeatMonthlyType::DayOfWeek, $config->MonthlyType);

		// yearly
		$yearly = new RepeatYearly($interval, $terminationDate);
		$config = RepeatConfiguration::Create($yearly->RepeatType(), $yearly->ConfigurationString());
		$this->assertEquals(RepeatType::Yearly, $config->Type);
		$this->assertEquals(10, $config->Interval);
		$this->assertEquals($terminationDate, $config->TerminationDate);
	}

	public function testRepeatWhenRepeatingDayBeforeFirstDayOfMonth()
	{
		// 2012-08 starts on wednesday, the 1st
		$firstSunday = Date::Parse('2012-08-05');
		$firstTuesday = Date::Parse('2012-08-07');
		$secondTuesday = Date::Parse('2012-08-14');
		$firstWednesday = Date::Parse('2012-08-01');
		$secondWednesday = Date::Parse('2012-08-08');
		$weekOfMonth = new RepeatWeekDayOfMonth(1, Date::Parse('2013-01-01'));

		$repeatDatesForFirstSun = $weekOfMonth->GetDates(new DateRange($firstSunday, $firstSunday));
		$repeatDatesForFirstTue = $weekOfMonth->GetDates(new DateRange($firstTuesday, $firstTuesday));
		$repeatDatesForSecondTue = $weekOfMonth->GetDates(new DateRange($secondTuesday, $secondTuesday));
		$repeatDatesForFirstWed = $weekOfMonth->GetDates(new DateRange($firstWednesday, $firstWednesday));
		$repeatDatesForSecondWed = $weekOfMonth->GetDates(new DateRange($secondWednesday, $secondWednesday));

		$firstRepeatedSun = $repeatDatesForFirstSun[0]->GetBegin();
		$firstRepeatedTue = $repeatDatesForFirstTue[0]->GetBegin();
		$secondRepeatedTue = $repeatDatesForSecondTue[0]->GetBegin();
		$firstRepeatedWed = $repeatDatesForFirstWed[0]->GetBegin();
		$secondRepeatedWed = $repeatDatesForSecondWed[0]->GetBegin();

		$this->assertTrue(Date::Parse('2012-09-02')->Equals($firstRepeatedSun), $firstRepeatedSun->__toString());
		$this->assertTrue(Date::Parse('2012-09-04')->Equals($firstRepeatedTue), $firstRepeatedTue->__toString());
		$this->assertTrue(Date::Parse('2012-09-05')->Equals($firstRepeatedWed), $firstRepeatedWed->__toString());
		$this->assertTrue(Date::Parse('2012-09-11')->Equals($secondRepeatedTue), $secondRepeatedTue->__toString());
		$this->assertTrue(Date::Parse('2012-09-12')->Equals($secondRepeatedWed), $secondRepeatedWed->__toString());
	}

	public function testRepeatingAcrossEuropeanDaylightSavings()
	{
		$firstWednesday = DateRange::Create('2013-02-06 09:00', '2013-02-06 10:00', 'Europe/London');
		$firstWednesdayRepeat = new RepeatWeekDayOfMonth(1, Date::Parse('2013-10-01', 'Europe/London'));

		/** @var $dates DateRange[] */
		$dates = $firstWednesdayRepeat->GetDates($firstWednesday);

		foreach ($dates as $date)
		{
			$date = $date->ToTimezone('Europe/London');
			$this->assertEquals(9, $date->GetBegin()->Hour(), $date->__toString());
			$this->assertEquals(10, $date->GetEnd()->Hour());
			$this->assertEquals(3, $date->GetBegin()->Weekday());
		}
	}

	public function testRepeatingAcrossEuropeanDaylightSavingsWithOtherExample()
	{
		$firstWednesday = DateRange::Create('2013-03-06 13:00:00', '2013-03-06 14:00:00', 'Europe/London');
		$firstWednesdayRepeat = new RepeatWeekDayOfMonth(1, Date::Parse('2013-12-24', 'Europe/London'));

		/** @var $dates DateRange[] */
		$dates = $firstWednesdayRepeat->GetDates($firstWednesday);

		foreach ($dates as $date)
		{
			$date = $date->ToTimezone('Europe/London');
			$this->assertEquals(13, $date->GetBegin()->Hour(), $date->__toString());
			$this->assertEquals(14, $date->GetEnd()->Hour());
			$this->assertEquals(3, $date->GetBegin()->Weekday());
		}
	}

	public function testRepeatFirstFridayWhenTheFirstDayOfTheMonthIsAFriday()
	{
		$firstFriday = DateRange::Create('2014-04-04 08:00', '2014-04-04 08:00', 'UTC');
		$repeat = new RepeatWeekDayOfMonth(1, Date::Parse('2015-01-01', 'UTC'));

		/** @var $dates DateRange[] */
		$dates = $repeat->GetDates($firstFriday);
		$this->assertEquals(1, $dates[3]->GetBegin()->Day());
	}
}