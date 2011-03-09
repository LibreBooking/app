<?php
class ExistingReservationDeleteTests extends TestBase
{
	public function setup()
	{
		parent::setup();
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
		$series->Delete();
		
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
		$series->Delete();
		
		$events = $series->GetEvents();
		
		$this->assertTrue(in_array(new InstanceRemovedEvent($current), $events));
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
		$series->Delete();
		
		$events = $series->GetEvents();
		
		$this->assertEquals(3, count($events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($current), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future1), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future2), $events));
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
		$series->Delete();
		
		$events = $series->GetEvents();
		
		$this->assertTrue(in_array(new InstanceRemovedEvent($current), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future1), $events));
		$this->assertTrue(in_array(new InstanceRemovedEvent($future2), $events));
		$this->assertTrue(!in_array(new InstanceRemovedEvent($past), $events));
	}
}
?>