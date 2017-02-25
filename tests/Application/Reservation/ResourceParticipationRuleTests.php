<?php
/**
Copyright 2013-2017 Nick Korbel

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

class ResourceParticipationRuleTests extends TestBase
{
	/**
	 * @var ResourceParticipationRule
	 */
	private $rule;

	/**
	 * @var FakeBookableResource
	 */
	private $resourceLimit10;

	/**
	 * @var FakeBookableResource
	 */
	private $resourceLimit20;

	public function setup()
	{
		parent::setup();

		$this->rule = new ResourceParticipationRule();

		$this->resourceLimit10 = new FakeBookableResource(1, 'name1');
		$this->resourceLimit10->SetMaxParticipants(10);
		$this->resourceLimit20 = new FakeBookableResource(2, 'name2');
		$this->resourceLimit20->SetMaxParticipants(20);
	}

	public function testWhenNeitherResourceIsOverLimit()
	{
		$series = new TestReservationSeries();
		$series->WithCurrentInstance(new TestReservation());
		$series->WithResource($this->resourceLimit10);
		$series->AddResource($this->resourceLimit20);
		$series->AddResource(new FakeBookableResource(3));
		$series->ChangeParticipants(range(1, 5));

		$result = $this->rule->Validate($series, null);

		$this->assertTrue($result->IsValid());
	}

	public function testWhenOneResourceIsOverLimit()
	{
		$series = new TestReservationSeries();
		$series->WithCurrentInstance(new TestReservation());
		$series->WithResource($this->resourceLimit10);
		$series->AddResource($this->resourceLimit20);
		$series->ChangeParticipants(range(1, 12));

		$result = $this->rule->Validate($series, null);
		$this->assertFalse($result->IsValid());
	}

	public function testWhenBothResourcesAreOverLimit()
	{
		$series = new TestReservationSeries();
		$series->WithCurrentInstance(new TestReservation());
		$series->WithResource($this->resourceLimit10);
		$series->AddResource($this->resourceLimit20);
		$series->ChangeParticipants(range(1, 22));

		$result = $this->rule->Validate($series, null);
		$this->assertFalse($result->IsValid());
	}
}
?>