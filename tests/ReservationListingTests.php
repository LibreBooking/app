<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

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
	
	public function testReservationSpanningMultipleDaysIsReturnedOnAllOfThem()
	{
		throw new Exception("getting this to work should make the coordinator obsolete");
		
		$reservationListing = new ReservationListing("UTC");
		$reservationListing->Add($res1);
		$reservationListing->Add($res2);
		$reservationListing->Add($res3);
		
		$onFirstDate = $reservationListing->OnDate($date1);
		$onSecondDate = $reservationListing->OnDate($date2);
		
		$this->assertEquals($expectedCount1, count($onFirstDate->Reservations()));
		$this->assertEquals($expectedCount2, count($onSecondDate->Reservations()));
	}
}
?>