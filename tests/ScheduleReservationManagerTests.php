<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ScheduleReservationManagerTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testManagerConsolidatesAllReservationsIntoLayoutsInUserTimezone()
	{
		throw new Exception("#1");
	}
}

?>