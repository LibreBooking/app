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
	
	public function testWhenApplyingUpdatesToSingleInstanceSeries()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions(new RepeatNone());
		$series = $builder->Build();
		
		$currentInstance = $series->CurrentInstance();
		
		$repeatDaily = new RepeatDaily(1, Date::Now()->AddDays(10));
		
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$series->Repeats($repeatDaily);
		
		$userId = 109;
		$resourceId = 209;
		$title = "new title here";
		$description = "new description here";
		$series->Update($userId, $resourceId, $title, $description);

		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "existing plus repeated dates");
		
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
	
	public function testWhenApplyingRecurranceUpdatesToFutureInstancesSeries()
	{
		$currentSeriesDate = DateRange::Create('2010-01-01 08:30:00', '2010-01-01 12:30:00', 'UTC');

		$oldRef = 'old';
		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation($oldRef, $oldDates);
		
		$currentRef = 'current';
		$currentInstance = new TestReservation($currentRef, $currentSeriesDate);
		
		$futureRef1 = 'new1';
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation($futureRef1, $futureDates1);
		
		$futureRef2 = 'new2';
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation($futureRef2, $futureDates2);
		
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
		$instanceRemovedEvent2 = new InstanceRemovedEvent($futureReservation1);
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

		$oldRef = 'old';
		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation($oldRef, $oldDates);
		
		$currentRef = 'current';
		$currentInstance = new TestReservation($currentRef, $currentSeriesDate);
		
		$futureRef1 = 'new1';
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation($futureRef1, $futureDates1);
		
		$futureRef2 = 'new2';
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation($futureRef2, $futureDates2);
		
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
		$this->assertTrue(in_array($seriesBranchedEvent, $events), "should have been branched");
	}
	
	public function testWhenApplyingRecurranceUpdatesToFullSeries()
	{
		$today = new DateRange(Date::Now(), Date::Now());
		
		$currentSeriesDate = $today->AddDays(5);

		$oldRef = 'old';
		$oldDates = $today->AddDays(-1);
		$oldReservation = new TestReservation($oldRef, $oldDates);
		
		$currentRef = 'current';
		$currentInstance = new TestReservation($currentRef, $currentSeriesDate);
		
		$futureRef1 = 'new1';
		$futureDates1 = $today->AddDays(1);
		$futureReservation1 = new TestReservation($futureRef1, $futureDates1);
		
		$futureRef2 = 'new2';
		$futureDates2 = $today->AddDays(10);
		$futureReservation2 = new TestReservation($futureRef2, $futureDates2);
		
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
		$instanceRemovedEvent2 = new InstanceRemovedEvent($futureReservation1);
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		
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
}
?>