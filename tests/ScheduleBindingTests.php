<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ScheduleBindingTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testBindsAListOfReservationsToAScheduleLayout()
	{
		$layout = $this->getMock('IScheduleLayout');
		$reservations = $this->getMock('IReservationListing');
		
		$binding = new ScheduleBinding();
		$boundSchedule = $binding->Bind($layout, $reservations);
	}

}
?>