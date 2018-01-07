<?php
/**
Copyright 2011-2018 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class ReservationValidationRuleProcessorTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testValidatesAgainstAllRules()
	{
		$reservation = new ExistingReservationSeries();
		$validResult = new ReservationRuleResult(true);

		$rule1 = $this->getMock('IUpdateReservationValidationRule');
		$rule2 = $this->getMock('IUpdateReservationValidationRule');
		$rule3 = $this->getMock('IUpdateReservationValidationRule');

		$rule1->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));

		$rule2->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));

		$rule3->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));

		$rules = array($rule1, $rule2, $rule3);

		$vs = new ReservationValidationRuleProcessor($rules);
		$result = $vs->Validate($reservation);

		$this->assertEquals(true, $result->CanBeSaved());
		$this->assertEquals(0, count($result->GetErrors()));
		$this->assertEquals(0, count($result->GetWarnings()));
	}

	public function testValidatesStopsAfterFirstBrokenRule()
	{
		$reservation = new ExistingReservationSeries();

		$rule1 = $this->getMock('IUpdateReservationValidationRule');
		$rule2 = $this->getMock('IUpdateReservationValidationRule');
		$rule3 = $this->getMock('IUpdateReservationValidationRule');

		$rules = array($rule1, $rule2, $rule3);

		$rule1->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue(new ReservationRuleResult()));

		$error = 'something went wrong';
		$retryMessage = 'retry message';
		$retryParams = array(new ReservationRetryParameter('n', 'v'));

		$rule2->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue(new ReservationRuleResult(false, $error, true, $retryMessage, $retryParams)));

		$vs = new ReservationValidationRuleProcessor($rules);

		$result = $vs->Validate($reservation);

		$this->assertEquals(false, $result->CanBeSaved());
		$actualErrors = $result->GetErrors();
		$this->assertEquals($error, $actualErrors[0]);
		$this->assertEquals(0, count($result->GetWarnings()));
		$this->assertEquals(true, $result->CanBeRetried());
		$this->assertEquals(array($retryMessage), $result->GetRetryMessages());
		$this->assertEquals($retryParams, $result->GetRetryParameters());
	}
}