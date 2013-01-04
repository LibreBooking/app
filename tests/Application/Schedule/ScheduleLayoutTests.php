<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ScheduleLayoutTests extends TestBase
{
	private $date;

	public function setup()
	{
		parent::setup();
		$this->date = Date::Parse('2011-03-01', 'America/Chicago');
	}

	public function teardown()
	{
		parent::teardown();
	}

	function testConvertingEasternLayoutToCentralPreAndPostDaylightSavings()
	{
		$cst = 'America/Chicago';
		$est = 'America/New_York';

		$layout = new ScheduleLayout($cst);

		$layout->AppendPeriod(Time::Parse("00:00", $est), Time::Parse("06:00", $est));
		$layout->AppendPeriod(Time::Parse("06:00", $est), Time::Parse("08:00", $est));
		$layout->AppendPeriod(Time::Parse("08:00", $est), Time::Parse("12:00", $est));
		$layout->AppendPeriod(Time::Parse("12:00", $est), Time::Parse("18:00", $est));
		$layout->AppendPeriod(Time::Parse("18:00", $est), Time::Parse("00:00", $est));

		$preDst = new Date('2011-03-12', $cst);
		$onDst = new Date('2011-03-13', $cst);
		$postDst = new Date('2011-03-14', $cst);
		$endDst = new Date('2011-11-06', $cst);

		foreach (array($preDst, $onDst, $postDst, $endDst) as $date)
		{
			//echo '-----TEST-----';
			$slots = $layout->GetLayout($date);
			//echo '-----TEST-----';
			//die();
			$this->assertEquals(6, count($slots));

			$month = $date->Month();
			$day = $date->Day();
			$tomorrow = $day + 1;
			$yesterday = $day - 1;
			$firstSlot = new SchedulePeriod(new Date("2011-$month-$yesterday 23:00", $cst), new Date("2011-$month-$day 05:00", $cst));
			$lastSlot = new SchedulePeriod(new Date("2011-$month-$day 23:00", $cst), new Date("2011-$month-$tomorrow 05:00", $cst));
			$this->assertEquals($firstSlot, $slots[0], "Testing first slot on date $date");
			$this->assertEquals($lastSlot, $slots[5], "Testing last slot on date $date");
		}
	}

	function testLayoutCanBeCreatedAsCSTFromPSTTimes()
	{
		$userTz = 'America/Chicago';
		$periodTz = 'America/Los_Angeles';

		$date = Date::Parse('2011-01-01', $periodTz);

		$t1s = $date->SetTime(new Time(0, 0, 0));
		$t1e = $date->SetTime(new Time(1, 0, 0));
		$t2e = $date->SetTime(new Time(21, 0, 0));

		$layout = new ScheduleLayout($userTz);
		$layout->AppendBlockedPeriod($t1s->GetTime(), $t1e->GetTime());
		$layout->AppendPeriod($t1e->GetTime(), $t2e->GetTime());
		$layout->AppendBlockedPeriod($t2e->GetTime(), $t1s->GetTime());

		//echo '-----TEST-----';
		$slots = $layout->GetLayout(Date::Parse('2011-01-01', $userTz));
		//echo '//-----TEST-----//';
		//die();
		$this->assertEquals(4, count($slots), '21:00 PST - 0:00 PST crosses midnight when converted to CST');
		$firstSlot = new NonSchedulePeriod(new Date("2010-12-31 23:00", $userTz), new Date("2011-01-01 02:00", $userTz));
		$slot2 = new NonSchedulePeriod(new Date("2011-01-01 02:00", $userTz), new Date("2011-01-01 03:00", $userTz));
		$slot3 = new SchedulePeriod(new Date("2011-01-01 03:00", $userTz), new Date("2011-01-01 23:00", $userTz));
		$lastSlot = new NonSchedulePeriod(new Date("2011-01-01 23:00", $userTz), new Date("2011-01-02 02:00", $userTz));

		$this->assertEquals($firstSlot, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
		$this->assertEquals($lastSlot, $slots[3]);
//		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[0]->Begin());
//		$this->assertEquals($t1s->ToTimezone($userTz)->GetTime(), $slots[0]->End());
//		
//		$this->assertEquals($t1s->ToTimezone($userTz)->GetTime(), $slots[1]->Begin(), $slots[1]->Begin()->ToString());
//		$this->assertEquals($t1e->ToTimezone($userTz)->GetTime(), $slots[1]->End(), $slots[1]->End()->ToString());
//		
//		$this->assertEquals($t1e->ToTimezone($userTz)->GetTime(), $slots[2]->Begin());
//		$this->assertEquals($t2e->ToTimezone($userTz)->GetTime(), $slots[2]->End());
//		
//		$this->assertEquals($t2e->ToTimezone($userTz)->GetTime(), $slots[3]->Begin());
//		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[3]->End());
	}

	public function testCreatesScheduleLayoutInProperOrder()
	{
		$utc = 'UTC';

		$time1 = Time::Parse('07:00', $utc);
		$time2 = Time::Parse('07:45', $utc);
		$time3 = Time::Parse('08:30', $utc);
		$time4 = Time::Parse('13:00', $utc);

		$layout = new ScheduleLayout($utc);

		$layout->AppendPeriod($time1, $time2);
		$layout->AppendPeriod($time3, $time4);
		$layout->AppendPeriod($time2, $time3, 'Period 1');

		$periods = $layout->GetLayout($this->date);

		$utcDate = $this->date->ToUtc();

		$this->assertEquals(3, count($periods));
		$period1 = new SchedulePeriod($utcDate->SetTime($time1), $utcDate->SetTime($time2));
		$period2 = new SchedulePeriod($utcDate->SetTime($time2), $utcDate->SetTime($time3), 'Period 1');
		$period3 = new SchedulePeriod($utcDate->SetTime($time3), $utcDate->SetTime($time4));

		$this->assertEquals($period1, $periods[0], $period1 . ' ' . $periods[0]);
		$this->assertEquals($period2, $periods[1], $period2 . ' ' . $periods[1]);
		$this->assertEquals($period3, $periods[2]);

		$dailyPeriods = $layout->GetSlots(null);
		$this->assertEquals(3, count($dailyPeriods));
		$this->assertEquals(new LayoutPeriod($time1, $time2), $dailyPeriods[0]);
		$this->assertEquals(new LayoutPeriod($time2, $time3, PeriodTypes::RESERVABLE, 'Period 1'), $dailyPeriods[1]);
	}

	public function testCreatesScheduleLayoutForSpecifiedTimezone()
	{
		$layout = new ScheduleLayout('CST');
		$startUtc = new Time(0, 0, 0, 'UTC');
		$endUtc = new Time(10, 0, 0, 'UTC');
		$layout->AppendPeriod($startUtc, $endUtc);
		$layout->AppendPeriod($endUtc, $startUtc);

		//echo '--TEST--';
		$periods = $layout->GetLayout(Date::Parse('2010-01-01', 'CST'));
		//echo '//TEST--';
		//die();
		$this->assertEquals(3, count($periods));

		$utcDate = $this->date->ToUtc();

		$firstBegin = Date::Parse('2010-01-01 0:00:00', 'UTC')->ToTimezone('CST');
		$firstEnd = Date::Parse('2010-01-01 10:00:00', 'UTC')->ToTimezone('CST');
		$secondBegin = Date::Parse('2010-01-01 10:00:00', 'UTC')->ToTimezone('CST');
		$secondEnd = Date::Parse('2010-01-02 0:00:00', 'UTC')->ToTimezone('CST');

		$this->assertTrue($firstBegin->Equals($periods[0]->BeginDate()));
		$this->assertTrue($firstEnd->Equals($periods[0]->EndDate()));
		$this->assertTrue($secondBegin->Equals($periods[1]->BeginDate()));
		$this->assertTrue($secondEnd->Equals($periods[1]->EndDate()));
	}

	public function testCanParseFromStrings()
	{
		$timezone = 'America/Chicago';
		$reservableSlots = "00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n";
		$blockedSlots = "12:00 - 15:00 Blocked 1 A\n15:00- 20:00\r\n20:00 -0:00\n";

		$layout = ScheduleLayout::Parse($timezone, $reservableSlots, $blockedSlots);

		$slots = $layout->GetSlots();

		$this->assertFalse($layout->UsesDailyLayouts());
		$this->assertEquals($timezone, $layout->Timezone());
		$this->assertEquals(7, count($slots));

		$start1 = Time::Parse("00:00", $timezone);
		$end1 = Time::Parse("01:00", $timezone);
		$label1 = "Label 1 A";

		$start4 = Time::Parse("12:00", $timezone);
		$end4 = Time::Parse("15:00", $timezone);
		$label4 = "Blocked 1 A";

		$this->assertEquals(new LayoutPeriod($start1, $end1, PeriodTypes::RESERVABLE, $label1), $slots[0]);
		$this->assertEquals(new LayoutPeriod($start4, $end4, PeriodTypes::NONRESERVABLE, $label4), $slots[4]);

	}

	public function testCanParseDailyFromStrings()
	{
		$timezone = 'America/Chicago';
		$days = DayOfWeek::Days();

		$reservableSlots = array();
		$blockedSlots = array();

		foreach ($days as $day)
		{
			$reservableSlots[$day] = "00:00 - 01:00 Label $day A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n";
			$blockedSlots[$day] = "12:00 - 15:00 Blocked $day A\n15:00- 20:00\r\n20:00 -0:00\n";
		}

		$layout = ScheduleLayout::ParseDaily($timezone, $reservableSlots, $blockedSlots);

		$this->assertTrue($layout->UsesDailyLayouts());
		$this->assertEquals($timezone, $layout->Timezone());

		foreach ($days as $day)
		{
			$slots = $layout->GetSlots($day);
			$this->assertEquals(7, count($slots));
			$start1 = Time::Parse("00:00", $timezone);
			$end1 = Time::Parse("01:00", $timezone);

			$start4 = Time::Parse("12:00", $timezone);
			$end4 = Time::Parse("15:00", $timezone);

			$this->assertEquals(new LayoutPeriod($start1, $end1, PeriodTypes::RESERVABLE, "Label $day A"), $slots[0]);
			$this->assertEquals(new LayoutPeriod($start4, $end4, PeriodTypes::NONRESERVABLE, "Blocked $day A"), $slots[4]);
		}
	}

	public function testCanGetPeriodForTime()
	{
		$timezone = 'America/Chicago';
		$reservableSlots = "00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n";
		$blockedSlots = "12:00 - 15:00 Blocked 1 A\n15:00- 20:00\r\n20:00 -0:00\n";

		$layout = ScheduleLayout::Parse($timezone, $reservableSlots, $blockedSlots);

		$actual1 = $layout->GetPeriod(Date::Parse('2012-01-01 15:30:00', $timezone));
		$actual2 = $layout->GetPeriod(Date::Parse('2012-01-01 02:00:00', $timezone));

		$this->assertEquals(new NonSchedulePeriod(Date::Parse('2012-01-01 15:00',
															  $timezone), Date::Parse('2012-01-01 20:00', $timezone)),
							$actual1);
		$this->assertEquals(new SchedulePeriod(Date::Parse('2012-01-01 02:00',
														   $timezone), Date::Parse('2012-01-01 03:30', $timezone)),
							$actual2);
	}

	public function testTokyoDefect()
	{
		$tokyo = 'Asia/Tokyo';
		$layout = new ScheduleLayout('America/New_York');
		$layout->AppendBlockedPeriod(Time::Parse("00:00", $tokyo), Time::Parse("08:00", $tokyo));
		for ($i = 8; $i < 20; $i++)
		{
			$layout->AppendPeriod(Time::Parse("$i:00", $tokyo), Time::Parse($i + 1 . ":00", $tokyo));
		}
		$layout->AppendBlockedPeriod(Time::Parse("20:00", $tokyo), Time::Parse("00:00", $tokyo));

		$l = $layout->GetLayout(Date::Parse('2012-06-18', 'America/New_York'));

		$this->assertEquals($l[0]->BeginDate(), Date::Parse('2012-06-18', 'America/New_York'));
		$this->assertEquals($l[count($l) - 1]->EndDate(), Date::Parse('2012-06-19', 'America/New_York'));
	}

	public function testWhenFindingPeriodInCSTWithUTCDate()
	{
		$layoutTz = 'America/Chicago';
		$scheduleLayoutFactory = new ScheduleLayoutFactory('UTC');
		$layout = $scheduleLayoutFactory->CreateLayout();

		$layout->AppendPeriod(Time::Parse("00:00", $layoutTz), Time::Parse("12:00", $layoutTz));
		$layout->AppendPeriod(Time::Parse("12:00", $layoutTz), Time::Parse("12:30", $layoutTz));
		$layout->AppendPeriod(Time::Parse("12:30", $layoutTz), Time::Parse("13:00", $layoutTz));
		$layout->AppendPeriod(Time::Parse("13:00", $layoutTz), Time::Parse("13:30", $layoutTz));
		$layout->AppendPeriod(Time::Parse("13:30", $layoutTz), Time::Parse("14:00", $layoutTz));
		$layout->AppendPeriod(Time::Parse("14:00", $layoutTz), Time::Parse("14:30", $layoutTz));
		$layout->AppendPeriod(Time::Parse("14:30", $layoutTz), Time::Parse("00:00", $layoutTz));

		$date = Date::Parse('2012-11-26 19:30', 'UTC');
		$period = $layout->GetPeriod($date);

		$this->assertTrue($date->Equals($period->BeginDate()));
	}

	public function testGetsLayoutForEachDayOfWeek()
	{
		$utc = 'UTC';
		$sunday = Date::Parse('2013-01-06 00:00', 'America/Chicago');
		$monday = Date::Parse('2013-01-06 20:00', 'America/Chicago');
		$utcDate = $sunday->ToUtc();

		$midnight = Time::Parse('00:00', $utc);
		$time1 = Time::Parse('07:00', $utc);
		$time2 = Time::Parse('07:45', $utc);
		$time3 = Time::Parse('08:30', $utc);
		$time4 = Time::Parse('13:00', $utc);

		$layout = new ScheduleLayout($utc);

		$layout->AppendBlockedPeriod($time1, $time2, null, DayOfWeek::SUNDAY);
		$layout->AppendPeriod($midnight, $time1, null, DayOfWeek::SUNDAY);
		$layout->AppendPeriod($time2, $time3, 'Period 1', DayOfWeek::SUNDAY);
		$layout->AppendPeriod($time3, $time4, null, DayOfWeek::SUNDAY);
		$layout->AppendPeriod($time4, $midnight, 'Period 2', DayOfWeek::SUNDAY);

		$layout->AppendBlockedPeriod($midnight, $midnight, 'Monday Period', DayOfWeek::MONDAY);

		$sundayPeriods = $layout->GetLayout($sunday);
		$mondayPeriods = $layout->GetLayout($monday);

		$this->assertTrue($layout->UsesDailyLayouts());
		$this->assertEquals(5, count($sundayPeriods));
		$period1 = new SchedulePeriod($utcDate->SetTime($midnight), $utcDate->SetTime($time1));
		$period2 = new NonSchedulePeriod($utcDate->SetTime($time1), $utcDate->SetTime($time2));
		$period3 = new SchedulePeriod($utcDate->SetTime($time2), $utcDate->SetTime($time3), 'Period 1');
		$period4 = new SchedulePeriod($utcDate->SetTime($time3), $utcDate->SetTime($time4));
		$period5 = new SchedulePeriod($utcDate->SetTime($time4), $utcDate->SetTime($midnight, true), 'Period 2');

		$this->assertEquals($period1, $sundayPeriods[0], $period1 . ' ' . $sundayPeriods[0]);
		$this->assertEquals($period2, $sundayPeriods[1], $period2 . ' ' . $sundayPeriods[1]);
		$this->assertEquals($period3, $sundayPeriods[2]);
		$this->assertEquals($period4, $sundayPeriods[3]);
		$this->assertEquals($period5, $sundayPeriods[4]);

		$this->assertEquals(1, count($mondayPeriods));
		$utcDate = $monday->ToUtc();
		$period1 = new NonSchedulePeriod($utcDate->SetTime($midnight), $utcDate->SetTime($midnight,
																						 true), 'Monday Period');
		$this->assertEquals($period1, $mondayPeriods[0], 'Expected ' . $period1 . ' Actual ' . $mondayPeriods[0]);

		$sundayDailyPeriods = $layout->GetSlots(DayOfWeek::SUNDAY);
		$mondayDailyPeriods = $layout->GetSlots(DayOfWeek::MONDAY);

		$this->assertEquals(5, count($sundayDailyPeriods));
		$this->assertEquals(new LayoutPeriod($midnight, $time1, PeriodTypes::RESERVABLE, null), $sundayDailyPeriods[0]);
		$this->assertEquals(1, count($mondayDailyPeriods));
		$this->assertEquals(new LayoutPeriod($midnight, $midnight, PeriodTypes::NONRESERVABLE, 'Monday Period'),
							$mondayDailyPeriods[0]);
	}

	public function testFullDayPeriod()
	{
		$utc = 'UTC';
		$sunday = Date::Parse('2013-01-06 00:00', 'America/Chicago');
		$utcDate = $sunday->ToUtc();
		$midnight = Time::Parse('00:00', $utc);

		$layout = new ScheduleLayout($utc);
		$layout->AppendPeriod($midnight, $midnight);

		$periods = $layout->GetLayout($sunday);

		$this->assertEquals(1, count($periods));
		$period1 = new SchedulePeriod($utcDate->SetTime($midnight), $utcDate->SetTime($midnight, true));
		$this->assertEquals($period1, $periods[0], 'Expected ' . $period1 . ' Actual ' . $periods[0]);
	}

	public function testWhenFindingPeriodWithDailyLayout()
	{
		$this->fail('something isnt right when adjusting for tz');
		// full day EST
		// book for slot CST fails
		$layoutTz = 'America/Chicago';
		$scheduleLayoutFactory = new ScheduleLayoutFactory('UTC');
		$layout = $scheduleLayoutFactory->CreateLayout();

		$layout->AppendPeriod(Time::Parse("00:00", $layoutTz), Time::Parse("12:00", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("12:00", $layoutTz), Time::Parse("12:30", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("12:30", $layoutTz), Time::Parse("13:00", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("13:00", $layoutTz), Time::Parse("13:30", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("13:30", $layoutTz), Time::Parse("14:00", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("14:00", $layoutTz), Time::Parse("14:30", $layoutTz), DayOfWeek::MONDAY);
		$layout->AppendPeriod(Time::Parse("14:30", $layoutTz), Time::Parse("00:00", $layoutTz), DayOfWeek::MONDAY);

		$date = Date::Parse('2012-11-25 19:30', 'UTC');
		$period = $layout->GetPeriod($date);

		$this->assertTrue($date->Equals($period->BeginDate()));
	}
}

?>