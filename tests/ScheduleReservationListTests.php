<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class ScheduleReservationListTests extends TestBase
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
		$this->markTestIncomplete("working on this after the next next is complete");
		$fakeReservations = new FakeReservations();
		$reservations = $fakeReservations->_Reservations;

		$schedule = new Schedule(1, 'name', 0, '07:00:00', '15:00:00', 0, 1, 7);
		
		$list = ScheduleReservationList($reservations);
		$built = $list->Build($schedule);
		
		$firstSlot = new EmptyReservationSlot('');
		
		$this->assertEquals($firstSlot, $built[0]);
	}
	
	function testCreatesScheduleLayout()
	{
//		$this->fakeServer->UserSession->Timezone = 'US/Eastern';
//		
//		$layout = new ScheduleLayout();
//		$layout->AppendPeriod(new Time('07:00'), new Time('07:45'));
//		$layout->AppendPeriod(new Time('07:45'), new Time('08:30'), 'Period 1');
//		$layout->AppendPeriod(new Time('08:30'), new Time('13:00'));
//		
//		$periods = $layout->GetAll();
//		
//		$this->assertEquals(3, count($periods));
//		$this->assertEquals(new SchedulePeriod(new Time('07:00'), new Time('07:45')), $periods[0]);
//		$this->assertEquals('8:00', actual);
		
		$sevenAm = date("Y-m-d H:i:s", mktime(7, 0, 0));
		$sevenAmW3C = date(DATE_W3C, mktime(7, 0, 0));
		$gmt = new DateTime($sevenAm, new DateTimeZone("GMT"));
		$gmt2 = new DateTime($sevenAmW3C, new DateTimeZone("GMT"));
		$east = new DateTime("now", new DateTimeZone("US/Eastern"));
		
		echo "\n\n1: {$sevenAm}\n";
		echo "2: {$sevenAmW3C}\n";
		echo "1 (format W3C): {$gmt->format(DATE_W3C)}\n";
		echo "2 (format W3C): {$gmt2->format(DATE_W3C)}\n";
		$gmt->setTimezone(new DateTimeZone("GMT"));
		$gmt2->setTimezone(new DateTimeZone("GMT"));
		echo "1 (to GMT): {$gmt->format(DATE_W3C)}\n";
		echo "2 (to GMT): {$gmt2->format(DATE_W3C)}\n";
		echo "\n";
//		echo "{$east->format(DATE_W3C)}\n\n";
	}
}

class ScheduleLayout
{
	
}

class SchedulePeriod
{
	public function __construct($begin, $end, $label)
	{}
}