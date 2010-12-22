<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationDateTimeRuleTests extends TestBase
{
	public function testEnsuresThatStartMustBeBeforeEnd()
	{
		$start = Date::Parse('2010-01-01');
		
		$reservationDate = new DateRange($start, $start->AddDays(-1));
		
		$reservationSeries = new ReservationSeries();
		$reservationSeries->UpdateDuration($reservationDate);
		
		$rule = new ReservationDateTimeRule();
		
		$result = $rule->Validate($reservationSeries);
		
		$this->assertFalse($result->IsValid());
	}
}