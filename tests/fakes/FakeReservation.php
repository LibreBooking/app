<?php
$BASE_DIR = dirname(__FILE__) . '/../..';
require_once($BASE_DIR . '/lib/Reservation.class.php');
require_once('FakeResource.php');
require_once('FakeUser.php');

class FakeReservation extends ReservationSeries
{
	var $id 		= 'fakeresid';
	var $start_date	= null;
	var $end_date	= null;
	var $start	 	= 480;
	var $end	 	= 640;
	var $resource 	= null;
	var $user		= null;
	var $resources  = array();
	var $created 	= null;
	var $modified 	= null;
	var $type 		= null;
	var $is_repeat	= false;
	var $repeat		= null;
	var $minres		= null;
	var $maxRes		= null;
	var $parentid	= null;
	var $is_blackout= false;
	var $is_pending = false;
	var $summary	= null;
	var $scheduleid	= null;
	var $sched		= null;
	var $users		= null;
	var $allow_participation = 0;
	var $allow_anon_participation = 0;

	var $errors     = array();
	var $word		= null;
	var $adminMode  = false;
	var $is_participant = false;
	var $reminder_minutes_prior = 0;

	var $db;

	function FakeReservation() {
		$this->start_date = mktime(0,0,0,3,22,2006);
		$this->end_date = mktime(0,0,0,3,24,2006);

		$this->resource = new FakeResource();
		$this->user = new FakeUser();
		$this->users = array( array('email' => 'fake1@email.com'), array('email' => 'fake2@email.com') );
		$this->resources = array( array('name' => 'projector1') );
		$this->created = mktime(12, 23, 01, 03, 22, 2006);
		$this->modified = mktime(12, 23, 01, 03, 23, 2006);
		$this->summary = 'summary';
		$this->reminder_minutes_prior = 20;
	}
}
?>