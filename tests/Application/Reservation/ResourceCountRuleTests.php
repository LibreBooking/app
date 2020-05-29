<?php
/**
Copyright 2011-2020 Nick Korbel

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

class ResourceCountRuleTests extends TestBase
{
	/**
	 * @var FakeScheduleRepository
	 */
	private $scheduleRepository;

	public function setUp(): void
	{
		parent::setUp();
		$this->scheduleRepository = new FakeScheduleRepository();
		$this->scheduleRepository->_Schedule = new FakeSchedule();
	}

	public function testFailsIfReservingMoreResourcesThanAllowed()
	{
		$this->scheduleRepository->_Schedule->SetMaxResourcesPerReservation(1);

		$resource1 = new FakeBookableResource(1, "1");
		$resource2 = new FakeBookableResource(2, "2");

		$reservation = new TestReservationSeries();
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);

		$rule = new ResourceCountRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testOkIfLessThanAllowed()
	{
		$this->scheduleRepository->_Schedule->SetMaxResourcesPerReservation(2);

        $resource1 = new FakeBookableResource(1, "1");
        $resource2 = new FakeBookableResource(2, "2");

        $reservation = new TestReservationSeries();
        $reservation->WithResource($resource1);
        $reservation->AddResource($resource2);

        $rule = new ResourceCountRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testOkIfAllowedNotSet()
	{
		$this->scheduleRepository->_Schedule->SetMaxResourcesPerReservation(0);

        $resource1 = new FakeBookableResource(1, "1");
        $resource2 = new FakeBookableResource(2, "2");

        $reservation = new TestReservationSeries();
        $reservation->WithResource($resource1);
        $reservation->AddResource($resource2);

        $rule = new ResourceCountRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}
}