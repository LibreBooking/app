<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationListManagerTests extends TestBase
{
	private $res1;
	private $res2;
	private $res3;
	private $res4;
	private $res5;

	private $reservationRepository;

	public function setup()
	{
		parent::setup();
		FakeSchedules::Initialize();

		$this->res1 = $this->GetReservation('2008-12-20', '2008-12-20', '08:00', '09:00', 1);
		$this->res2 = $this->GetReservation('2008-12-20', '2008-12-20', '08:00', '09:00', 1);
		$this->res3 = $this->GetReservation('2008-12-20', '2008-12-20', '08:00', '09:00', 1);
		$this->res4 = $this->GetReservation('2008-12-20', '2008-12-20', '08:00', '09:00', 1);
		$this->res5 = $this->GetReservation('2008-12-20', '2008-12-20', '08:00', '09:00', 1);

		$this->reservationRepository = new FakeReservationRepository();
		$this->reservationRepository->_Reservations = array($this->res1, $this->res2, $this->res3, $this->res4, $this->res5);
	}

	public function teardown()
	{
		parent::teardown();
	}

	
	public function testReservationCoordinatorArrangeSplitsAndLimitsReservationsForGivenRangeAndTimezone()
	{
		$splitTo2Dates = $this->GetReservation('2009-01-01 01:00:00', '2009-01-01 08:00:00', 1, 1);
		// goes to 2008-12-31 19:00:00 -> 2009-01-01 02:00:00 (2 reservations)
		//  2008-12-31 19:00 - 2009-01-01 00:00
		//  2009-01-01 00:00 - 2009-01-01 02:00
		
		$splitTo4Pieces = $this->GetReservation('2009-01-02 05:00:00', '2009-01-05 05:00:00', 2, 2);
		// goes to 2009-01-01 23:00:00 -> 2009-01-04 23:00:00 (4 reservations)
		//  2009-01-01 23:00 - 2009-01-02 00:00
		//  2009-01-02 00:00 - 2009-01-03 00:00
		//  2009-01-03 00:00 - 2009-01-04 00:00
		//  2009-01-04 00:00 - 2009-01-04 23:00
		
		$splitTo6Pieces = $this->GetReservation('2009-01-01 09:00:00', '2009-01-06 20:00:00', 3, 1);
		// goes to 2009-01-01 03:00:00 -> 2009-01-06 14:00:00 (5 reservations)
		//  2009-01-01 03:00 - 2009-01-02 00:00
		//  2009-01-02 00:00 - 2009-01-03 00:00
		//  2009-01-03 00:00 - 2009-01-04 00:00
		//  2009-01-04 00:00 - 2009-01-05 00:00
		//  2009-01-05 00:00 - 2009-01-06 00:00
		
		$splitTo6PiecesOffEnd = $this->GetReservation('2009-01-01 18:00:00', '2009-01-15 18:00:00', 4, 2);
		// goes to 2009-01-01 12:00:00 -> 2009-01-15 12:00:00 (5 reservations)
		//  2009-01-01 12:00 - 2009-01-02 00:00
		//  2009-01-02 00:00 - 2009-01-03 00:00
		//  2009-01-03 00:00 - 2009-01-04 00:00
		//  2009-01-04 00:00 - 2009-01-05 00:00
		//  2009-01-05 00:00 - 2009-01-06 00:00
		
		$splitTo2PiecesOffStart = $this->GetReservation('2008-12-31 02:00:00', '2009-01-02 18:00:00', 5, 1);
		// goes to 2008-12-30 20:00:00 -> 2009-01-02 12:00:00 (3 reservations)
		//  2008-12-31 00:00 - 2009-01-01 00:00
		//  2009-01-01 00:00 - 2009-01-02 00:00
		//  2009-01-02 00:00 - 2009-01-02 12:00
		
		$notSplit = $this->GetReservation('2009-01-04 12:00:00', '2009-01-04 14:00:00', 6, 1);
		// goes to 2009-01-04 06:00:00 -> 2009-01-04 08:00:00 (1 reservation)
		
		$startDate = Date::Parse('2008-12-31')->ToTimezone('UTC');	// 2008-12-31 06:00 UTC
		$endDate = Date::Parse('2009-01-06')->ToTimezone('UTC');	// 2009-01-06 06:00 UTC
		
		$coordinator = new ReservationCoordinator();
		
		$coordinator->AddReservation($splitTo2Dates);
		$coordinator->AddReservation($splitTo4Pieces);
		$coordinator->AddReservation($splitTo6Pieces);
		$coordinator->AddReservation($splitTo6PiecesOffEnd);
		$coordinator->AddReservation($splitTo2PiecesOffStart);
		$coordinator->AddReservation($notSplit);
		
		$reservationListing = $coordinator->Arrange('CST', new DateRange($startDate, $endDate));
				
		$reservations = $reservationListing->Reservations();
//		foreach ($reservations as $reservation)
//		{
//			printf("\n%s => %s - %s", $reservation->Reservation->GetReservationId(), $reservation->DisplayStartDate->ToString(), $reservation->DisplayEndDate->ToString());
//		}
		$cst = 'CST';
		
		$this->assertEquals(20, $reservationListing->Count());
		
		$this->assertEquals(1, $reservations[0]->Reservation->GetReservationId());		
		$this->assertTrue(Date::Parse('2008-12-31 19:00', $cst)->Equals($reservations[0]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-01 00:00', $cst)->Equals($reservations[0]->DisplayEndDate));
		$this->assertEquals(1, $reservations[1]->Reservation->GetReservationId());
		$this->assertTrue(Date::Parse('2009-01-01 00:00', $cst)->Equals($reservations[1]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-01 02:00', $cst)->Equals($reservations[1]->DisplayEndDate));
		
		$this->assertEquals(2, $reservations[2]->Reservation->GetReservationId());		
		$this->assertTrue(Date::Parse('2009-01-01 23:00', $cst)->Equals($reservations[2]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-02 00:00', $cst)->Equals($reservations[2]->DisplayEndDate));
		$this->assertEquals(2, $reservations[3]->Reservation->GetReservationId());
		$this->assertTrue(Date::Parse('2009-01-02 00:00', $cst)->Equals($reservations[3]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-03 00:00', $cst)->Equals($reservations[3]->DisplayEndDate));
		$this->assertEquals(2, $reservations[4]->Reservation->GetReservationId());		
		$this->assertTrue(Date::Parse('2009-01-03 00:00', $cst)->Equals($reservations[4]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-04 00:00', $cst)->Equals($reservations[4]->DisplayEndDate));
		$this->assertEquals(2, $reservations[5]->Reservation->GetReservationId());
		$this->assertTrue(Date::Parse('2009-01-04 00:00', $cst)->Equals($reservations[5]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-04 23:00', $cst)->Equals($reservations[5]->DisplayEndDate));
		
		$this->assertEquals(6, $reservations[19]->Reservation->GetReservationId());		
		$this->assertTrue(Date::Parse('2009-01-04 06:00:00', $cst)->Equals($reservations[19]->DisplayStartDate));
		$this->assertTrue(Date::Parse('2009-01-04 08:00:00', $cst)->Equals($reservations[19]->DisplayEndDate));
		
//		$this->assertTrue(3, $reservationListing->ByDate()->OnDate('')->ForResource(1)->Count());
//		$this->assertTrue(1, $reservationListing->ByDate()->OnDate('')->ForResource(2)->Count());
		
	}
	
	public function testDateIsWithinRange()
	{
		$begin = Date::Create(2008, 09, 09, 10, 11, 12, 'UTC');
		$end = Date::Create(2008, 10, 09, 10, 11, 12, 'UTC');
		
		$range = new DateRange($begin, $end);
		
		$within = $begin->AddDays(10);
		$notWithin = $begin->AddDays(-10);
		$exactStart = $begin;
		$exactEnd = $end;
		
		$this->assertTrue($range->Contains($within));
		$this->assertTrue($range->Contains($exactStart));
		$this->assertTrue($range->Contains($exactEnd));
		$this->assertFalse($range->Contains($notWithin));
	}
	
	public function testDateRangeIsWithinRange()
	{
		$begin = Date::Create(2008, 09, 09, 10, 11, 12, 'UTC');
		$end = Date::Create(2008, 10, 09, 10, 11, 12, 'UTC');
		
		$range = new DateRange($begin, $end);
		
		$within = new DateRange($begin->AddDays(10), $end->AddDays(-10));
		$notWithin = new DateRange($begin->AddDays(-10), $end->AddDays(-1));
		
		$exact = new DateRange($begin, $end);
		
		$this->assertTrue($range->ContainsRange($within));
		$this->assertTrue($range->ContainsRange($exact));
		$this->assertFalse($range->ContainsRange($notWithin));
	}
	
//	public function testFoo()
//	{
//		$times = array
//		(
//			array
//			(
//				'start' => Date::Parse('2009-01-01 00:00:00', 'CST'),
//				'end' => Date::Parse('2009-01-01 01:00:00 AM', 'CST')
//			),
//			array
//			(
//				'start' => Date::Parse('2009-01-01 01:00:00 AM', 'CST'),
//				'end' => Date::Parse('2009-01-01 09:00:00 AM', 'CST')
//			),
//			array
//			(
//				'start' => Date::Parse('2009-01-01 09:00:00 AM', 'CST'),
//				'end' => Date::Parse('2009-01-01 09:30:00 AM', 'CST')
//			),
//			array
//			(
//				'start' => Date::Parse('2009-01-01 09:30:00 AM', 'CST'),
//				'end' => Date::Parse('2009-01-01 06:00:00 PM', 'CST')
//			),
//			array
//			(
//				'start' => Date::Parse('2009-01-01 06:00:00 PM', 'CST'),
//				'end' => Date::Parse('2009-01-01 6:30:00 PM', 'CST')
//			),
//			array
//			(
//				'start' => Date::Parse('2009-01-01 6:30:00 PM', 'CST'),
//				'end' => Date::Parse('2009-01-02 00:00:00', 'CST')
//			)
//		);
//		
//		foreach ($times as $time)
//		{
//			$cstStart = $time['start']->ToString();
//			$cstEnd = $time['end']->ToString();
//			
//			$gmtStart = $time['start']->ToTimezone('GMT')->ToString();
//			$gmtEnd = $time['end']->ToTimezone('GMT')->ToString();
//			
//			echo "CST start: $cstStart end: $cstEnd \nGMT start: $gmtStart end: $gmtEnd\n\n";
//		}
//
//	}

	public function testManagerPlacesReservationOnEachDayThatItIsScheduledFor()
	{
		throw new Exception("#2 - just started working on this, need to figure out how to get reservations onto proper days");

		$schedule = FakeSchedules::$Schedule1;

		$numberOfDaysDisplayed = $schedule->GetDaysVisible();

		$firstDateInUserTimezone = Date::Parse('2008-12-13', 'CST');
		$firstDateInUtc = $firstDateInUserTimezone->ToUtc();
		$lastDateInUtc = $firstDateInUtc->AddDays($numberOfDaysDisplayed);

		$manager = new ReservationListManager($this->reservationRepository, $schedule);

		$groups = $manager->BuildReservationGroups();

		$this->assertEquals($numberOfDaysDisplayed, count($groups));
		$this->assertEquals($numberOfResources, count($groups[0]));
	}
	
	public function testCreatesScheduleLayoutForSpecifiedTimezone()
	{
		$layout = new ScheduleLayout('CST');
		$layout->AppendPeriod(new Time(0, 0, 0, 'UTC'), new Time(10, 0, 0, 'UTC'));
		
		$periods = $layout->GetLayout();
		
		$this->assertEquals(2, count($periods));
		
		$firstBegin = new Time(0,0,0, 'CST');
		$firstEnd = new Time(4,0,0, 'CST');
		$secondBegin = new Time(18, 0, 0, 'CST');
		$secondEnd = new Time(0, 0, 0, 'CST');
		
		$this->assertTrue($firstBegin->Equals($periods[0]->Begin()));
		$this->assertTrue($firstEnd->Equals($periods[0]->End()));
		$this->assertTrue($secondBegin->Equals($periods[1]->Begin()));
		$this->assertTrue($secondEnd->Equals($periods[1]->End()));
	}

	/**
	 * @param $startDate string
	 * @param $endDate string
	 * @param $startTime string
	 * @param $endTime string
	 * @param $reservationId int
	 * @param $resourceId int
	 * @return ScheduleReservation
	 */
	private function GetReservation($startDate, $endDate, $reservationId, $resourceId)
	{
		return new ScheduleReservation($reservationId, $startDate, $endDate, 1, 'summary', null, $resourceId, 1, 'f', 'l');
	}
}


class TimezoneReservations
{
	private $_reservations = array();
	
	public function __construct($timezone, $reservations, ReservationCoordinator $coordinator)
	{
		$this->_reservations = $reservations;
	}
	
	public function LimitedTo(Date $startDate, Date $endDate)
	{
		return new Arrangement($this->_reservations, $this);
	}
}

class Arrangement
{
	private $_reservations = array();
	
	public function __construct($reservations, TimezoneReservations $timezoneReservations)
	{
		$this->_reservations = $reservations;
	}
	
	public function Arrange()
	{
		foreach ($this->_reservations as $reservation)
		{
			
		}
		return new ReservationListing($this->_reservations);
	}
	

}

class ReservationRowCoordinator
{
	public function AdjustToTimezone()
	{

	}
}

?>