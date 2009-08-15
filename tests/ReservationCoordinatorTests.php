<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationCoordinatorTests extends TestBase
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
		FakeScheduleRepository::Initialize();

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
		
		$this->assertEquals(5, $reservationListing->OnDate(Date::Parse('2009-01-01'))->Count());
		$this->assertEquals(4, $reservationListing->OnDate(Date::Parse('2009-01-02'))->Count());
		$this->assertEquals(3, $reservationListing->OnDate(Date::Parse('2009-01-03'))->Count());
		$this->assertEquals(0, $reservationListing->OnDate(Date::Parse('2009-01-12'))->Count());
		
		$this->assertEquals(3, $reservationListing->OnDate(Date::Parse('2009-01-01'))->ForResource(1)->Count());
		$this->assertEquals(0, $reservationListing->OnDate(Date::Parse('2009-01-01'))->ForResource(10)->Count());
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


//class TimezoneReservations
//{
//	private $_reservations = array();
//	
//	public function __construct($timezone, $reservations, ReservationCoordinator $coordinator)
//	{
//		$this->_reservations = $reservations;
//	}
//	
//	public function LimitedTo(Date $startDate, Date $endDate)
//	{
//		return new Arrangement($this->_reservations, $this);
//	}
//}
//
//class Arrangement
//{
//	private $_reservations = array();
//	
//	public function __construct($reservations, TimezoneReservations $timezoneReservations)
//	{
//		$this->_reservations = $reservations;
//	}
//	
//	public function Arrange()
//	{
//		foreach ($this->_reservations as $reservation)
//		{
//			
//		}
//		return new ReservationListing($this->_reservations);
//	}
//	
//
//}
//
//class ReservationRowCoordinator
//{
//	public function AdjustToTimezone()
//	{
//
//	}
//}

?>