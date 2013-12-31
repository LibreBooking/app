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
		$result = $rule->Validate($reservation);

		$this->assertTrue($result->IsValid());
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
		$result = $rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
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
		$result = $rule->Validate($reservation);

		$this->assertFalse($result->IsValid());
		$this->assertTrue(!is_null($result->ErrorMessage()));
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
		$reservation->WithDuration($reservationDates);
		$reservation->WithRepeatOptions($twoRepetitions);

		$strategy = $this->getMock('IResourceAvailabilityStrategy');

		$strategy->expects($this->exactly(1 + count($repeatDates)))
			->method('GetItemsBetween')
			->with($this->anything(), $this->anything())
			->will($this->returnValue(array()));

		$rule = new ResourceAvailabilityRule($strategy, 'UTC');
		$result = $rule->Validate($reservation);
	}

	public function testReservationStrategyChecksReservations()
	{
		$startDate = Date::Now();
		$endDate = Date::Now();

		$repository = $this->getMock('IReservationViewRepository');

		$strategy = new ResourceReservationAvailability($repository);

		$reservations = array();
		$repository->expects($this->once())
			->method('GetReservationList')
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
}


?>