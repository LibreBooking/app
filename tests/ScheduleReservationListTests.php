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
		
		$layout = new ScheduleLayout($tz);
		
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $tz), new Time(8, 0, 0, $tz));
		
		for ($hour = 8; $hour <= 20; $hour++)
		{
			$layout->AppendPeriod(new Time($hour, 0, 0, $tz), new Time($hour, 30, 0 , $tz));
			$layout->AppendPeriod(new Time($hour, 30, 0, $tz), new Time($hour + 1, 0, 0, $tz));
		}
		
		$layout->AppendBlockedPeriod(new Time(21, 0, 0, $tz), new Time(0, 0, 0, $tz));
		
		//$adjustedLayout = $layout->ToTimezone($userTz);		
		
		$this->testDbLayout = $layout;
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	function testLayoutIsConvertedToUserTimezoneBeforeSlotsAreCreated()
	{
		$userTz = 'CST';
		$utc = 'UTC';
		$layout = new ScheduleLayout($utc);
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $utc), new Time(1, 0, 0, $utc));
		$layout->AppendPeriod(new Time(1, 0, 0, $utc), new Time(3, 0, 0, $utc));
		$layout->AppendBlockedPeriod(new Time(3, 0, 0, $utc), new Time(0, 0, 0, $utc));
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r1->SetStartDate($this->dbDate);
		$r1->SetStartTime('01:00:00');
		$r1->SetEndDate($this->dbDate);
		$r1->SetEndTime('03:00:00');
		
		$scheduleList = new ScheduleReservationList(array($r1), $layout, $this->date, $userTz);
		$slots = $scheduleList->BuildSlots();
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $userTz), new Time(17,0,0, $userTz));
		$slot2 = new EmptyReservationSlot(new Time(18,0,0, $userTz), new Time(19,0,0, $userTz));
		$slot3 = new ReservationSlot(new Time(19,0,0, $userTz), new Time(21,0,0, $userTz), 1);
		$slot4 = new EmptyReservationSlot(new Time(21,0,0, $userTz), new Time(0,0,0, $userTz));
		
		$this->assertEquals(4, count(slots));
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
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots($userTz);
		
