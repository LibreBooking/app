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
	
	public function testManagerPlacesReservationOnEachDayThatItIsScheduledFor()
	{
		throw new Exception("#1 - just started working on this, need to figure out how to get reservations onto proper days");
		
		$schedule = FakeSchedules::$Schedule1;
		
		$numberOfDaysDisplayed = $schedule->GetDaysVisible();
		
		$firstDateInUserTimezone = Date::Parse('2008-12-13', 'CST');
		$firstDateInUtc = $firstDateInUserTimezone->ToUtc();
		$lastDateInUtc = $firstDateInUtc->AddDays($numberOfDaysDisplayed);
		
		$manager = new ReservationListManager($this->reservationRepository, $schedule);
				
		$groups = $manager->BuildReservationGroups();
		
		$this->assertEquals($numberOfDaysDisplayed, count($groups));
	}
	
	public function testLayoutCoordinatorMovesSlotsIfAdjustingToUserTimezonePutsPartOfReservationOnAnotherDay()
	{
		throw new Exception("#2 - this guy will be responsible for doing the adjusting, i think");
		
	
	}
	
	/**
	 * @return ScheduleReservation
	 */
	private function GetReservation($startDate, $endDate, $startTime, $endTime, $resourceId)
	{
		return new ScheduleReservation(1, $startDate, $endDate, $startTime, $endTime, 1, 'summary', null, $resourceId, 1, 'f', 'l');
	}
}

class ReservationRowCoordinator
{
	public function AdjustToTimezone()
	{
	
	}
}

?>