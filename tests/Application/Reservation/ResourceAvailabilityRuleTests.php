<?php
/**
 * Copyright 2011-2016 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ResourceAvailabilityRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testRuleIsValidIfNoConflictsForTheReservationResources()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-05', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(100, null));
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource(new FakeBookableResource(101, null));
		$reservation->AddResource(new FakeBookableResource(102, null));

		$scheduleReservation = new TestReservationItemView(2, $startDate, $endDate, 1);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue(array($scheduleReservation)));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
		$this->assertFalse($result->CanBeRetried());
	}

	public function testGetsConflictingReservationTimesForSingleDateSingleResource()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');
		$resourceId = 100;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource($resourceId));
		$reservation->WithDuration(new DateRange($startDate, $endDate));

		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');

		$startConflict2 = Date::Parse('2010-04-05', 'UTC');
		$endConflict2 = Date::Parse('2010-04-08', 'UTC');

		$startNonConflict1 = Date::Parse('2010-04-06', 'UTC');
		$endNonConflict1 = Date::Parse('2010-04-08', 'UTC');

		$startNonConflict2 = Date::Parse('2010-04-02', 'UTC');
		$endNonConflict2 = Date::Parse('2010-04-04', 'UTC');

		$reservations = array(
				new TestReservationItemView(2, $startConflict1, $endConflict1, $resourceId),
				new TestReservationItemView(3, $startConflict2, $endConflict2, 2),
				new TestReservationItemView(4, $startNonConflict1, $startNonConflict2, $resourceId),
				new TestReservationItemView(5, $startNonConflict2, $endNonConflict2, $resourceId),
		);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue($reservations));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
		$this->assertFalse($result->CanBeRetried());
        $this->assertTrue($result->CanJoinWaitlist());
	}

	public function testGetsConflictingReservationTimesForSingleDateMultipleResources()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');
		$additionalResourceId = 1;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(100));
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->AddResource(new FakeBookableResource($additionalResourceId));

		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');

		$startConflict2 = Date::Parse('2010-04-05', 'UTC');
		$endConflict2 = Date::Parse('2010-04-08', 'UTC');

		$reservations = array(
				new TestReservationItemView(2, $startConflict1, $endConflict1, 2),
				new TestReservationItemView(3, $startConflict2, $endConflict2, $additionalResourceId),
		);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue($reservations));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
	}

	public function testRuleIsValidIfNoConflictsForTheReservationResourcesWithBufferTimes()
	{
		$startDate = Date::Parse('2010-04-04 06:00', 'UTC');
		$endDate = Date::Parse('2010-04-04 07:00', 'UTC');

		$r1Buffer = 60 * 60;
		$r2Buffer = 30 * 60;

		$reservation = new TestReservationSeries();
		$resource1 = new FakeBookableResource(100, null);
		$resource1->SetBufferTime($r1Buffer);

		$resource2 = new FakeBookableResource(101, null);
		$resource2->SetBufferTime($r2Buffer);

		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->WithResource($resource1);
		$reservation->AddResource($resource2);
		$reservation->AddResource(new FakeBookableResource(102, null));

		$scheduleReservation1 = new TestReservationItemView(2,
															Date::Parse('2010-04-04 04:00', 'UTC'),
															Date::Parse('2010-04-04 05:00', 'UTC'),
															$resource1->GetId());
		$scheduleReservation1->WithBufferTime($r1Buffer);

		$scheduleReservation2 = new TestReservationItemView(3,
															Date::Parse('2010-04-04 08:00', 'UTC'),
															Date::Parse('2010-04-04 09:00', 'UTC'),
															$resource1->GetId());
		$scheduleReservation2->WithBufferTime($r1Buffer);

		$scheduleReservation3 = new TestReservationItemView(4,
															Date::Parse('2010-04-04 05:00', 'UTC'),
															Date::Parse('2010-04-04 05:30', 'UTC'),
															$resource2->GetId());

		$scheduleReservation3->WithBufferTime($r2Buffer);

		$scheduleReservation4 = new TestReservationItemView(5,
															Date::Parse('2010-04-04 07:30', 'UTC'),
															Date::Parse('2010-04-04 08:00', 'UTC'),
															$resource2->GetId());

		$scheduleReservation4->WithBufferTime($r2Buffer);

		$scheduleReservation5 = new TestReservationItemView(6, $startDate, $endDate, 999);
		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate->AddMinutes(-60)), $this->equalTo($endDate->AddMinutes(60)))
				 ->will($this->returnValue(array($scheduleReservation1, $scheduleReservation2, $scheduleReservation3, $scheduleReservation4, $scheduleReservation5)));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testGetsConflictingReservationTimesForSingleDateSingleResourceWithBufferTimes()
	{
		$startDate = Date::Parse('2010-04-04 06:00', 'UTC');
		$endDate = Date::Parse('2010-04-04 07:00', 'UTC');

		$bufferTime = 60 * 60;

		$reservation = new TestReservationSeries();
		$resource1 = new FakeBookableResource(100, null);
		$resource1->SetBufferTime($bufferTime);

		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->WithResource($resource1);

		$conflict1 = new TestReservationItemView(2,
												 Date::Parse('2010-04-04 04:00', 'UTC'),
												 Date::Parse('2010-04-04 06:00', 'UTC'),
												 $resource1->GetId());
		$conflict1->WithBufferTime($bufferTime);

		$conflict2 = new TestReservationItemView(3,
												 Date::Parse('2010-04-04 07:00', 'UTC'),
												 Date::Parse('2010-04-04 08:00', 'UTC'),
												 $resource1->GetId());
		$conflict2->WithBufferTime($bufferTime);

		$nonConflict1 = new TestReservationItemView(4,
													Date::Parse('2010-04-04 06:00', 'UTC'),
													Date::Parse('2010-04-04 07:30', 'UTC'),
													2);

		$nonConflict1->WithBufferTime($bufferTime);

		$nonConflict2 = new TestReservationItemView(5,
													Date::Parse('2010-04-04 02:30', 'UTC'),
													Date::Parse('2010-04-04 05:00', 'UTC'),
													$resource1->GetId());
		$nonConflict2->WithBufferTime($bufferTime);

		$nonConflict3 = new TestReservationItemView(6,
													Date::Parse('2010-04-04 08:00', 'UTC'),
													Date::Parse('2010-04-04 09:00', 'UTC'),
													$resource1->GetId());
		$nonConflict3->WithBufferTime($bufferTime);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate->AddMinutes(-60)), $this->equalTo($endDate->AddMinutes(60)))
				 ->will($this->returnValue(array($conflict1, $conflict2, $nonConflict1, $nonConflict2, $nonConflict3)));


		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testApplicationAdminsAreExcludedFromBufferConstraints()
	{
		$startDate = Date::Parse('2010-04-04 06:00', 'UTC');
		$endDate = Date::Parse('2010-04-04 07:00', 'UTC');

		$bufferTime = 60 * 60;

		$reservation = new TestReservationSeries();
		$resource1 = new FakeBookableResource(100, null);
		$resource1->SetBufferTime($bufferTime);


		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$reservation->WithResource($resource1);
		$reservation->WithBookedBy(new FakeUserSession(true));

		$conflict1 = new TestReservationItemView(2,
												 Date::Parse('2010-04-04 04:00', 'UTC'),
												 Date::Parse('2010-04-04 06:00', 'UTC'),
												 $resource1->GetId());
		$conflict1->WithBufferTime($bufferTime);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->once())
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue(array($conflict1)));


		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testValidatesEachDateThatAReservationRepeatsOn()
	{
		$start = Date::Parse('2010-01-01');
		$end = Date::Parse('2010-01-02');
		$reservationDates = new DateRange($start, $end);
		$twoRepetitions = new RepeatWeekly(1,
										   $start->AddDays(14),
										   array($start->Weekday()));

		$repeatDates = $twoRepetitions->GetDates($reservationDates);

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(1));
		$reservation->WithDuration($reservationDates);
		$reservation->WithRepeatOptions($twoRepetitions);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->exactly(1 + count($repeatDates)))
				 ->method('GetItemsBetween')
				 ->with($this->anything(), $this->anything())
				 ->will($this->returnValue(array()));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);
	}

	public function testReservationStrategyChecksReservations()
	{
		$startDate = Date::Now();
		$endDate = Date::Now();

		$repository = $this->getMock('IReservationViewRepository');

		$strategy = new ResourceReservationAvailability($repository);

		$reservations = array();
		$repository->expects($this->once())
				   ->method('GetReservations')
				   ->with($this->equalTo($startDate), $this->equalTo($endDate))
				   ->will($this->returnValue($reservations));

		$items = $strategy->GetItemsBetween($startDate, $endDate);

		$this->assertEquals($reservations, $items);
	}

	public function testBlackoutStrategyChecksBlackouts()
	{
		$startDate = Date::Now();
		$endDate = Date::Now();

		$repository = $this->getMock('IReservationViewRepository');

		$strategy = new ResourceBlackoutAvailability($repository);

		$blackouts = array();
		$repository->expects($this->once())
				   ->method('GetBlackoutsWithin')
				   ->with($this->equalTo(new DateRange($startDate, $endDate)))
				   ->will($this->returnValue($blackouts));

		$items = $strategy->GetItemsBetween($startDate, $endDate);

		$this->assertEquals($blackouts, $items);
	}

	public function testCanRetryIfThereAreConflictsThatCanBeSkipped()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(100));
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$instance = DateRange::Create('2010-04-10', '2010-04-12', 'UTC');
		$reservation->WithInstanceOn($instance);

		$startConflict1 = Date::Parse('2010-04-04', 'UTC');
		$endConflict1 = Date::Parse('2010-04-08', 'UTC');

		$reservations = array(
				new TestReservationItemView(2, $startConflict1, $endConflict1, 100),
		);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->at(0))
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue($reservations));

		$strategy->expects($this->at(1))
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($instance->GetBegin()), $this->equalTo($instance->GetEnd()))
				 ->will($this->returnValue(array()));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->CanBeRetried(),
						  'should only be able to retry if there are less conflicts than dates reserved');
		$this->assertEquals(array(new ReservationRetryParameter('skipconflicts', true)), $result->RetryParameters());
	}

	public function testSkipsConflictsIfRequested()
	{
		$startDate = Date::Parse('2010-04-04', 'UTC');
		$endDate = Date::Parse('2010-04-06', 'UTC');

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(100));
		$reservation->WithDuration(new DateRange($startDate, $endDate));
		$instance = DateRange::Create('2010-04-10', '2010-04-12', 'UTC');
		$reservation->WithInstanceOn($instance);

		$startConflict1 = Date::Parse('2010-04-10', 'UTC');
		$endConflict1 = Date::Parse('2010-04-11', 'UTC');

		$reservations = array(
				new TestReservationItemView(2, $startConflict1, $endConflict1, 100),
		);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->at(0))
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($startDate), $this->equalTo($endDate))
				 ->will($this->returnValue(array()));

		$strategy->expects($this->at(1))
				 ->method('GetItemsBetween')
				 ->with($this->equalTo($instance->GetBegin()), $this->equalTo($instance->GetEnd()))
				 ->will($this->returnValue($reservations));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation, array(new ReservationRetryParameter('skipconflicts', true)));

		$this->assertTrue($result->IsValid(), 'should have skipped conflicts');
		$this->assertEquals(1, count($reservation->Instances()));
	}
}