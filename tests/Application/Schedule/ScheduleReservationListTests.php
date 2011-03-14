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
	private $dbDate;
	
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
		$dbDate = Date::Parse('2008-11-11', $utc);
		$userTz = 'CST';
		
		$this->utc = $utc;
		$this->userTz = $userTz;
		
		$this->dbDate = $dbDate;
		$this->date = $dbDate;
		
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
		
		$midnightUtc = Date::Create(2010, 1, 1, 0,0,0, $utc);
		$midnightCst = Date::Create(2010, 1, 1, 0,0,0, $userTz);
		
		$hourDifference = (0 - $midnightUtc->ToTimezone($userTz)->Hour() + 24) ;
		
		$layout = new ScheduleLayout($userTz);
		$layout->AppendBlockedPeriod(new Time(0, 0, 0, $utc), new Time(1, 0, 0, $utc));
		$layout->AppendPeriod(new Time(1, 0, 0, $utc), new Time(3, 0, 0, $utc));
		$layout->AppendBlockedPeriod(new Time(3, 0, 0, $utc), new Time(0, 0, 0, $utc));
		
		$layoutSlots = $layout->GetLayout($this->date);
		$this->assertEquals(4, count($layoutSlots));
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$newStart = Date::Create($this->dbDate->Year(), $this->dbDate->Month(), $this->dbDate->Day(), 1, 0, 0, 'UTC');
		$newEnd = Date::Create($this->dbDate->Year(), $this->dbDate->Month(), $this->dbDate->Day(), 3, 0, 0, 'UTC');
		$r1->SetStartDate($newStart);	
		$r1->SetEndDate($newEnd);
		
		$scheduleList = new ScheduleReservationList(array($r1), $layout, $this->date);
		$slots = $scheduleList->BuildSlots();
		
		$workingDate = $this->date->ToUtc();
		$t1s = $workingDate->SetTime(new Time(0,0,0));
		$t1e = $workingDate->SetTime(new Time(1,0,0));
		$t2e = $workingDate->SetTime(new Time(3,0,0));
		$t3e = $workingDate->SetTime(new Time(0,0,0));
		
		$slotDate = $this->date->ToTimezone($userTz)->GetDate();
		
		$midnightUserTime = $workingDate->ToTimezone($userTz)->SetTime(new Time(0,0,0));
		
		$slot1 = new EmptyReservationSlot(new Time(0,0,0, $userTz), $t1s->ToTimezone($userTz)->GetTime(), $slotDate, false);
		$slot2 = new EmptyReservationSlot($t1s->ToTimezone($userTz)->GetTime(), $t1e->ToTimezone($userTz)->GetTime(), $slotDate, false);
		$slot3 = new ReservationSlot($t1e->ToTimezone($userTz)->GetTime(), $t2e->ToTimezone($userTz)->GetTime(), $slotDate, 1, $r1);
		$slot4 = new EmptyReservationSlot($t2e->ToTimezone($userTz)->GetTime(), new Time(0,0,0, $userTz), $slotDate, false);
		
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
		$utc = $this->utc;
		
		FakeScheduleReservations::Initialize();
		$r1 = FakeScheduleReservations::$Reservation1;
		$r2 = FakeScheduleReservations::$Reservation2;
		$r3 = FakeScheduleReservations::$Reservation3;
		
		$resDate = $dbDate->ToTimezone($userTz)->GetDate();
		$y = $resDate->Year();
		$m = $resDate->Month();
		$d = $resDate->Day();
		
		$r1->SetStartDate(Date::Create($y, $m, $d, 9, 0, 0, $utc));  // 03:00 CST
		$r1->SetEndDate(Date::Create($y, $m, $d, 10, 30, 0, $utc));  // 04:30 CST
		
		$r2->SetStartDate(Date::Create($y, $m, $d, 11, 0, 0, $utc)); // 05:00 CST
		$r2->SetEndDate(Date::Create($y, $m, $d, 11, 30, 0, $utc));  // 05:30 CST

		$r3->SetStartDate(Date::Create($y, $m, $d, 14, 0, 0, $utc)); // 08:00 CST
		$r3->SetEndDate(Date::Create($y, $m, $d, 18, 0, 0, $utc));   // 12:00 CST
		
		$reservations = array($r1, $r2, $r3);
		
