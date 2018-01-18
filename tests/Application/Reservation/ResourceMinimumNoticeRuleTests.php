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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ResourceMinimumNoticeRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testMinNoticeIsCheckedAgainstEachReservationInstanceForEachResourceWhenAdding()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNoticeAdd(null);

		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNoticeAdd("25h00m");

		$reservation = new TestReservationSeries();

		$duration = new DateRange(Date::Now(), Date::Now());
		$tooSoon = Date::Now()->AddDays(1);
		$reservation->WithDuration($duration);
		$reservation->WithRepeatOptions(new RepeatDaily(1, $tooSoon));
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$rule = new ResourceMinimumNoticeRuleAdd($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testOkIfLatestInstanceIsBeforeTheMinimumNoticeTimeWhenAdding()
	{
		$resource = new FakeBookableResource(1, "2");
		$resource->SetMinNoticeAdd("1h00m");

		$reservation = new TestReservationSeries();
		$reservation->WithResource($resource);

		$duration = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(1));
		$reservation->WithDuration($duration);

		$rule = new ResourceMinimumNoticeRuleAdd($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testMinNoticeIsEnforcedIfOriginalStartDateOfCurrentInstanceIsAfterTheMinimumTime()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNoticeUpdate(null);

		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNoticeUpdate("25h00m");

        $originalStartDate = new DateRange(Date::Now()->AddHours(24), Date::Now()->AddHours(25));
		$reservation = new TestHelperExistingReservationSeries();
		$reservation->WithCurrentInstance(new Reservation($reservation, $originalStartDate));
		$reservation->WithInstance(new Reservation($reservation, $originalStartDate->AddDays(10)));

		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$reservation->UpdateDuration(new DateRange(Date::Now()->AddHours(26), Date::Now()->AddHours(27)));

		$rule = new ResourceMinimumNoticeRuleUpdate($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testMinNoticeIsEnforcedIfNewStartDateOfCurrentInstanceIsAfterTheMinimumTime()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNoticeUpdate(null);

		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNoticeUpdate("25h00m");

        $originalStartDate = new DateRange(Date::Now()->AddHours(26), Date::Now()->AddHours(27));
		$reservation = new TestHelperExistingReservationSeries();
		$reservation->WithCurrentInstance(new Reservation($reservation, $originalStartDate));
        $reservation->WithInstance(new Reservation($reservation, $originalStartDate->AddDays(10)));

		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$reservation->UpdateDuration(new DateRange(Date::Now()->AddHours(24), Date::Now()->AddHours(25)));

		$rule = new ResourceMinimumNoticeRuleUpdate($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testMinNoticeIsEnforcedEvenIfDateNotChanged()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNoticeUpdate(null);

		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNoticeUpdate("25h00m");

        $originalStartDate = new DateRange(Date::Now()->AddHours(24), Date::Now()->AddHours(25));
		$reservation = new TestHelperExistingReservationSeries();
		$reservation->WithCurrentInstance(new Reservation($reservation, $originalStartDate));

		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$rule = new ResourceMinimumNoticeRuleUpdate($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testMinNoticeIsNotEnforcedEvenIfDateNotChanged()
	{
		$resource1 = new FakeBookableResource(1, "1");
		$resource1->SetMinNoticeUpdate(null);

		$resource2 = new FakeBookableResource(2, "2");
		$resource2->SetMinNoticeUpdate("25h00m");

        $originalStartDate = new DateRange(Date::Now()->AddHours(26), Date::Now()->AddHours(27));
		$reservation = new TestHelperExistingReservationSeries();
		$reservation->WithCurrentInstance(new Reservation($reservation, $originalStartDate));

		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$rule = new ResourceMinimumNoticeRuleUpdate($this->fakeUser);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testMinNoticeIsOKIfOriginalAndNewStartDateOfCurrentInstanceIsBeforeTheMinimumTime()
	{
        $resource1 = new FakeBookableResource(1, "1");
        $resource1->SetMinNoticeUpdate(null);

        $resource2 = new FakeBookableResource(2, "2");
        $resource2->SetMinNoticeUpdate("25h00m");

        $originalStartDate = new DateRange(Date::Now()->AddHours(25), Date::Now()->AddHours(26));
        $reservation = new TestHelperExistingReservationSeries();
        $reservation->WithCurrentInstance(new Reservation($reservation, $originalStartDate));
        $reservation->WithInstance(new Reservation($reservation, $originalStartDate->AddDays(10)));

        $reservation->WithResource($resource1);
        $reservation->AddResource($resource2);

        $reservation->UpdateDuration(new DateRange(Date::Now()->AddHours(26), Date::Now()->AddHours(27)));

        $rule = new ResourceMinimumNoticeRuleUpdate($this->fakeUser);
        $result = $rule->Validate($reservation, null);

        $this->assertTrue($result->IsValid());
	}

    public function testMinNoticeIsCheckedAgainstEachReservationInstanceForEachResourceWhenDeleting()
    {
        $resource1 = new FakeBookableResource(1, "1");
        $resource1->SetMinNoticeAdd(null);

        $resource2 = new FakeBookableResource(2, "2");
        $resource2->SetMinNoticeAdd("25h00m");

        $reservation = new TestReservationSeries();

        $duration = new DateRange(Date::Now(), Date::Now());
        $tooSoon = Date::Now()->AddDays(1);
        $reservation->WithDuration($duration);
        $reservation->WithRepeatOptions(new RepeatDaily(1, $tooSoon));
        $reservation->WithResource($resource1);
        $reservation->AddResource($resource2);

        $rule = new ResourceMinimumNoticeRuleDelete($this->fakeUser);
        $result = $rule->Validate($reservation, null);

        $this->assertFalse($result->IsValid());
    }

    public function testOkIfLatestInstanceIsBeforeTheMinimumNoticeTimeWhenDeleting()
    {
        $resource = new FakeBookableResource(1, "2");
        $resource->SetMinNoticeAdd("1h00m");

        $reservation = new TestReservationSeries();
        $reservation->WithResource($resource);

        $duration = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(1));
        $reservation->WithDuration($duration);

        $rule = new ResourceMinimumNoticeRuleDelete($this->fakeUser);
        $result = $rule->Validate($reservation, null);

        $this->assertTrue($result->IsValid());
    }

}