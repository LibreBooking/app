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
		$utc = 'UTC';
		
		$date = Date::Parse('2010-01-02', $userTz);

		$s1 = Date::Parse('2010-01-01 23:00:00', $userTz);
		$e1 = Date::Parse('2010-01-02 02:00:00', $userTz);
		$s2 = Date::Parse('2010-01-02 02:00:00', $userTz);
		$e2 = Date::Parse('2010-01-02 23:00:00', $userTz);
		$s3 = Date::Parse('2010-01-02 23:00:00', $userTz);
		$e3 = Date::Parse('2010-01-03 02:00:00', $userTz);
		
		$r1 = new TestScheduleReservation(1, $s2->ToUtc(), $e2->ToUtc());
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
		$slot2 = new ReservationSlot($s2, $e2, $date, 1, $r1);
		$slot3 = new EmptyReservationSlot($s3, $e3, $date, true);

		$this->assertEquals(3, count($slots));
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
	}
	
	function testCanGetReservationSlotsForSingleDay()
	{
		$userTz = 'America/Chicago';
		$utc = $this->utc;
		
		$date = $this->date;
		
		$s1 = $date->SetTimeString('03:00');
		$e1 = $date->SetTimeString('04:30');
		
		$s2 = $date->SetTimeString('05:00');
		$e2 = $date->SetTimeString('05:30');
		
		$s3 = $date->SetTimeString('08:00');
		$e3 = $date->SetTimeString('12:00');
		
		$r1 = new TestScheduleReservation(1, $s1->ToUtc(), $e1->ToUtc());
		$r2 = new TestScheduleReservation(2, $s2->ToUtc(), $e2->ToUtc());
		$r3 = new TestScheduleReservation(3, $s3->ToUtc(), $e3->ToUtc());
		
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
		$slot4 = new ReservationSlot($expectedSlots[3]->BeginDate(), $expectedSlots[5]->EndDate(), $slotDate, 3, $r1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->BeginDate(), $expectedSlots[6]->EndDate(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->BeginDate(), $expectedSlots[7]->EndDate(), $slotDate, 1, $r2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->BeginDate(), $expectedSlots[8]->EndDate(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->BeginDate(), $expectedSlots[9]->EndDate(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->BeginDate(), $expectedSlots[10]->EndDate(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->BeginDate(), $expectedSlots[11]->EndDate(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->BeginDate(), $expectedSlots[12]->EndDate(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->BeginDate(), $expectedSlots[20]->EndDate(), $slotDate, 8, $r3);
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
		$userTz = 'America/Chicago';
		$utc = $this->utc;
		
		$date = $this->date;		

		$s1 = $date->SetTimeString('03:00');
		$e1 = $date->SetTimeString('04:10');
		
		$s2 = $date->SetTimeString('05:00');
		$e2 = $date->SetTimeString('05:20');
		
		$s3 = $date->SetTimeString('08:00');
		$e3 = $date->SetTimeString('11:55');
		
		$r1 = new TestScheduleReservation(1, $s1->ToUtc(), $e1->ToUtc());
		$r2 = new TestScheduleReservation(2, $s2->ToUtc(), $e2->ToUtc());
		$r3 = new TestScheduleReservation(3, $s3->ToUtc(), $e3->ToUtc());
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $date);
		$slots = $list->BuildSlots();
		
		$slotDate = $date;
		$expectedSlots = $this->testDbLayout->GetLayout($date);
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->BeginDate(), $expectedSlots[0]->EndDate(), $slotDate, $expectedSlots[0]->IsReservable());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->BeginDate(), $expectedSlots[1]->EndDate(), $slotDate, $expectedSlots[1]->IsReservable());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->BeginDate(), $expectedSlots[2]->EndDate(), $slotDate, $expectedSlots[2]->IsReservable());
		$slot4 = new ReservationSlot($expectedSlots[3]->BeginDate(), $expectedSlots[5]->EndDate(), $slotDate, 3, $r1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->BeginDate(), $expectedSlots[6]->EndDate(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->BeginDate(), $expectedSlots[7]->EndDate(), $slotDate, 1, $r2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->BeginDate(), $expectedSlots[8]->EndDate(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->BeginDate(), $expectedSlots[9]->EndDate(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->BeginDate(), $expectedSlots[10]->EndDate(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->BeginDate(), $expectedSlots[11]->EndDate(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->BeginDate(), $expectedSlots[12]->EndDate(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->BeginDate(), $expectedSlots[20]->EndDate(), $slotDate, 8, $r3);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->BeginDate(), $expectedSlots[21]->EndDate(), $slotDate, $expectedSlots[21]->IsReservable());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->BeginDate(), $expectedSlots[22]->EndDate(), $slotDate, $expectedSlots[22]->IsReservable());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->BeginDate(), $expectedSlots[23]->EndDate(), $slotDate, $expectedSlots[23]->IsReservable());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->BeginDate(), $expectedSlots[24]->EndDate(), $slotDate, $expectedSlots[24]->IsReservable());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->BeginDate(), $expectedSlots[25]->EndDate(), $slotDate, $expectedSlots[25]->IsReservable());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->BeginDate(), $expectedSlots[26]->EndDate(), $slotDate, $expectedSlots[26]->IsReservable());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->BeginDate(), $expectedSlots[27]->EndDate(), $slotDate, $expectedSlots[27]->IsReservable());
		//$slot20 = new EmptyReservationSlot($expectedSlots[28]->BeginDate(), $expectedSlots[28]->EndDate(), $slotDate, $expectedSlots[28]->IsReservable());

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
		//$this->assertEquals($slot20, $slots[19]);
		
		die();
	}
	
	public function testReservaionEndingAfterLayoutPeriodAndStartingWithinIsCreatedProperly()
	{
		$this->markTestIncomplete();
		
		$utc = $this->utc;
		$userTz = 'CST';
		$dbDate = $this->dbDate;
		
		$resDate = $dbDate->ToTimezone($userTz)->GetDate();
		$y = $resDate->Year();
		$m = $resDate->Month();
		$d = $resDate->Day();
		
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1->SetStartDate(Date::Create($y, $m, $d, 9, 0, 0, $utc));  // 03:00 CST
		$r1->SetEndDate(Date::Create($y, $m, $d, 10, 40, 0, $utc));  // 04:30 CST
		
		$r2->SetStartDate(Date::Create($y, $m, $d, 11, 0, 0, $utc)); // 05:00 CST
		$r2->SetEndDate(Date::Create($y, $m, $d, 11, 20, 0, $utc));  // 05:20 CST

		$r3->SetStartDate(Date::Create($y, $m, $d + 2, 14, 0, 0, $utc)); // 08:00 CST
		$r3->SetEndDate(Date::Create($y, $m, $d + 2, 18, 05, 0, $utc));  // 12:05 CST
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout($this->date);
		
		$slotDate = $this->date->ToTimezone($userTz)->GetDate();
		
		$slot1 = new EmptyReservationSlot(new Time(0, 0, 0, $userTz), $expectedSlots[0]->End(), $slotDate, $expectedSlots[0]->IsReservable());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->Begin(), $expectedSlots[1]->End(), $slotDate, $expectedSlots[1]->IsReservable());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->Begin(), $expectedSlots[2]->End(), $slotDate, $expectedSlots[2]->IsReservable());
		$slot4 = new ReservationSlot($expectedSlots[3]->Begin(), $expectedSlots[5]->End(), $slotDate, 3, $r1);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->Begin(), $expectedSlots[6]->End(), $slotDate, $expectedSlots[6]->IsReservable());
		$slot6 = new ReservationSlot($expectedSlots[7]->Begin(), $expectedSlots[7]->End(), $slotDate, 1, $r2);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->Begin(), $expectedSlots[8]->End(), $slotDate, $expectedSlots[8]->IsReservable());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->Begin(), $expectedSlots[9]->End(), $slotDate, $expectedSlots[9]->IsReservable());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->Begin(), $expectedSlots[10]->End(), $slotDate, $expectedSlots[10]->IsReservable());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->Begin(), $expectedSlots[11]->End(), $slotDate, $expectedSlots[11]->IsReservable());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->Begin(), $expectedSlots[12]->End(), $slotDate, $expectedSlots[12]->IsReservable());
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), new Time(0, 0, 0, $userTz), $slotDate, 15, $r3);
		
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
	
	public function testReservaionStartingBeforeLayoutPeriodAndEndingAfterLayoutPeriodIsCreatedProperly()
	{
		$this->markTestIncomplete();
		
		$utc = $this->utc;
		$dbDate = $this->dbDate;
		$userTz = 'CST';
		
		$r1 = new TestScheduleReservation(1,
					Date::Parse('2008-11-10 09:00:00', $utc),
					Date::Parse('2008-11-14 10:40:00', $utc));
		
		$reservations = array($r1);
		
		$date = Date::Parse('2008-11-12', $userTz);
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $date);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout($date);
		
		$slot1 = new ReservationSlot(new Time(0,0,0, $userTz), new Time(0,0,0, $userTz), $date, count($expectedSlots), $r1);
		
		$this->assertEquals(1, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
	}
	
	public function testReservationStartingOnSameDayOutsideOfLayoutStartsAtFirstSlot()
	{
		$this->markTestIncomplete();
		
		$utc = $this->utc;
		$layout = new ScheduleLayout($utc);
		$layout->AppendPeriod(new Time(2,0,0, $utc), new Time(3,0,0, $utc));
		
		$y = $this->date->Year();
		$m = $this->date->Month();
		$d = $this->date->Day();
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		
		$r1->SetStartDate(Date::Create($y, $m, $d, 0, 0, 0, $utc));
		$r1->SetEndDate(Date::Create($y, $m, $d, 1, 0, 0, $utc));
		
		$r2 = FakeScheduleReservations::$Reservation2;
		
		$r2->SetStartDate(Date::Create($y, $m, $d, 1, 0, 0, $utc));
		$r2->SetEndDate(Date::Create($y, $m, $d, 3, 0, 0, $utc));
		
		$list = new ScheduleReservationList(array($r1, $r2), $layout, $this->date);
		$slots = $list->BuildSlots();
		
		$slot1 = new ReservationSlot(new Time(2,0,0, $utc), new Time(3,0,0, $utc), $this->date, 1, $r2);
		
		$this->assertEquals(1, count($slots));
		$this->assertEquals($slot1, $slots[0]);
	}
	
	public function testCanTellIfReservationOccursOnSpecifiedDates()
	{
		$startDate = Date::Parse('2009-11-1 0:0:0', 'UTC');
		$endDate = Date::Parse('2009-11-10 1:0:0', 'UTC');
		
		FakeScheduleReservations::Initialize();
		
		$reservation = FakeScheduleReservations::$Reservation1;
		$reservation->SetStartDate($startDate);
		$reservation->SetEndDate($endDate);
		
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
		
		$res1 = new ScheduleReservation(1, Date::Parse('2009-10-09 22:00:00', 'UTC'), Date::Parse('2009-10-09 23:00:00', 'UTC'), 1, null, null, 1, 1, null, null, null);
		// 2009-10-09 17:00:00 - 2009-10-09 18:00:00 CST
		
		$this->assertTrue($res1->OccursOn(Date::Parse('2009-10-09', 'CST')));
	}
	
	public function testReservationDoesNotOccurOnDateIfNoneOfTheReservationOccursAtAnyTimeOnThatDate()
	{
		$d1 = new Date('2009-10-09 22:00:00', 'UTC');	// 2009-10-09 17:00:00 CST
		$d2 = new Date('2009-10-09 23:00:00', 'UTC'); 	// 2009-10-09 18:00:00 CST
		
		$d1Cst = $d1->ToTimezone('CST');
		$d2Cst = $d2->ToTimezone('CST');
		
		$res1 = new ScheduleReservation(1, $d1, $d2, 1, null, null, 1, 1, null, null, null);
		
		$this->assertFalse($res1->OccursOn(Date::Parse('2009-10-10', 'CST')));
	}
	
	public function testDoesNotOccurOnDateIfEndsAtMidnightOfThatDate()
	{
		$date = new Date('2010-01-01 00:00:00', 'UTC');
		
		$builder = new ScheduleReservationBuilder();
		$builder
			->WithStartDate($date->AddDays(-1))
			->WithEndDate($date);
		
		$res = $builder->Build();
		
		$this->assertTrue($res->OccursOn($date->AddDays(-1)));
		$this->assertFalse($res->OccursOn($date));
	}
	
	public function testTwentyFourHourReservationsCrossDay()
	{
		$this->markTestIncomplete();
		
		$timezone = 'America/Chicago';
		$layout = new ScheduleLayout($timezone);
		$layout->AppendPeriod(Time::Parse('0:00', $timezone), Time::Parse('4:00', $timezone));
		$layout->AppendPeriod(Time::Parse('4:00', $timezone), Time::Parse('12:00', $timezone));
		$layout->AppendPeriod(Time::Parse('12:00', $timezone), Time::Parse('18:00', $timezone));
		$layout->AppendPeriod(Time::Parse('18:00', $timezone), Time::Parse('20:00', $timezone));
		$layout->AppendPeriod(Time::Parse('20:00', $timezone), Time::Parse('0:00', $timezone));
		
		$date = new Date('2010-01-02', $timezone);
		
		$r1 = new TestScheduleReservation(
			1, 
			Date::Parse('2010-01-01 00:00:00', 'UTC'),
			Date::Parse('2010-01-02 00:00:00', 'UTC'),
			1);
		$r2 = new TestScheduleReservation(
			2, 
			Date::Parse('2010-01-02 00:00:00', 'UTC'),
			Date::Parse('2010-01-03 00:00:00', 'UTC'), 
			1);
		$r3 = new TestScheduleReservation(
			3, 
			Date::Parse('2010-01-03 00:00:00', 'UTC'),
			Date::Parse('2010-01-04 00:00:00', 'UTC'), 
			1);
			
		$list = new ScheduleReservationList(array($r1, $r2, $r3), $layout, $date);

		$slots = $list->BuildSlots();
		
		$this->assertEquals(2, count($slots));
		$this->assertEquals($slots[0]->Begin(), new Time(0, 0, 0, $timezone));
		$this->assertEquals($slots[1]->Begin(), new Time(18, 0, 0, $timezone));
	}
	
	public function testBindsSingleReservation()
	{
		$this->markTestIncomplete();
		
		$tz = 'CST';
		$listDate = Date::Parse('2011-02-06', $tz);
		
		$layout = new ScheduleLayout($tz);
		$layout->AppendPeriod(Time::Parse('0:00', $tz), Time::Parse('2:00', $tz));
		$layout->AppendPeriod(Time::Parse('2:00', $tz), Time::Parse('6:00', $tz));
		$layout->AppendPeriod(Time::Parse('6:00', $tz), Time::Parse('12:00', $tz));
		$layout->AppendPeriod(Time::Parse('12:00', $tz), Time::Parse('18:00', $tz));
		$layout->AppendPeriod(Time::Parse('18:00', $tz), Time::Parse('0:00', $tz));		
		
		$r1 = new TestScheduleReservation(
			1, 
			Date::Parse('2011-02-06 12:00:00', 'UTC'),
			Date::Parse('2011-02-06 18:00:00', 'UTC'),
			1);
		
		$list = new ScheduleReservationList(array($r1), $layout, $listDate);

		$slots = $list->BuildSlots();
		
		$this->assertEquals(5, count($slots));
		$this->assertEquals(new ReservationSlot(Time::Parse('6:00', $tz), Time::Parse('12:00', $tz), $listDate, 1, $r1), $slots[2]);
	}
}

class ScheduleReservationBuilder
{
	public $reservationId;
	public $startDate;
	public $endDate;
	public $reservationType;
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
		$this->reservationType = ReservationTypes::Reservation;
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
	
	public function Build()
	{
		return new ScheduleReservation(
				$this->reservationId,
				$this->startDate,
				$this->endDate,
				$this->reservationType,
				$this->summary,
				null,
				$this->resourceId,
				$this->userId,
				$this->firstName ,
				$this->lastName,
				$this->referenceNumber);
	}
}