//		printf("%s\n", Date::Now()->ToString());
	
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
//		printf("%s\n", Date::Now()->ToString());
		
		$slotDate = $this->date->ToTimezone($userTz)->GetDate();
		$expectedSlots = $this->testDbLayout->GetLayout($this->date);
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[0]->End(), $slotDate, $expectedSlots[0]->IsReservable());
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
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), $expectedSlots[20]->End(), $slotDate, 8, $r3);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->Begin(), $expectedSlots[21]->End(), $slotDate, $expectedSlots[21]->IsReservable());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->Begin(), $expectedSlots[22]->End(), $slotDate, $expectedSlots[22]->IsReservable());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->Begin(), $expectedSlots[23]->End(), $slotDate, $expectedSlots[23]->IsReservable());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->Begin(), $expectedSlots[24]->End(), $slotDate, $expectedSlots[24]->IsReservable());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->Begin(), $expectedSlots[25]->End(), $slotDate, $expectedSlots[25]->IsReservable());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->Begin(), $expectedSlots[26]->End(), $slotDate, $expectedSlots[26]->IsReservable());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->Begin(), $expectedSlots[27]->End(), $slotDate, $expectedSlots[27]->IsReservable());

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
		$utc = $this->utc;
		
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

		$r3->SetStartDate(Date::Create($y, $m, $d, 14, 0, 0, $utc)); // 08:00 CST
		$r3->SetEndDate(Date::Create($y, $m, $d, 18, 05, 0, $utc));  // 12:05 CST
		
		$reservations = array($r1, $r2, $r3);
		
		$list = new ScheduleReservationList($reservations, $this->testDbLayout, $this->date);
		$slots = $list->BuildSlots();
		
		$slotDate = $this->date->ToTimezone($userTz)->GetDate();
		$expectedSlots = $this->testDbLayout->GetLayout($this->date);
		
		$slot1 = new EmptyReservationSlot($expectedSlots[0]->Begin(), $expectedSlots[0]->End(), $slotDate, $expectedSlots[0]->IsReservable());
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
		$slot12 = new ReservationSlot($expectedSlots[13]->Begin(), $expectedSlots[20]->End(), $slotDate, 8, $r3);
		$slot13 = new EmptyReservationSlot($expectedSlots[21]->Begin(), $expectedSlots[21]->End(), $slotDate, $expectedSlots[21]->IsReservable());
		$slot14 = new EmptyReservationSlot($expectedSlots[22]->Begin(), $expectedSlots[22]->End(), $slotDate, $expectedSlots[22]->IsReservable());
		$slot15 = new EmptyReservationSlot($expectedSlots[23]->Begin(), $expectedSlots[23]->End(), $slotDate, $expectedSlots[23]->IsReservable());
		$slot16 = new EmptyReservationSlot($expectedSlots[24]->Begin(), $expectedSlots[24]->End(), $slotDate, $expectedSlots[24]->IsReservable());
		$slot17 = new EmptyReservationSlot($expectedSlots[25]->Begin(), $expectedSlots[25]->End(), $slotDate, $expectedSlots[25]->IsReservable());
		$slot18 = new EmptyReservationSlot($expectedSlots[26]->Begin(), $expectedSlots[26]->End(), $slotDate, $expectedSlots[26]->IsReservable());
		$slot19 = new EmptyReservationSlot($expectedSlots[27]->Begin(), $expectedSlots[27]->End(), $slotDate, $expectedSlots[27]->IsReservable());
		//$slot20 = new EmptyReservationSlot($expectedSlots[28]->Begin(), $expectedSlots[28]->End(), $slotDate, $expectedSlots[28]->IsReservable());

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
	}
	
	public function testReservaionEndingAfterLayoutPeriodAndStartingWithinIsCreatedProperly()
	{
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