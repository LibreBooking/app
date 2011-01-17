<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/ExistingReservationSeriesBuilder.php');

class ExistingReservationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testWhenApplyingRecurrenceUpdatesToSingleInstanceSeries()
	{
		$repeatDaily = new RepeatDaily(1, Date::Now()->AddDays(10));
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions(new RepeatNone());
		$series = $builder->Build();
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$series->Repeats($repeatDaily);

		$instances = $series->Instances();
		$this->assertEquals(11, count($instances), "existing plus repeated dates");

		$currentInstance = $series->CurrentInstance();
		$events = $series->GetEvents();
		foreach ($instances as $instance)
		{
			if ($instance == $currentInstance)
			{
				continue;
			}
			
			$instanceAddedEvent = new InstanceAddedEvent($instance);
			$this->assertTrue(in_array($instanceAddedEvent, $events), "missing ref num {$instance->ReferenceNumber()}");
		}
	}
	
	public function testWhenApplyingSimpleUpdatesToSingleInstance()
	{
		$currentSeriesDate = new DateRange(Date::Now(), Date::Now());

		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation('old', $oldDates);
		
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation('new1', $futureDates1);
		
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation('new2', $futureDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($currentInstance);
		$builder->WithRepeatOptions($currentRepeatOptions);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureReservation1);
		$builder->WithInstance($futureReservation2);
		$series = $builder->Build();
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$series->Update(99, 999, 'new', 'new');
		$series->Repeats($currentRepeatOptions);

		$instances = $series->Instances();
		
		$this->assertEquals(1, count($instances), "should only be existing");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		$this->assertEquals(1, count($events));
		$this->assertEquals($seriesBranchedEvent, $events[0], "should have been branched");
	}
	
	public function testWhenApplyingRecurrenceUpdatesToFutureInstancesSeries()
	{
		$currentSeriesDate = DateRange::Create('2010-01-01 08:30:00', '2010-01-01 12:30:00', 'UTC');

		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation('old', $oldDates);
		
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation('new1', $futureDates1);
		
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation('new2', $futureDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());
		
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($currentRepeatOptions);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureReservation1);
		$builder->WithInstance($futureReservation2);
		$builder->WithCurrentInstance($currentInstance);
		$series = $builder->Build();		
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->Repeats($repeatDaily);

		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "1 existing, 10 repeated dates");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$instanceRemovedEvent1 = new InstanceRemovedEvent($futureReservation1);
		$instanceRemovedEvent2 = new InstanceRemovedEvent($futureReservation2);
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		
		$this->assertTrue(in_array($instanceRemovedEvent1, $events), "missing ref {$futureReservation1->ReferenceNumber()}");
		$this->assertTrue(in_array($instanceRemovedEvent2, $events), "missing ref {$futureReservation2->ReferenceNumber()}");
		$this->assertTrue(in_array($seriesBranchedEvent, $events), "should have been branched");
		
		// recreate all future events
		foreach ($instances as $instance)
		{
			if ($instance == $currentInstance)
			{
				continue;
			}
			
			$instanceAddedEvent = new InstanceAddedEvent($instance);
			$this->assertTrue(in_array($instanceAddedEvent, $events), "missing ref num {$instance->ReferenceNumber()}");
		}
	}
	
	public function testWhenApplyingSimpleUpdatesToFutureInstancesSeries()
	{
		$currentSeriesDate = new DateRange(Date::Now(), Date::Now());

		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation('old', $oldDates);
		
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation('new1', $futureDates1);
		
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation('new2', $futureDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($currentInstance);
		$builder->WithRepeatOptions($currentRepeatOptions);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureReservation1);
		$builder->WithInstance($futureReservation2);
		$series = $builder->Build();
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->Repeats($currentRepeatOptions);

		$instances = $series->Instances();
		
		$this->assertEquals(3, count($instances), "should only be existing and future instances");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		$this->assertEquals(1, count($events));
		$this->assertEquals($seriesBranchedEvent, $events[0], "should have been branched");
	}
	
	public function testWhenApplyingRecurrenceUpdatesToFullSeries()
	{
		$today = new DateRange(Date::Now(), Date::Now());
		
		$currentSeriesDate = $today->AddDays(5);

		$oldDates = $today->AddDays(-1);
		$oldReservation = new TestReservation('old', $oldDates);
		
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		
		$futureDates1 = $today->AddDays(1);
		$futureReservation1 = new TestReservation('new1', $futureDates1);
		
		$futureDates2 = $today->AddDays(10);
		$futureReservation2 = new TestReservation('new2', $futureDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());
		
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($currentRepeatOptions);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureReservation1);
		$builder->WithInstance($futureReservation2);
		$builder->WithCurrentInstance($currentInstance);
		$series = $builder->Build();
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Repeats($repeatDaily);

		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "1 existing, 10 repeated dates");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$instanceRemovedEvent1 = new InstanceRemovedEvent($futureReservation1);
		$instanceRemovedEvent2 = new InstanceRemovedEvent($futureReservation2);
		
		$this->assertTrue(in_array($instanceRemovedEvent1, $events), "missing ref {$futureReservation1->ReferenceNumber()}");
		$this->assertTrue(in_array($instanceRemovedEvent2, $events), "missing ref {$futureReservation2->ReferenceNumber()}");

		// recreate all future events
		foreach ($instances as $instance)
		{
			if ($instance == $currentInstance)
			{
				continue;
			}
			
			$instanceAddedEvent = new InstanceAddedEvent($instance);
			$this->assertTrue(in_array($instanceAddedEvent, $events), "missing ref num {$instance->ReferenceNumber()}");
		}
	}
	
	public function testWhenApplyingSimpleUpdatesToFullSeries()
	{
		$repeatOptions = new RepeatDaily(1, Date::Now());
		$dateRange = new TestDateRange();
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($repeatOptions);
		$builder->WithInstance(new TestReservation('123', $dateRange));
		$builder->WithCurrentInstance(new TestReservation('1', $dateRange->AddDays(5)));
		
		$series = $builder->Build();
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Update(9, 10, 'new', 'new');
		$series->Repeats($repeatOptions);
		
		$events = $series->GetEvents();
		
		$this->assertEquals(2, count($series->Instances()));
		$this->assertEquals(0, count($events));
	}
}
?>