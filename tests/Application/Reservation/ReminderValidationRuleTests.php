<?php
/**
Copyright 2013-2016 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReminderValidationRuleTests extends TestBase
{
	public function testWhenEnabledAndValid()
	{
		$series = new TestReservationSeries();
		$series->AddStartReminder(new ReservationReminder(2, ReservationReminderInterval::Days));
		$series->AddEndReminder(new ReservationReminder(1, ReservationReminderInterval::Days));
		$rule = new ReminderValidationRule();
		$result = $rule->Validate($series, null);

		$this->assertTrue($result->IsValid());
	}

	public function testWhenEnabledAnInvalidValue()
	{
		$series = new TestReservationSeries();
		$series->AddStartReminder(new ReservationReminder('abc', ReservationReminderInterval::Days));
		$rule = new ReminderValidationRule();
		$result = $rule->Validate($series, null);

		$this->assertFalse($result->IsValid());
	}

	public function testWhenEnabledAnInvalidInterval()
	{
		$series = new TestReservationSeries();
		$series->AddEndReminder(new ReservationReminder('abc', ReservationReminderInterval::Days));
		$rule = new ReminderValidationRule();
		$result = $rule->Validate($series, null);

		$this->assertFalse($result->IsValid());
	}
}

?>