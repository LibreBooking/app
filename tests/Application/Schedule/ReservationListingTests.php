<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ReservationListingTests extends TestBase
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
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testReservationSpanningMultipleDaysIsReturnedOnAllOfThem()
	{
		$res1 = $this->GetReservation('2009-10-09 22:00:00', '2009-10-09 23:00:00');
		// 2009-10-09 17:00:00 - 2009-10-09 18:00:00 CST
		$res2 = $this->GetReservation('2009-10-10 01:00:00', '2009-10-10 07:00:00');
		// 2009-10-09 20:00:00 - 2009-10-10 02:00:00 CST
		$res3 = $this->GetReservation('2009-10-10 10:00:00', '2009-10-13 10:00:00');
		// 2009-10-10 05:00:00 - 2009-10-13 05:00:00 CST
		$res4 = $this->GetReservation('2009-10-14 01:00:00', '2009-10-16 01:00:00');
		// 2009-10-13 20:00:00 - 2009-10-15 20:00:00 CST
		$res5 = $this->GetReservation('2009-10-13 10:00:00', '2009-10-13 15:00:00');
		// 2009-10-13 05:00:00 - 2009-10-13 10:00:00 CST
		
		$reservationListing = new ReservationListing("CST");
		
		$reservationListing->Add($res4);
		$reservationListing->Add($res1);
		$reservationListing->Add($res3);
		$reservationListing->Add($res2);
		$reservationListing->Add($res5);
		
		$onDate1 = $reservationListing->OnDate(Date::Parse('2009-10-09', 'CST'));
		$onDate2 = $reservationListing->OnDate(Date::Parse('2009-10-10', 'CST'));
		$onDate3 = $reservationListing->OnDate(Date::Parse('2009-10-11', 'CST'));
		$onDate4 = $reservationListing->OnDate(Date::Parse('2009-10-12', 'CST'));
		$onDate5 = $reservationListing->OnDate(Date::Parse('2009-10-13', 'CST'));
		$onDate6 = $reservationListing->OnDate(Date::Parse('2009-10-14', 'CST'));
		$onDate7 = $reservationListing->OnDate(Date::Parse('2009-10-15', 'CST'));
		$onDate8 = $reservationListing->OnDate(Date::Parse('2009-10-16', 'CST'));
		
		$this->assertEquals(2, $onDate1->Count());
		$this->assertEquals(2, $onDate2->Count());
		$this->assertEquals(1, $onDate3->Count());
		$this->assertEquals(1, $onDate4->Count());
		$this->assertEquals(3, $onDate5->Count());
		$this->assertEquals(1, $onDate6->Count());
		$this->assertEquals(1, $onDate7->Count());
		$this->assertEquals(0, $onDate8->Count());
	}
	
	private function GetReservation($startDateString, $endDateString)
	{
		return new ScheduleReservation(1, Date::Parse($startDateString, 'UTC'), Date::Parse($endDateString, 'UTC'), 1, null, null, 1, 1, '', '');
	}
}
?>