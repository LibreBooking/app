<?php

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ScheduleReservationListTests extends TestBase
{
	private $utc;
	private $userTz;
	
	/**
     * @var Date
	 */
	private $date;
	
	/**
     * @var ScheduleLayout
	 */
	private $testDbLayout;
	
	public function setup()
	{
		parent::setup();
		
		$utc = 'UTC';
		$userTz = 'America/Chicago';
		
		$this->utc = $utc;
		$this->userTz = $userTz;
		
		$date = Date::Parse('2008-11-11', $userTz);
		$this->date = $date;
		
		$layout = new ScheduleLayout($userTz);
		
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $userTz), new Time(2, 0, 0, $userTz));
		
		for ($hour = 2; $hour <= 14; $hour++)
		{
			$layout->AppendPeriod(new Time($hour, 0, 0, $userTz), new Time($hour, 30, 0 , $userTz));
			$layout->AppendPeriod(new Time($hour, 30, 0, $userTz), new Time($hour + 1, 0, 0, $userTz));
		}
		
		$layout->AppendBlockedPeriod(new Time(15, 0, 0, $userTz), new Time(0, 0, 0, $userTz));
		
		$this->testDbLayout = $layout;
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	function testLayoutIsConvertedToUserTimezoneBeforeSlotsAreCreated()
	{
		$userTz = 'America/Chicago';
		$date = Date::Parse('2010-01-02', $userTz);

		$s1 = Date::Parse('2010-01-01 23:00:00', $userTz);
		$e1 = Date::Parse('2010-01-02 02:00:00', $userTz);
		$s2 = Date::Parse('2010-01-02 02:00:00', $userTz);
		$e2 = Date::Parse('2010-01-02 23:00:00', $userTz);
		$s3 = Date::Parse('2010-01-02 23:00:00', $userTz);
		$e3 = Date::Parse('2010-01-03 02:00:00', $userTz);

		$item = new ReservationItemView(1, $s2->ToUtc(), $e2->ToUtc());
		$r1 = new ReservationListItem($item);
		$layoutPeriods[] = new NonSchedulePeriod($s1, $e1);
		$layoutPeriods[] = new SchedulePeriod($s2, $e2);
		$layoutPeriods[] = new SchedulePeriod($s3, $e3);
		
		$layout = $this->getMock('IScheduleLayout');
		$layout->expects($this->once())
			->method('Timezone')
			->will($this->returnValue($userTz));
			
		$layout->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($date))
			->will($this->returnValue($layoutPeriods));
		
		$scheduleList = new ScheduleReservationList(array($r1), $layout, $date);
		$slots = $scheduleList->BuildSlots();
	
		$slot1 = new EmptyReservationSlot($s1, $e1, $date, false);
		$slot2 = new ReservationSlot($s2, $e2, $date, 1, $item);
		$slot3 = new EmptyReservationSlot($s3, $e3, $date, true);

		$this->assertEquals(3, count($slots));
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
	}
	
	function testCanGetReservationSlotsForSingleDay()
	{
		$date = $this->date;
		
		$s1 = $date->SetTimeString('03:00');
		$e1 = $date->SetTimeString('04:30');
		
		$s2 = $date->SetTimeString('05:00');
		$e2 = $date->SetTimeString('05:30');
		
		$s3 = $date->SetTimeString('08:00');
		$e3 = $date->SetTimeString('12:00');

		$item1 = new TestReservationItemView(1, $s1->ToUtc(), $e1->ToUtc());
		$item2 = new TestReservationItemView(2, $s2->ToUtc(), $e2->ToUtc());
		$item3 = new TestReservationItemView(3, $s3->ToUtc(), $e3->ToUtc());
		$r1 = new ReservationListItem($item1);
		$r2 = new ReservationListItem($item2);
		$r3 = new ReservationListItem($item3);
		
		$reservations = array($r1, $r2, $r3);
		
//		printf("%s\n", Date::Now()->ToString());
	
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
//		printf("%s\n", Date::Now()->ToString());
		
		$slotDate = $this->date;
		$expectedSlots = $this->testDbLayout->GetLayout($this->date);
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->BeginDate(), $expectedSlots[0]->EndDate(), $slotDate, $expectedSlots[0]->IsReservable());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->BeginDate(), $expectedSlots[1]->EndDate(), $slotDate, $expectedSlots[1]->IsReservable());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->BeginDate(), $expectedSlots[2]->EndDate(), $slotDate, $expectedSlots[2]->IsReservable());
		$slot4 = new ReservationSlot($expectedSlots[3]->BeginDate(), $expectedSlots[5]->EndDate(), $slotDate, 3, $item1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->BeginDate(), $expectedSlots[6]->EndDate(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->BeginDate(), $expectedSlots[7]->EndDate(), $slotDate, 1, $item2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->BeginDate(), $expectedSlots[8]->EndDate(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->BeginDate(), $expectedSlots[9]->EndDate(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->BeginDate(), $expectedSlots[10]->EndDate(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->BeginDate(), $expectedSlots[11]->EndDate(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->BeginDate(), $expectedSlots[12]->EndDate(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->BeginDate(), $expectedSlots[20]->EndDate(), $slotDate, 8, $item3);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->BeginDate(), $expectedSlots[21]->EndDate(), $slotDate, $expectedSlots[21]->IsReservable());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->BeginDate(), $expectedSlots[22]->EndDate(), $slotDate, $expectedSlots[22]->IsReservable());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->BeginDate(), $expectedSlots[23]->EndDate(), $slotDate, $expectedSlots[23]->IsReservable());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->BeginDate(), $expectedSlots[24]->EndDate(), $slotDate, $expectedSlots[24]->IsReservable());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->BeginDate(), $expectedSlots[25]->EndDate(), $slotDate, $expectedSlots[25]->IsReservable());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->BeginDate(), $expectedSlots[26]->EndDate(), $slotDate, $expectedSlots[26]->IsReservable());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->BeginDate(), $expectedSlots[27]->EndDate(), $slotDate, $expectedSlots[27]->IsReservable());

		$expectedNumberOfSlots = 19;	
		
		$this->assertEquals($expectedNumberOfSlots, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
		$this->assertEquals($slot4, $slots[3]);
		$this->assertEquals($slot5, $slots[4]);
		$this->assertEquals($slot6, $slots[5]);
		$this->assertEquals($slot7, $slots[6]);
		$this->assertEquals($slot8, $slots[7]);
		$this->assertEquals($slot9, $slots[8]);
		$this->assertEquals($slot10, $slots[9]);
		$this->assertEquals($slot11, $slots[10]);
		$this->assertEquals($slot12, $slots[11]);
		$this->assertEquals($slot13, $slots[12]);
		$this->assertEquals($slot14, $slots[13]);
		$this->assertEquals($slot15, $slots[14]);
		$this->assertEquals($slot16, $slots[15]);
		$this->assertEquals($slot17, $slots[16]);
		$this->assertEquals($slot18, $slots[17]);
		$this->assertEquals($slot19, $slots[18]);
	}
	
	public function testFitsReservationToLayoutIfReservationEndingTimeIsNotAtSlotBreak()
	{
		$date = $this->date;		

		$s1 = $date->SetTimeString('03:00');
		$e1 = $date->SetTimeString('04:10');
		
		$s2 = $date->SetTimeString('05:00');
		$e2 = $date->SetTimeString('05:20');
		
		$s3 = $date->SetTimeString('08:00');
		$e3 = $date->SetTimeString('11:55');

		$item1 = new TestReservationItemView(1, $s1->ToUtc(), $e1->ToUtc());
		$item2 = new TestReservationItemView(2, $s2->ToUtc(), $e2->ToUtc());
		$item3 = new TestReservationItemView(3, $s3->ToUtc(), $e3->ToUtc());
		$r1 = new ReservationListItem($item1);
		$r2 = new ReservationListItem($item2);
		$r3 = new ReservationListItem($item3);
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $date);
		$slots = $list->BuildSlots();
		
		$slotDate = $date;
		$expectedSlots = $this->testDbLayout->GetLayout($date);
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->BeginDate(), $expectedSlots[0]->EndDate(), $slotDate, $expectedSlots[0]->IsReservable());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->BeginDate(), $expectedSlots[1]->EndDate(), $slotDate, $expectedSlots[1]->IsReservable());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->BeginDate(), $expectedSlots[2]->EndDate(), $slotDate, $expectedSlots[2]->IsReservable());
		$slot4 = new ReservationSlot($expectedSlots[3]->BeginDate(), $expectedSlots[5]->EndDate(), $slotDate, 3, $item1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->BeginDate(), $expectedSlots[6]->EndDate(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->BeginDate(), $expectedSlots[7]->EndDate(), $slotDate, 1, $item2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->BeginDate(), $expectedSlots[8]->EndDate(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->BeginDate(), $expectedSlots[9]->EndDate(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->BeginDate(), $expectedSlots[10]->EndDate(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->BeginDate(), $expectedSlots[11]->EndDate(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->BeginDate(), $expectedSlots[12]->EndDate(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->BeginDate(), $expectedSlots[20]->EndDate(), $slotDate, 8, $item3);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->BeginDate(), $expectedSlots[21]->EndDate(), $slotDate, $expectedSlots[21]->IsReservable());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->BeginDate(), $expectedSlots[22]->EndDate(), $slotDate, $expectedSlots[22]->IsReservable());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->BeginDate(), $expectedSlots[23]->EndDate(), $slotDate, $expectedSlots[23]->IsReservable());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->BeginDate(), $expectedSlots[24]->EndDate(), $slotDate, $expectedSlots[24]->IsReservable());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->BeginDate(), $expectedSlots[25]->EndDate(), $slotDate, $expectedSlots[25]->IsReservable());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->BeginDate(), $expectedSlots[26]->EndDate(), $slotDate, $expectedSlots[26]->IsReservable());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->BeginDate(), $expectedSlots[27]->EndDate(), $slotDate, $expectedSlots[27]->IsReservable());
		
		$expectedNumberOfSlots = 19;	
		
		$this->assertEquals($expectedNumberOfSlots, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
		$this->assertEquals($slot4, $slots[3], 'reservation does not end on a slot break, so it should scale back to the closest ending slot time');
		$this->assertEquals($slot5, $slots[4]);
		$this->assertEquals($slot6, $slots[5], 'reservation does not end on a slot break, but it needs to span at least 1 cell');
		$this->assertEquals($slot7, $slots[6]);
		$this->assertEquals($slot8, $slots[7]);
		$this->assertEquals($slot9, $slots[8]);
		$this->assertEquals($slot10, $slots[9]);
		$this->assertEquals($slot11, $slots[10]);
		$this->assertEquals($slot12, $slots[11], 'reservation does not end on a slot break, so it should scale back to the closest ending slot time');
		$this->assertEquals($slot13, $slots[12]);
		$this->assertEquals($slot14, $slots[13]);
		$this->assertEquals($slot15, $slots[14]);
		$this->assertEquals($slot16, $slots[15]);
		$this->assertEquals($slot17, $slots[16]);
		$this->assertEquals($slot18, $slots[17]);
		$this->assertEquals($slot19, $slots[18]);
	}
	
	public function testReservationEndingAfterLayoutPeriodAndStartingWithinIsCreatedProperly()
	{
		$date = $this->date;	
		
		$s1 = $date->SetTimeString('03:00');
		$e1 = $date->SetTimeString('04:10');
		
		$s2 = $date->SetTimeString('05:00');
		$e2 = $date->SetTimeString('05:20');
		
		$s3 = $date->SetTimeString('08:00');
		$e3 = $date->AddDays(2)->SetTimeString('11:55');

		$item1 = new TestReservationItemView(1, $s1->ToUtc(), $e1->ToUtc());
		$item2 = new TestReservationItemView(2, $s2->ToUtc(), $e2->ToUtc());
		$item3 = new TestReservationItemView(3, $s3->ToUtc(), $e3->ToUtc());
		$r1 = new ReservationListItem($item1);
		$r2 = new ReservationListItem($item2);
		$r3 = new ReservationListItem($item3);
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $date);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout($date);
		
		$slotDate = $date;
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->BeginDate(), $expectedSlots[0]->EndDate(), $slotDate, $expectedSlots[0]->IsReservable());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->BeginDate(), $expectedSlots[1]->EndDate(), $slotDate, $expectedSlots[1]->IsReservable());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->BeginDate(), $expectedSlots[2]->EndDate(), $slotDate, $expectedSlots[2]->IsReservable());
		$slot4 = new ReservationSlot($expectedSlots[3]->BeginDate(), $expectedSlots[5]->EndDate(), $slotDate, 3, $item1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->BeginDate(), $expectedSlots[6]->EndDate(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->BeginDate(), $expectedSlots[7]->EndDate(), $slotDate, 1, $item2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->BeginDate(), $expectedSlots[8]->EndDate(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->BeginDate(), $expectedSlots[9]->EndDate(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->BeginDate(), $expectedSlots[10]->EndDate(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->BeginDate(), $expectedSlots[11]->EndDate(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->BeginDate(), $expectedSlots[12]->EndDate(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->BeginDate(), $date->AddDays(1), $slotDate, 15, $item3);
		
		$this->assertEquals(12, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
		$this->assertEquals($slot4, $slots[3]);
		$this->assertEquals($slot5, $slots[4]);
		$this->assertEquals($slot6, $slots[5]);
		$this->assertEquals($slot7, $slots[6]);
		$this->assertEquals($slot8, $slots[7]);
		$this->assertEquals($slot9, $slots[8]);
		$this->assertEquals($slot10, $slots[9]);
		$this->assertEquals($slot11, $slots[10]);
		$this->assertEquals($slot12, $slots[11], $slot12 . ' ' . $slots[11]);
	}
	
	public function testReservationStartingBeforeLayoutPeriodAndEndingAfterLayoutPeriodIsCreatedProperly()
	{
		$userTz = 'America/Chicago';
		$date = Date::Parse('2008-11-12', $userTz);

		$item = new TestReservationItemView(1, $date->AddDays(-1)->ToUtc(), $date->AddDays(1)->ToUtc());
		$r1 = new ReservationListItem($item);
		
		$reservations = array($r1);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $date);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout($date);
		
		$totalSlotsInDay = count($expectedSlots);
		$slot1 = new ReservationSlot($expectedSlots[0]->BeginDate(), $expectedSlots[$totalSlotsInDay-1]->EndDate(), $date, $totalSlotsInDay, $item);
		
		$this->assertEquals(1, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
	}
	
	public function testReservationStartingBeforeAndEndingOnDateStartsAtFirstSlot()
	{
		$userTz = 'America/Chicago';
		$layoutTz = 'America/New_York';
		$date = Date::Parse('2008-11-12', $userTz);
		
		$layout = new ScheduleLayout($userTz);
		$layout->AppendPeriod(new Time(0,0,0, $layoutTz), new Time(6,0,0, $layoutTz));
		$layout->AppendPeriod(new Time(6,0,0, $layoutTz), new Time(8,0,0, $layoutTz));
		$layout->AppendPeriod(new Time(8,0,0, $layoutTz), new Time(12,0,0, $layoutTz));
		$layout->AppendPeriod(new Time(12,0,0, $layoutTz), new Time(18,0,0, $layoutTz));
		$layout->AppendPeriod(new Time(18,0,0, $layoutTz), new Time(0,0,0, $layoutTz));

		$item = new TestReservationItemView(1, $date->AddDays(-1)->ToUtc(), Date::Parse('2008-11-12 6:0:0', $layoutTz)->ToUtc());
		$r1 = new ReservationListItem($item);
		
		$list = new ScheduleReservationList(array($r1), $layout, $date);
		$slots = $list->BuildSlots();
		
		$s1Begin = Date::Parse('2008-11-12 0:0:0', $layoutTz)->ToTimezone($userTz);
		$s1End = Date::Parse('2008-11-12 6:0:0', $layoutTz)->ToTimezone($userTz);
		
		$s6Begin = Date::Parse('2008-11-13 0:0:0', $layoutTz)->ToTimezone($userTz);
		$s6End = Date::Parse('2008-11-13 6:0:0', $layoutTz)->ToTimezone($userTz);
		
		$slot1 = new ReservationSlot($s1Begin, $s1End, $date, 1, $item);
		$slot6 = new EmptyReservationSlot($s6Begin, $s6End, $date, true);
		
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot6, $slots[5]);
	}
	
	public function testCanTellIfReservationOccursOnSpecifiedDates()
	{
		$startDate = Date::Parse('2009-11-1 0:0:0', 'UTC');
		$endDate = Date::Parse('2009-11-10 1:0:0', 'UTC');
		
		$reservation = new ReservationItemView(1, $startDate, $endDate);
		
		$this->assertTrue($reservation->OccursOn($startDate));
		$this->assertTrue($reservation->OccursOn($startDate->AddDays(2)));
		$this->assertTrue($reservation->OccursOn($endDate));
		
		$this->assertFalse($reservation->OccursOn($startDate->AddDays(-2)));
		$this->assertFalse($reservation->OccursOn($endDate->AddDays(2)));
		
		$this->assertFalse($reservation->OccursOn($startDate->AddDays(-2)));
		$this->assertFalse($reservation->OccursOn($endDate->AddDays(2)));
		
		$this->assertTrue($reservation->OccursOn($startDate->ToTimezone('US/Central')));
		$this->assertTrue($reservation->OccursOn($endDate->ToTimezone('US/Central')));
	}
	
	public function testReservationShouldOccurOnDateIfTheReservationStartsAtAnyTimeOnThatDate()
	{
		$d1 = Date::Parse('2009-10-10 05:00:00', 'UTC');
		$d2 = Date::Parse('2009-10-10 00:00:00', 'CST');
		
		$this->assertEquals($d1->Timestamp(), $d2->Timestamp());
		
		$res1 = new ReservationItemView(1, Date::Parse('2009-10-09 22:00:00', 'UTC'), Date::Parse('2009-10-09 23:00:00', 'UTC'));
		// 2009-10-09 17:00:00 - 2009-10-09 18:00:00 CST
		
		$this->assertTrue($res1->OccursOn(Date::Parse('2009-10-09', 'CST')));
	}
	
	public function testReservationDoesNotOccurOnDateIfNoneOfTheReservationOccursAtAnyTimeOnThatDate()
	{
		$d1 = new Date('2009-10-09 22:00:00', 'UTC');	// 2009-10-09 17:00:00 CST
		$d2 = new Date('2009-10-09 23:00:00', 'UTC'); 	// 2009-10-09 18:00:00 CST
		
		$res1 = new ReservationItemView(1, $d1, $d2);
		
		$this->assertFalse($res1->OccursOn(Date::Parse('2009-10-10', 'CST')));
	}
	
	public function testDoesNotOccurOnDateIfEndsAtMidnightOfThatDate()
	{
		$date = new Date('2010-01-01 00:00:00', 'UTC');
		
		$builder = new ReservationItemViewBuilder();
		$builder
			->WithStartDate($date->AddDays(-1))
			->WithEndDate($date);
		
		$res = $builder->Build();
		
		$this->assertTrue($res->OccursOn($date->AddDays(-1)));
		$this->assertFalse($res->OccursOn($date));
	}
	
	public function testTwentyFourHourReservationsCrossDay()
	{
		$timezone = 'America/Chicago';
		$layout = new ScheduleLayout($timezone);
		$layout->AppendPeriod(Time::Parse('0:00', $timezone), Time::Parse('4:00', $timezone));
		$layout->AppendPeriod(Time::Parse('4:00', $timezone), Time::Parse('12:00', $timezone));
		$layout->AppendPeriod(Time::Parse('12:00', $timezone), Time::Parse('18:00', $timezone));
		$layout->AppendPeriod(Time::Parse('18:00', $timezone), Time::Parse('20:00', $timezone));
		$layout->AppendPeriod(Time::Parse('20:00', $timezone), Time::Parse('0:00', $timezone));
		
		$date = new Date('2010-01-02', $timezone);
		
		$r1 = new ReservationListItem(new TestReservationItemView(
			1, 
			Date::Parse('2010-01-01 00:00:00', 'UTC'),
			Date::Parse('2010-01-02 00:00:00', 'UTC'),
			1));
		$r2 = new ReservationListItem(new TestReservationItemView(
			2, 
			Date::Parse('2010-01-02 00:00:00', 'UTC'),
			Date::Parse('2010-01-03 00:00:00', 'UTC'), 
			1));
		$r3 = new ReservationListItem(new TestReservationItemView(
			3, 
			Date::Parse('2010-01-03 00:00:00', 'UTC'),
			Date::Parse('2010-01-04 00:00:00', 'UTC'), 
			1));
			
		$list = new ScheduleReservationList(array($r1, $r2, $r3), $layout, $date);

		$slots = $list->BuildSlots();
		
		$this->assertEquals(2, count($slots));
		$this->assertEquals($slots[0]->Begin(), new Time(0, 0, 0, $timezone));
		$this->assertEquals($slots[1]->Begin(), new Time(18, 0, 0, $timezone));
	}
	
	public function testBindsSingleReservation()
	{
		$tz = 'America/Chicago';
		$listDate = Date::Parse('2011-02-06', $tz);
		
		$layout = new ScheduleLayout($tz);
		$layout->AppendPeriod(Time::Parse('0:00', $tz), Time::Parse('2:00', $tz));
		$layout->AppendPeriod(Time::Parse('2:00', $tz), Time::Parse('6:00', $tz));
		$layout->AppendPeriod(Time::Parse('6:00', $tz), Time::Parse('12:00', $tz));
		$layout->AppendPeriod(Time::Parse('12:00', $tz), Time::Parse('18:00', $tz));
		$layout->AppendPeriod(Time::Parse('18:00', $tz), Time::Parse('0:00', $tz));

		$item = new TestReservationItemView(
			1,
			Date::Parse('2011-02-06 12:00:00', $tz)->ToUtc(),
			Date::Parse('2011-02-06 18:00:00', $tz)->ToUtc(),
			1);
		$r1 = new ReservationListItem($item);
		
		$list = new ScheduleReservationList(array($r1), $layout, $listDate);

		$slots = $list->BuildSlots();
		
		$this->assertEquals(5, count($slots));
		$this->assertEquals(new ReservationSlot($listDate->SetTimeString("12:00"), $listDate->SetTimeString("18:00"), $listDate, 1, $item), $slots[3]);
	}
}

class ReservationItemViewBuilder
{
	public $reservationId;
	public $startDate;
	public $endDate;
	public $summary;
	public $resourceId;
	public $userId;
	public $firstName;
	public $lastName;
	public $referenceNumber;
	
	public function __construct()
	{
		$this->reservationId = 1;
		$this->startDate = Date::Now();
		$this->endDate = Date::Now();
		$this->summary = 'summary';
		$this->resourceId = 10;
		$this->userId = 100;
		$this->firstName = 'first';
		$this->lastName = 'last';
		$this->referenceNumber = 'referenceNumber';
	}
	
	public function WithStartDate(Date $startDate)
	{
		$this->startDate = $startDate;
		return $this;
	}
	
	public function WithEndDate(Date $endDate)
	{
		$this->endDate = $endDate;
		return $this;
	}	

	/**
	 * @return ReservationItemView
	 */
	public function Build()
	{
		return new ReservationItemView(
				$this->referenceNumber,
				$this->startDate,
				$this->endDate,
				null,
				$this->resourceId,
				$this->reservationId,
				null,
				null,
				$this->summary,
				null,
				$this->firstName,
				$this->lastName,
				$this->userId
				);
	}
}