<?php

require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ScheduleReservationListTests extends TestBase
{
	private $tz;
	private $userTz;
	private $dbDate;
	private $date;
	private $testDbLayout;
	
	public function setup()
	{
		parent::setup();
		
		$tz = 'UTC';
		$dbDate = '2008-11-11';
		$userTz = 'CST';
		
		$this->tz = $tz;
		$this->userTz = $userTz;
		
		$this->dbDate = $dbDate;
		$this->date = Date::Parse($dbDate, $tz);
		
		$layout = new ScheduleLayout($userTz);
		
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $tz), new Time(8, 0, 0, $tz));
		
		for ($hour = 8; $hour <= 20; $hour++)
		{
			$layout->AppendPeriod(new Time($hour, 0, 0, $tz), new Time($hour, 30, 0 , $tz));
			$layout->AppendPeriod(new Time($hour, 30, 0, $tz), new Time($hour + 1, 0, 0, $tz));
		}
		
		$layout->AppendBlockedPeriod(new Time(21, 0, 0, $tz), new Time(0, 0, 0, $tz));
		
		$this->testDbLayout = $layout;
	}
	
	public function teardown()
	{
		parent::teardown();
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
	
	function testLayoutIsConvertedToUserTimezoneBeforeSlotsAreCreated()
	{
		$userTz = 'CST';
		$utc = 'UTC';
		
		$midnightUtc = new Time(0,0,0, $utc);
		$midnightCst = new Time(0, 0, 0, $userTz);
		
		$hourDifference = (0 - $midnightUtc->ToTimezone($userTz)->Hour() + 24) ;
		
		$layout = new ScheduleLayout($userTz);
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $utc), new Time(1, 0, 0, $utc));
		$layout->AppendPeriod(new Time(1, 0, 0, $utc), new Time(3, 0, 0, $utc));
		$layout->AppendBlockedPeriod(new Time(3, 0, 0, $utc), new Time(0, 0, 0, $utc));
		
		$slots = $layout->GetLayout();
		$this->assertEquals(4, count($slots));
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r1->SetStartDate($this->dbDate);
		$r1->SetStartTime('01:00:00');
		$r1->SetEndDate($this->dbDate);
		$r1->SetEndTime('03:00:00');
		
		$scheduleList = new ScheduleReservationList(array($r1), $layout, $this->date, $userTz);
		$slots = $scheduleList->BuildSlots();
		
		$t1s = new Time(0,0,0, $utc);
		$t1e = new Time(1,0,0, $utc);
		$t2e = new Time(3,0,0, $utc);
		$t3e = new Time(0,0,0, $utc);
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $userTz), $t1s->ToTimezone($userTz));
		$slot2 = new EmptyReservationSlot($t1s->ToTimezone($userTz), $t1e->ToTimezone($userTz));
		$slot3 = new ReservationSlot($t1e->ToTimezone($userTz), $t2e->ToTimezone($userTz), 1);
		$slot4 = new EmptyReservationSlot($t2e->ToTimezone($userTz), new Time(0,0,0, $userTz));
		
		$this->assertEquals(4, count($slots));
		$this->assertEquals($slot1, $slots[0]);
		$this->assertEquals($slot2, $slots[1]);
		$this->assertEquals($slot3, $slots[2]);
		$this->assertEquals($slot4, $slots[3]);	
	}
	
	function testCanGetReservationSlotsForSingleDay()
	{
		$userTz = $this->userTz;
		$dbDate = $this->dbDate;
		$tz = $this->tz;
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1Start = '09:00:00';		// 03:00 CST
		$r1End = '10:30:00';		// 04:30 CST
		
		$r2Start = '11:00:00';		// 05:00 CST
		$r2End = '11:30:00';		// 05:30 CST
		
		$r3Start = '14:00:00';		// 08:00 CST
		$r3End = '18:00:00';		// 12:00 CST
		
		$r1->SetStartTime($r1Start);
		$r1->SetEndTime($r1End);
		$r1->SetStartDate($dbDate);
		$r1->SetEndDate($dbDate);
		
		$r2->SetStartTime($r2Start);
		$r2->SetEndTime($r2End);
		$r2->SetStartDate($dbDate);
		$r2->SetEndDate($dbDate);
		
		$r3->SetStartTime($r3Start);
		$r3->SetEndTime($r3End);
		$r3->SetStartDate($dbDate);
		$r3->SetEndDate($dbDate);
		
		$reservations = array($r1, $r2, $r3);
		
//		printf("%s\n", Date::Now()->ToString());
	
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date, $userTz);
		$slots = $list->BuildSlots();
		
