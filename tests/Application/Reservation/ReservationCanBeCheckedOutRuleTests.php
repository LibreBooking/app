<?php

/**
 * Copyright 2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ReservationCanBeCheckedOutRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testCanBeCheckedOutIfCheckedInAndPastStartDate()
	{
		$resource1 = new FakeBookableResource(1);
		$resource1->SetCheckin(true);
		$resource2 = new FakeBookableResource(2);
		$resource2->SetCheckin(false);

		$reservation = new TestReservation(null, new DateRange(Date::Now(), Date::Now()->AddHours(1)));

		Date::_SetNow(Date::Now()->AddMinutes(30));

		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource($resource1);
		$series->WithCurrentInstance($reservation);
		$series->AddResource($resource2);
		$series->Checkin($this->fakeUser);

		$rule = new ReservationCanBeCheckedOutRule();
		$result = $rule->Validate($series, null);
		$this->assertTrue($result->IsValid());
	}

	public function testCannotBeCheckedOutIfNotCheckedIn()
	{
		$resource1 = new FakeBookableResource(1);
		$resource1->SetCheckin(true);

		$reservation = new TestReservation(null, new DateRange(Date::Now(), Date::Now()->AddHours(1)));

		Date::_SetNow(Date::Now()->AddMinutes(30));

		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource($resource1);
		$series->WithCurrentInstance($reservation);

		$rule = new ReservationCanBeCheckedOutRule();
		$result = $rule->Validate($series, null);
		$this->assertFalse($result->IsValid());
	}

	public function testCannotBeCheckedOutIfNotStarted()
	{
		$resource1 = new FakeBookableResource(1);
		$resource1->SetCheckin(true);

		$reservation = new TestReservation(null, new DateRange(Date::Now()->AddMinutes(30), Date::Now()->AddHours(1)));

		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource($resource1);
		$series->WithCurrentInstance($reservation);
		$series->Checkin($this->fakeUser);

		$rule = new ReservationCanBeCheckedOutRule();
		$result = $rule->Validate($series, null);
		$this->assertFalse($result->IsValid());
	}

	public function testCannotBeCheckedOutCheckoutNotEnabled()
	{
		$resource1 = new FakeBookableResource(1);
		$resource1->SetCheckin(false);

		$reservation = new TestReservation(null, new DateRange(Date::Now()->AddMinutes(30), Date::Now()->AddHours(1)));

		$series = new ExistingReservationSeries();
		$series->WithPrimaryResource($resource1);
		$series->WithCurrentInstance($reservation);
		$series->Checkin($this->fakeUser);

		$rule = new ReservationCanBeCheckedOutRule();
		$result = $rule->Validate($series, null);
		$this->assertFalse($result->IsValid());
	}

}