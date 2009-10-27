<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ScheduleLayoutTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	function testLayoutFoo()
	{
		$cst = 'US/Central';
		$utc = 'UTC';
		
		$layout = new ScheduleLayout($cst);
		
		for ($i = 3; $i < 21; $i++)
		{
			$start = $i;
			$end = $i+1;
			$layout->AppendPeriod(Time::Parse("$start:00", $utc), Time::Parse("$end:00", $utc));
		}
		
		$slots = $layout->GetLayout();
		$this->assertEquals(18, count($slots));
	}
	
	function testLayoutCanBeCreatedAsCSTFromUTCTimes()
	{
		$userTz = 'CST';
		$utc = 'UTC';
		
		$t1s = new Time(0, 0, 0, $utc);
		$t1e = new Time(1, 0, 0, $utc);
		$t2e = new Time(3, 0, 0, $utc);
		
		$layout = new ScheduleLayout($userTz);
		$layout->AppendBlockedPeriod($t1s, $t1e);
		$layout->AppendPeriod($t1e, $t2e);
		$layout->AppendBlockedPeriod($t2e, $t1s);

		$slots = $layout->GetLayout();
		$this->assertEquals(4, count($slots), '3:00 UTC - 0:00 UTC crosses midnight when converted to CST');
		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[0]->Begin());
		$this->assertEquals($t1s->ToTimezone($userTz), $slots[0]->End());
		
		$this->assertEquals($t1s->ToTimezone($userTz), $slots[1]->Begin(), $slots[1]->Begin()->ToString());
		$this->assertEquals($t1e->ToTimezone($userTz), $slots[1]->End(), $slots[1]->End()->ToString());
		
		$this->assertEquals($t1e->ToTimezone($userTz), $slots[2]->Begin());
		$this->assertEquals($t2e->ToTimezone($userTz), $slots[2]->End());
		
		$this->assertEquals($t2e->ToTimezone($userTz), $slots[3]->Begin());
		$this->assertEquals(new Time(0, 0, 0, $userTz), $slots[3]->End());
	}
	
	public function testCreatesScheduleLayoutInProperOrder()
	{	
		$utc = 'CST';
		
		$time1 = Time::Parse('07:00', $utc);
		$time2 = Time::Parse('07:45', $utc);
		$time3 = Time::Parse('08:30', $utc);
		$time4 = Time::Parse('13:00', $utc);
		
		$layout = new ScheduleLayout($utc);
		
		$layout->AppendPeriod($time1, $time2);
		$layout->AppendPeriod($time3, $time4);
		$layout->AppendPeriod($time2, $time3, 'Period 1');
		
		$periods = $layout->GetLayout();
		
		$this->assertEquals(3, count($periods));
		$period1 = new SchedulePeriod($time1, $time2);
		$period2 = new SchedulePeriod($time2, $time3, 'Period 1');
		$period3 = new SchedulePeriod($time3, $time4);
		
		$this->assertEquals($period1, $periods[0], $period1 . ' ' . $periods[0]);
		$this->assertEquals($period2, $periods[1], $period2 . ' ' . $periods[1]);
		$this->assertEquals($period3, $periods[2]);
	}
	
	public function testCreatingScheduleLayoutForDatabaseConvertsToGmtAndAddsTimesIfNeeded()
	{
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
		
		$periods = $layoutForDb->GetLayout();
		
		$this->assertEquals(5, count($periods));
		$this->assertEquals(new NonSchedulePeriod(Time::Parse('00:00')->ToUtc(), $time1Gmt), $periods[0], $periods[0]);
		$this->assertEquals(new SchedulePeriod($time1Gmt, $time2Gmt), $periods[1]);
		$this->assertEquals(new SchedulePeriod($time2Gmt, $time3Gmt, 'Period 1'), $periods[2]);
		$this->assertEquals(new SchedulePeriod($time3Gmt, $time4Gmt), $periods[3]);
		$this->assertEquals(new NonSchedulePeriod($time4Gmt, Time::Parse('00:00')->ToUtc()), $periods[4]);
	}
}
?>