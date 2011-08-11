<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ReservationStartTimeRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testRuleIsValidStartTimeIsNow()
	{
		$start = Date::Now();
		$end = Date::Now()->AddDays(1);
		
		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
			
		$rule = new ReservationStartTimeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
		
	public function testRuleIsValidIfStartTimeIsInFuture()
	{
		$start = Date::Now()->AddDays(1);
		$end = Date::Now()->AddDays(2);
		
		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
			
		$rule = new ReservationStartTimeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertTrue($result->IsValid());
	}
	
	public function testRuleIsInvalidIfStartIsInPast()
	{
		$start = Date::Now()->AddDays(-2);
		$end = Date::Now()->AddDays(-1);
		
		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
			
		$rule = new ReservationStartTimeRule();
		$result = $rule->Validate($reservation);
		
		$this->assertFalse($result->IsValid());
	}

	public function testRuleIsInvalidIfStartTimeIsInPast()
	{
		$now = Date::Parse('2011-04-04 12:13:15', 'UTC');
		Date::_SetNow($now);
		$start = Date::Parse('2011-04-04 12:13:14', 'UTC');
		$end = $start->AddDays(5);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));

		$rule = new ReservationStartTimeRule();
		$result = $rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
	}
}

?>