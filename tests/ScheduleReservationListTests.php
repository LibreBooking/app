<?php
require_once(ROOT_DIR . 'Domain/namespace.php');

class ScheduleReservationListPresenterTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	function testFormatsReservationListForGivenSchedule()
	{
		$fakeReservations = new FakeReservations();
		$reservations = $fakeReservations->_Reservations;

		$schedule = new Schedule(1, 'name', 0, '07:00:00', '15:00:00', 0, 1, 7);
		
		$list = ScheduleReservationList($reservations);
		$list->Build($schedule);
	}
}