//		printf("%s\n", Date::Now()->ToString());
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $tz), new Time(8,0,0, $tz));
		$slot2 = new EmptyReservationSlot(new Time(8,0,0, $tz), new Time(8,30,0, $tz));
		$slot3 = new EmptyReservationSlot(new Time(8,30,0, $tz), new Time(9,0,0, $tz));
		$slot4 = new ReservationSlot(new Time(9,0,0, $tz), new Time(10,30,0, $tz), 3);
		$slot5 = new EmptyReservationSlot(new Time(10,30,0, $tz), new Time(11,0,0, $tz));
		$slot6 = new ReservationSlot(new Time(11,0,0, $tz), new Time(11,30,0, $tz), 1);
		$slot7 = new EmptyReservationSlot(new Time(11,30,0, $tz), new Time(12,0,0, $tz));
		$slot8 = new EmptyReservationSlot(new Time(12,0,0, $tz), new Time(12,30,0, $tz));
		$slot9 = new EmptyReservationSlot(new Time(12,30,0, $tz), new Time(13,0,0, $tz));
		$slot10 = new EmptyReservationSlot(new Time(13,0,0, $tz), new Time(13,30,0, $tz));
		$slot11 = new EmptyReservationSlot(new Time(13,30,0, $tz), new Time(14,0,0, $tz));
		$slot12 = new ReservationSlot(new Time(14,0,0, $tz), new Time(18,0,0, $tz), 8);
		$slot13 = new EmptyReservationSlot(new Time(18,0,0, $tz), new Time(18,30,0, $tz));
		$slot14 = new EmptyReservationSlot(new Time(18,30,0, $tz), new Time(19,0,0, $tz));
		$slot15 = new EmptyReservationSlot(new Time(19,0,0, $tz), new Time(19,30,0, $tz));
		$slot16 = new EmptyReservationSlot(new Time(19,30,0, $tz), new Time(20,0,0, $tz));
		$slot17 = new EmptyReservationSlot(new Time(20,0,0, $tz), new Time(20,30,0, $tz));
		$slot18 = new EmptyReservationSlot(new Time(20,30,0, $tz), new Time(21,0,0, $tz));
		$slot19 = new EmptyReservationSlot(new Time(21,0,0, $tz), new Time(0,0,0, $tz));

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
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $tz), new Time(8,0,0, $tz));
		$slot2 = new EmptyReservationSlot(new Time(8,0,0, $tz), new Time(8,30,0, $tz));
		$slot3 = new EmptyReservationSlot(new Time(8,30,0, $tz), new Time(9,0,0, $tz));
		$slot4 = new ReservationSlot(new Time(9,0,0, $tz), new Time(10,30,0, $tz), 3);
		$slot5 = new EmptyReservationSlot(new Time(10,30,0, $tz), new Time(11,0,0, $tz));
		$slot6 = new ReservationSlot(new Time(11,0,0, $tz), new Time(11,30,0, $tz), 1);
		$slot7 = new EmptyReservationSlot(new Time(11,30,0, $tz), new Time(12,0,0, $tz));
		$slot8 = new EmptyReservationSlot(new Time(12,0,0, $tz), new Time(12,30,0, $tz));
		$slot9 = new EmptyReservationSlot(new Time(12,30,0, $tz), new Time(13,0,0, $tz));
		$slot10 = new EmptyReservationSlot(new Time(13,0,0, $tz), new Time(13,30,0, $tz));
		$slot11 = new EmptyReservationSlot(new Time(13,30,0, $tz), new Time(14,0,0, $tz));
		$slot12 = new ReservationSlot(new Time(14,0,0, $tz), new Time(18,0,0, $tz), 8);
		$slot13 = new EmptyReservationSlot(new Time(18,0,0, $tz), new Time(18,30,0, $tz));
		$slot14 = new EmptyReservationSlot(new Time(18,30,0, $tz), new Time(19,0,0, $tz));
		$slot15 = new EmptyReservationSlot(new Time(19,0,0, $tz), new Time(19,30,0, $tz));
		$slot16 = new EmptyReservationSlot(new Time(19,30,0, $tz), new Time(20,0,0, $tz));
		$slot17 = new EmptyReservationSlot(new Time(20,0,0, $tz), new Time(20,30,0, $tz));
		$slot18 = new EmptyReservationSlot(new Time(20,30,0, $tz), new Time(21,0,0, $tz));
		$slot19 = new EmptyReservationSlot(new Time(21,0,0, $tz), new Time(0,0,0, $tz));

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
	
	public function testReservaionStartingPriorToLayoutPeriodAndEndingWithinIsCreatedProperly()
	{
		$tz = $this->tz;
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
		$r1->SetStartDate('2008-11-10');
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
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
		$slot1 = new ReservationSlot(new Time(0,0,0, $tz), new Time(10,30,0, $tz), 6);
		$slot2 = new EmptyReservationSlot(new Time(10,30,0, $tz), new Time(11,0,0, $tz));
		$slot3 = new ReservationSlot(new Time(11,0,0, $tz), new Time(11,30,0, $tz), 1);
		$slot4 = new EmptyReservationSlot(new Time(11,30,0, $tz), new Time(12,0,0, $tz));
		$slot5 = new EmptyReservationSlot(new Time(12,0,0, $tz), new Time(12,30,0, $tz));
		$slot6 = new EmptyReservationSlot(new Time(12,30,0, $tz), new Time(13,0,0, $tz));
		$slot7 = new EmptyReservationSlot(new Time(13,0,0, $tz), new Time(13,30,0, $tz));
		$slot8 = new EmptyReservationSlot(new Time(13,30,0, $tz), new Time(14,0,0, $tz));
		$slot9 = new ReservationSlot(new Time(14,0,0, $tz), new Time(18,0,0, $tz), 8);
		$slot10 = new EmptyReservationSlot(new Time(18,0,0, $tz), new Time(18,30,0, $tz));
		$slot11 = new EmptyReservationSlot(new Time(18,30,0, $tz), new Time(19,0,0, $tz));
		$slot12 = new EmptyReservationSlot(new Time(19,0,0, $tz), new Time(19,30,0, $tz));
		$slot13 = new EmptyReservationSlot(new Time(19,30,0, $tz), new Time(20,0,0, $tz));
		$slot14 = new EmptyReservationSlot(new Time(20,0,0, $tz), new Time(20,30,0, $tz));
		$slot15 = new EmptyReservationSlot(new Time(20,30,0, $tz), new Time(21,0,0, $tz));
		$slot16 = new EmptyReservationSlot(new Time(21,0,0, $tz), new Time(0,0,0, $tz));
		
		$this->assertEquals(16, count($slots));
		
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
		$tz = $this->tz;
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
		$r3->SetEndDate('2008-11-14');
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $tz), new Time(8,0,0, $tz));
		$slot2 = new EmptyReservationSlot(new Time(8,0,0, $tz), new Time(8,30,0, $tz));
		$slot3 = new EmptyReservationSlot(new Time(8,30,0, $tz), new Time(9,0,0, $tz));
		$slot4 = new ReservationSlot(new Time(9,0,0, $tz), new Time(10,30,0, $tz), 3);
		$slot5 = new EmptyReservationSlot(new Time(10,30,0, $tz), new Time(11,0,0, $tz));
		$slot6 = new ReservationSlot(new Time(11,0,0, $tz), new Time(11,30,0, $tz), 1);
		$slot7 = new EmptyReservationSlot(new Time(11,30,0, $tz), new Time(12,0,0, $tz));
		$slot8 = new EmptyReservationSlot(new Time(12,0,0, $tz), new Time(12,30,0, $tz));
		$slot9 = new EmptyReservationSlot(new Time(12,30,0, $tz), new Time(13,0,0, $tz));
		$slot10 = new EmptyReservationSlot(new Time(13,0,0, $tz), new Time(13,30,0, $tz));
		$slot11 = new EmptyReservationSlot(new Time(13,30,0, $tz), new Time(14,0,0, $tz));
		$slot12 = new ReservationSlot(new Time(14,0,0, $tz), new Time(0,0,0, $tz), 15);
		
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
		$this->assertEquals($slot12, $slots[11]);
	}
	
	public function testReservaionStartingBeforeLayoutPeriodAndEndingAfterLayoutPeriodIsCreatedProperly()
	{
		$tz = $this->tz;
		$dbDate = $this->dbDate;
		
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
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
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