<?php
/**
Copyright 2011-2013 Nick Korbel

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

class ResourceCrossDayRuleTests extends TestBase
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var Schedule
	 */
	private $schedule;

	public function setup()
	{
		parent::setup();
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->schedule = new FakeSchedule();
		$this->schedule->SetTimezone('America/Chicago');
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testRuleIsValidIfBeginsAndEndsOnSameDayInScheduleTimezone()
	{
		$start = Date::Parse('2013-01-01 12:00', 'UTC');
		$end = $start->AddHours(2);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
		$resource = new FakeBookableResource(1);
		$resource->SetAllowMultiday(false);

		$reservation->WithResource($resource);

		$this->scheduleRepository->expects($this->once())
		->method('LoadById')
		->with($this->equalTo($reservation->ScheduleId()))
		->will($this->returnValue($this->schedule));

		$rule = new ResourceCrossDayRule($this->scheduleRepository);
		$result = $rule->Validate($reservation);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfAllResourcesAllowMultiDay()
	{
		$start = Date::Now();
		$end = Date::Now()->AddDays(1);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
		$resource = new FakeBookableResource(1);
		$resource->SetAllowMultiday(true);

		$resource2 = new FakeBookableResource(2);
		$resource2->SetAllowMultiday(true);

		$reservation->WithResource($resource);
		$reservation->AddResource($resource2);

		$rule = new ResourceCrossDayRule($this->scheduleRepository);
		$result = $rule->Validate($reservation);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsInValidIfReservationCrossesDayInScheduleTimezone()
	{
		$start = Date::Now();
		$end = Date::Now()->AddDays(1);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));
		$resource = new FakeBookableResource(1);
		$resource->SetAllowMultiday(true);

		$resource2 = new FakeBookableResource(2);
		$resource2->SetAllowMultiday(false);

		$reservation->WithResource($resource);
		$reservation->AddResource($resource2);

		$this->scheduleRepository->expects($this->once())
		->method('LoadById')
		->with($this->equalTo($reservation->ScheduleId()))
		->will($this->returnValue($this->schedule));

		$rule = new ResourceCrossDayRule($this->scheduleRepository);
		$result = $rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
	}

}

?>