//		printf("%s\n", Date::Now()->ToString());
		
		$expectedSlots = $this->testDbLayout->GetLayout();
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[0]->End());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->Begin(), $expectedSlots[1]->End());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->Begin(), $expectedSlots[2]->End());
		$slot4 = new ReservationSlot($expectedSlots[3]->Begin(), $expectedSlots[5]->End(), 3);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->Begin(), $expectedSlots[6]->End());
		$slot6 = new ReservationSlot($expectedSlots[7]->Begin(), $expectedSlots[7]->End(), 1);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->Begin(), $expectedSlots[8]->End());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->Begin(), $expectedSlots[9]->End());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->Begin(), $expectedSlots[10]->End());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->Begin(), $expectedSlots[11]->End());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->Begin(), $expectedSlots[12]->End());
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), $expectedSlots[20]->End(), 8);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->Begin(), $expectedSlots[21]->End());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->Begin(), $expectedSlots[22]->End());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->Begin(), $expectedSlots[23]->End());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->Begin(), $expectedSlots[24]->End());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->Begin(), $expectedSlots[25]->End());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->Begin(), $expectedSlots[26]->End());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->Begin(), $expectedSlots[27]->End());
		$slot20 = new EmptyReservationSlot($expectedSlots[28]->Begin(), $expectedSlots[28]->End());

		$expectedNumberOfSlots = 20;	
		
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
		$this->assertEquals($slot20, $slots[19]);
	}
	
	public function testFitsReservationToLayoutIfReservationEndingTimeIsNotAtSlotBreak()
	{
		$userTz = $this->userTz;
		$dbDate = $this->dbDate;
		$tz = $this->tz;
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1Start = '09:00:00';		// 03:00 CST
		$r1End = '10:40:00';		// 04:40 CST
		
		$r2Start = '11:00:00';		// 05:00 CST
		$r2End = '11:20:00';		// 05:20 CST
		
		$r3Start = '14:00:00';		// 08:00 CST
		$r3End = '18:05:00';		// 12:05 CST
		
		$r1->SetStartTime($r1Start);
		$r1->SetEndTime($r1End);
		$r1->SetStartDate($dbDate);
		$r1->SetEndDate($dbDate);
		
		$r2->SetStartTime($r2Start);
		$r2->SetEndTime($r2End);
		$r2->SetStartDate($dbDate);
		$r2->SetEndDate($dbDate);
		
		$r3->SetStartTime($r3Start);
		$r3->SetEndTime($r3End);
		$r3->SetStartDate($dbDate);
		$r3->SetEndDate($dbDate);
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date, $userTz);
		$slots = $list->BuildSlots();
		
		$expectedSlots = $this->testDbLayout->GetLayout();
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[0]->End());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->Begin(), $expectedSlots[1]->End());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->Begin(), $expectedSlots[2]->End());
		$slot4 = new ReservationSlot($expectedSlots[3]->Begin(), $expectedSlots[5]->End(), 3);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->Begin(), $expectedSlots[6]->End());
		$slot6 = new ReservationSlot($expectedSlots[7]->Begin(), $expectedSlots[7]->End(), 1);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->Begin(), $expectedSlots[8]->End());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->Begin(), $expectedSlots[9]->End());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->Begin(), $expectedSlots[10]->End());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->Begin(), $expectedSlots[11]->End());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->Begin(), $expectedSlots[12]->End());
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), $expectedSlots[20]->End(), 8);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->Begin(), $expectedSlots[21]->End());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->Begin(), $expectedSlots[22]->End());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->Begin(), $expectedSlots[23]->End());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->Begin(), $expectedSlots[24]->End());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->Begin(), $expectedSlots[25]->End());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->Begin(), $expectedSlots[26]->End());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->Begin(), $expectedSlots[27]->End());
		$slot20 = new EmptyReservationSlot($expectedSlots[28]->Begin(), $expectedSlots[28]->End());

		$expectedNumberOfSlots = 20;	
		
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
		$this->assertEquals($slot20, $slots[19]);
	}
	
	public function testReservaionStartingPriorToLayoutPeriodAndEndingWithinIsCreatedProperly()
	{
		$tz = $this->tz;
		$dbDate = $this->dbDate;
		$userTz = 'CST';
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1Start = '09:00:00';		// 03:00 CST
		$r1End = '10:40:00';		// 04:40 CST
		
		$r2Start = '11:00:00';		// 05:00 CST
		$r2End = '11:20:00';		// 05:20 CST
		
		$r3Start = '14:00:00';		// 08:00 CST
		$r3End = '18:05:00';		// 12:05 CST
		
		$r1->SetStartTime($r1Start);
		$r1->SetEndTime($r1End);
		$r1->SetStartDate(Date::Parse($dbDate)->AddDays(-1)->ToDatabase());
		$r1->SetEndDate($dbDate);
		
		$r2->SetStartTime($r2Start);
		$r2->SetEndTime($r2End);
		$r2->SetStartDate($dbDate);
		$r2->SetEndDate($dbDate);
		
		$r3->SetStartTime($r3Start);
		$r3->SetEndTime($r3End);
		$r3->SetStartDate($dbDate);
		$r3->SetEndDate($dbDate);
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date, $userTz);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout();
		
		$slot1 = new ReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[5]->End(), 6);
		$slot2 = new EmptyReservationSlot($expectedSlots[6]->Begin(), $expectedSlots[6]->End());
		$slot3 = new ReservationSlot($expectedSlots[7]->Begin(), $expectedSlots[7]->End(), 1);
		$slot4 = new EmptyReservationSlot($expectedSlots[8]->Begin(), $expectedSlots[8]->End());
		$slot5 = new EmptyReservationSlot($expectedSlots[9]->Begin(), $expectedSlots[9]->End());
		$slot6 = new EmptyReservationSlot($expectedSlots[10]->Begin(), $expectedSlots[10]->End());
		$slot7 = new EmptyReservationSlot($expectedSlots[11]->Begin(), $expectedSlots[11]->End());
		$slot8 = new EmptyReservationSlot($expectedSlots[12]->Begin(), $expectedSlots[12]->End());
		$slot9 = new ReservationSlot($expectedSlots[13]->Begin(), $expectedSlots[20]->End(), 8);
		$slot10 = new EmptyReservationSlot($expectedSlots[21]->Begin(), $expectedSlots[21]->End());
		$slot11 = new EmptyReservationSlot($expectedSlots[22]->Begin(), $expectedSlots[22]->End());
		$slot12 = new EmptyReservationSlot($expectedSlots[23]->Begin(), $expectedSlots[23]->End());
		$slot13 = new EmptyReservationSlot($expectedSlots[24]->Begin(), $expectedSlots[24]->End());
		$slot14 = new EmptyReservationSlot($expectedSlots[25]->Begin(), $expectedSlots[25]->End());
		$slot15 = new EmptyReservationSlot($expectedSlots[26]->Begin(), $expectedSlots[26]->End());
		$slot16 = new EmptyReservationSlot($expectedSlots[27]->Begin(), $expectedSlots[27]->End());
		
		$this->assertEquals(17, count($slots));
		
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
	}
	
	public function testReservaionEndingAfterLayoutPeriodAndStartingWithinIsCreatedProperly()
	{
		throw new Exception("#1 - the last slot should run until midnight, but it ends when the schedule ends");
		// other tests may be incorrect as well
		
		$tz = $this->tz;
		$userTz = 'CST';
		$dbDate = $this->dbDate;
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1Start = '09:00:00';		// 03:00 CST
		$r1End = '10:40:00';		// 04:40 CST
		
		$r2Start = '11:00:00';		// 05:00 CST
		$r2End = '11:20:00';		// 05:20 CST
		
		$r3Start = '14:00:00';		// 08:00 CST
		$r3End = '18:05:00';		// 12:05 CST
		
		$r1->SetStartTime($r1Start);
		$r1->SetEndTime($r1End);
		$r1->SetStartDate($dbDate);
		$r1->SetEndDate($dbDate);
		
		$r2->SetStartTime($r2Start);
		$r2->SetEndTime($r2End);
		$r2->SetStartDate($dbDate);
		$r2->SetEndDate($dbDate);
		
		$r3->SetStartTime($r3Start);
		$r3->SetEndTime($r3End);
		$r3->SetStartDate($dbDate);
		$r3->SetEndDate(Date::Parse($dbDate)->AddDays(2)->ToDatabase());
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date, $userTz);
		$slots = $list->BuildSlots();
		$expectedSlots = $this->testDbLayout->GetLayout();
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[0]->End());
		$slot2 = new EmptyReservationSlot($expectedSlots[1]->Begin(), $expectedSlots[1]->End());
		$slot3 = new EmptyReservationSlot($expectedSlots[2]->Begin(), $expectedSlots[2]->End());
		$slot4 = new ReservationSlot($expectedSlots[3]->Begin(), $expectedSlots[5]->End(), 3);
		$slot5 = new EmptyReservationSlot($expectedSlots[6]->Begin(), $expectedSlots[6]->End());
		$slot6 = new ReservationSlot($expectedSlots[7]->Begin(), $expectedSlots[7]->End(), 1);
		$slot7 = new EmptyReservationSlot($expectedSlots[8]->Begin(), $expectedSlots[8]->End());
		$slot8 = new EmptyReservationSlot($expectedSlots[9]->Begin(), $expectedSlots[9]->End());
		$slot9 = new EmptyReservationSlot($expectedSlots[10]->Begin(), $expectedSlots[10]->End());
		$slot10 = new EmptyReservationSlot($expectedSlots[11]->Begin(), $expectedSlots[11]->End());
		$slot11 = new EmptyReservationSlot($expectedSlots[12]->Begin(), $expectedSlots[12]->End());
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), new Time(0, 0, 0, $userTz), 15);
		
		$this->assertEquals(13, count($slots));
		
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
	}
	
	public function testReservaionStartingBeforeLayoutPeriodAndEndingAfterLayoutPeriodIsCreatedProperly()
	{
		$tz = $this->tz;
		$dbDate = $this->dbDate;
		$userTz = 'CST';
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$r1Start = '09:00:00';		// 03:00 CST
		$r1End = '10:40:00';		// 04:40 CST
		$r1->SetStartTime($r1Start);
		$r1->SetEndTime($r1End);
		$r1->SetStartDate('2008-11-10');
		$r1->SetEndDate('2008-11-14');
		
		$reservations = array($r1);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date, $userTz);
		$slots = $list->BuildSlots();
		
		$slot1 = new ReservationSlot(new Time(0,0,0, $tz), new Time(0,0,0, $tz), 28);
		
		$this->assertEquals(1, count($slots));
		
		$this->assertEquals($slot1, $slots[0]);
	}
	
	public function testCreatesScheduleLayoutInProperOrder()
	{	
		$time1 = Time::Parse('07:00');
		$time2 = Time::Parse('07:45');
		$time3 = Time::Parse('08:30');
		$time4 = Time::Parse('13:00');
		
		$layout = new ScheduleLayout();
		
		$layout->AppendPeriod($time1, $time2);
		$layout->AppendPeriod($time3, $time4);
		$layout->AppendPeriod($time2, $time3, 'Period 1');
		
		$periods = $layout->GetLayout();
		
		$this->assertEquals(3, count($periods));
		$this->assertEquals(new SchedulePeriod($time1, $time2), $periods[0]);
		$this->assertEquals(new SchedulePeriod($time2, $time3, 'Period 1'), $periods[1]);
		$this->assertEquals(new SchedulePeriod($time3, $time4), $periods[2]);
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
		$this->assertEquals(new NonSchedulePeriod(Time::Parse('00:00')->ToUtc(), $time1Gmt), $periods[0]);
		$this->assertEquals(new SchedulePeriod($time1Gmt, $time2Gmt), $periods[1]);
		$this->assertEquals(new SchedulePeriod($time2Gmt, $time3Gmt, 'Period 1'), $periods[2]);
		$this->assertEquals(new SchedulePeriod($time3Gmt, $time4Gmt), $periods[3]);
		$this->assertEquals(new NonSchedulePeriod($time4Gmt, Time::Parse('00:00')->ToUtc()), $periods[4]);
	}
}