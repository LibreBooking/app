<?php
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
				
		foreach (array($preDst, $onDst, $postDst) as $date)
		{
			echo '-----TEST-----';
			$slots = $layout->GetLayout($date);
			echo '-----TEST-----';
			//die();
			$this->assertEquals(5, count($slots));
			
			$day = $date->Day();
			$tomorrow = $day+1;
			$firstSlot = new SchedulePeriod(new Date("2011-03-$day 00:00", $cst), new Date("2011-03-$day 05:00", $cst));
			$lastSlot = new SchedulePeriod(new Date("2011-03-$day 17:00", $cst), new Date("2011-03-$tomorrow 00:00", $cst));
			$this->assertEquals($firstSlot, $slots[0], "Testing date $date");
			$this->assertEquals($lastSlot, $slots[4], "Testing date $date");
		}
	}
	
	function testLayoutCanBeCreatedAsCSTFromUTCTimes()
	{
		$userTz = 'America/Chicago';
		$utc = 'UTC';
		
		$utcDate = $this->date->ToUtc();
		
		$t1s = $utcDate->SetTime(new Time(0, 0, 0));
		$t1e = $utcDate->SetTime(new Time(1, 0, 0));
		$t2e = $utcDate->SetTime(new Time(3, 0, 0));
		
		$layout = new ScheduleLayout($userTz);
		$layout->AppendBlockedPeriod($t1s->GetTime(), $t1e->GetTime());
		$layout->AppendPeriod($t1e->GetTime(), $t2e->GetTime());
		$layout->AppendBlockedPeriod($t2e->GetTime(), $t1s->GetTime());

		echo '-----TEST-----';
		$slots = $layout->GetLayout(Date::Parse('2010-01-01', $userTz));
		echo '-----TEST-----';
		//die();
		$this->assertEquals(4, count($slots), '3:00 UTC - 0:00 UTC crosses midnight when converted to CST');
		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[0]->Begin());
		$this->assertEquals($t1s->ToTimezone($userTz)->GetTime(), $slots[0]->End());
		
		$this->assertEquals($t1s->ToTimezone($userTz)->GetTime(), $slots[1]->Begin(), $slots[1]->Begin()->ToString());
		$this->assertEquals($t1e->ToTimezone($userTz)->GetTime(), $slots[1]->End(), $slots[1]->End()->ToString());
		
		$this->assertEquals($t1e->ToTimezone($userTz)->GetTime(), $slots[2]->Begin());
		$this->assertEquals($t2e->ToTimezone($userTz)->GetTime(), $slots[2]->End());
		
		$this->assertEquals($t2e->ToTimezone($userTz)->GetTime(), $slots[3]->Begin());
		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[3]->End());
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
	}
	
	public function testCreatingScheduleLayoutForDatabaseConvertsToGmtAndAddsTimesIfNeeded()
	{
		$this->markTestIncomplete('probably dont need this');
		
		$timezone = 'CST';
		
		$time1 = Time::Parse('07:00', $timezone);
		$time2 = Time::Parse('07:45', $timezone);
		$time3 = Time::Parse('08:30', $timezone);
		$time4 = Time::Parse('13:00', $timezone);
		
		$time1Gmt = $time1->ToUtc();
		$time2Gmt = $time2->ToUtc();
		$time3Gmt = $time3->ToUtc();
		$time4Gmt = $time4->ToUtc();
		
		$layout = new ScheduleLayout($timezone);
		
		$layout->AppendPeriod($time1, $time2);
		$layout->AppendPeriod($time3, $time4);
		$layout->AppendPeriod($time2, $time3, 'Period 1');
		
		$layoutForDb = new DatabaseScheduleLayout($layout);
		
		$periods = $layoutForDb->GetLayout($this->date);
		
		$this->assertEquals(5, count($periods));
		$this->assertEquals(new NonSchedulePeriod(Time::Parse('00:00')->ToUtc(), $time1Gmt), $periods[0], $periods[0]);
		$this->assertEquals(new SchedulePeriod($time1Gmt, $time2Gmt), $periods[1]);
		$this->assertEquals(new SchedulePeriod($time2Gmt, $time3Gmt, 'Period 1'), $periods[2]);
		$this->assertEquals(new SchedulePeriod($time3Gmt, $time4Gmt), $periods[3]);
		$this->assertEquals(new NonSchedulePeriod($time4Gmt, Time::Parse('00:00')->ToUtc()), $periods[4]);
	}
	
	public function testCreatesScheduleLayoutForSpecifiedTimezone()
	{
		$layout = new ScheduleLayout('CST');
		$startUtc = new Time(0, 0, 0, 'UTC');
		$endUtc = new Time(10, 0, 0, 'UTC');
		$layout->AppendPeriod($startUtc, $endUtc);
		
		$periods = $layout->GetLayout(Date::Parse('2010-01-01', 'CST'));
		
		$this->assertEquals(2, count($periods));
		
		$utcDate = $this->date->ToUtc();
		
		$firstBegin = new Time(0,0,0, 'CST');
		$firstEnd = $utcDate->SetTime($endUtc)->ToTimezone('CST')->GetTime();
		$secondBegin = $utcDate->SetTime($startUtc)->ToTimezone('CST')->GetTime();
		$secondEnd = new Time(0, 0, 0, 'CST');
		
		$this->assertEquals($firstBegin, $periods[0]->Begin());
		$this->assertEquals($firstEnd, $periods[0]->End());
		$this->assertEquals($secondBegin, $periods[1]->Begin());
		$this->assertEquals($secondEnd, $periods[1]->End());
	}
}
?>