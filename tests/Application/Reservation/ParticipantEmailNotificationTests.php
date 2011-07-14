<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ParticipantEmailNotificationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testSendsReservationCreatedEmailIfThereAreNewParticipants()
	{
		$this->markTestIncomplete('2011.07.14');
	}
	
	public function testSendsReservationUpdatedEmailIfThereAreNewParticipants()
	{
		$this->markTestIncomplete('2011.07.14');
	}
}
?>