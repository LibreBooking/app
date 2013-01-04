<?php
/**
Copyright 2011-2013 Nick Korbel

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

class ExistingReservationDeleteTests extends TestBase
{
	/**
	 * @var FakeUserSession
	 */
	private $user;

	/**
	 * @var FakeUserSession
	 */
	private $admin;
	
	public function setup()
	{
		parent::setup();

		$this->user = new FakeUserSession();
		$this->admin = new FakeUserSession(true);
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testDeleteCurrentInstanceWithOnlyOneInstance()
	{
		$reservation = new TestReservation();
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($reservation);
		
		$series = $builder->Build();
		
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$series->Delete($this->user);
		
		$events = $series->GetEvents();
		
		$this->assertTrue(in_array(new SeriesDeletedEvent($series), $events));
	}
	
	public function testDeleteCurrentInstanceWithManyInstances()
	{
		$current = new TestReservation();
		$current->SetReservationDate(TestDateRange::CreateWithDays(1));
		
		$reservation = new TestReservation();
		$reservation->SetReservationDate(TestDateRange::CreateWithDays(2));
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($current);
		$builder->WithInstance($reservation);
		
		$series = $builder->Build();
		
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$series->Delete($this->user);
		
		$events = $series->GetEvents();
		
		$this->assertTrue(in_array(new InstanceRemovedEvent($current, $series), $events));
	}
	
	public function testDeleteAllInstancesDeletesInstancesAfterTodaysDate()
	{
		$current = new TestReservation();
		$current->SetReservationDate(TestDateRange::CreateWithDays(1));
		
		$past = new TestReservation();
		$past->SetReservationDate(TestDateRange::CreateWithDays(-1));
		
		$future1 = new TestReservation();
		$future1->SetReservationDate(TestDateRange::CreateWithDays(2));
		
		$future2 = new TestReservation();
		$future2->SetReservationDate(TestDateRange::CreateWithDays(20));
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($current);
		$builder->WithInstance($past);
		$builder->WithInstance($future1);
		$builder->WithInstance($future2);
		
		$series = $builder->Build();
		
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Delete($this->user);
		
		$events = $series->GetEvents();
		
		$this->assertEquals(3, count($events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($current, $series), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future1, $series), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future2, $series), $events));
	}
	
	public function testDeleteFutureInstancesDeletesCurrentAndFutureInstances()
	{
		$current = new TestReservation();
		$current->SetReservationDate(TestDateRange::CreateWithDays(2));
		
		$past = new TestReservation();
		$past->SetReservationDate(TestDateRange::CreateWithDays(1));
		
		$future1 = new TestReservation();
		$future1->SetReservationDate(TestDateRange::CreateWithDays(3));
		
		$future2 = new TestReservation();
		$future2->SetReservationDate(TestDateRange::CreateWithDays(20));
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($current);
		$builder->WithInstance($past);
		$builder->WithInstance($future1);
		$builder->WithInstance($future2);
		
		$series = $builder->Build();
		
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->Delete($this->user);
		
		$events = $series->GetEvents();
		
		$this->assertTrue(in_array(new InstanceRemovedEvent($current, $series), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future1, $series), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future2, $series), $events));
		$this->assertTrue(!in_array(new InstanceRemovedEvent($past, $series), $events));
	}
	
	public function testDeleteFullSeriesWithAllInstancesInFuture()
	{
		$current = new TestReservation();
		$current->SetReservationDate(TestDateRange::CreateWithDays(1));
		
		$future1 = new TestReservation();
		$future1->SetReservationDate(TestDateRange::CreateWithDays(2));
		
		$future2 = new TestReservation();
		$future2->SetReservationDate(TestDateRange::CreateWithDays(20));
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($current);
		$builder->WithInstance($future1);
		$builder->WithInstance($future2);
		
		$series = $builder->Build();
		
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Delete($this->user);
		
		$events = $series->GetEvents();
		
		$this->assertEquals(1, count($events));
		$this->assertTrue(in_array(new SeriesDeletedEvent($series), $events));
	}

	public function testDeletesWholeSeriesWhenAdminRegardlessOfDate()
	{
		$r1 = new TestReservation();
		$r1->SetReservationDate(TestDateRange::CreateWithDays(-1));

		$r2 = new TestReservation();
		$r2->SetReservationDate(TestDateRange::CreateWithDays(-2));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($r1);
		$builder->WithInstance($r2);

		$series = $builder->Build();

		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Delete($this->admin);

		$events = $series->GetEvents();

		$this->assertEquals(1, count($events));
		$this->assertTrue(in_array(new SeriesDeletedEvent($series), $events));
	}
}
?>