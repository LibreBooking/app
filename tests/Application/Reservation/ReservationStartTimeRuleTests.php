<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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