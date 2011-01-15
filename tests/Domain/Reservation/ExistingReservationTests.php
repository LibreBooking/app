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
		$series = $builder->Build();
		$series->WithRepeatOptions(new RepeatNone());
		
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
		
		$newRef1 = 'new1';
		$newDates1 = $currentSeriesDate->AddDays(1);
		$newReservation1 = new TestReservation($newRef1, $newDates1);
		
		$newRef2 = 'new2';
		$newDates2 = $currentSeriesDate->AddDays(10);
		$newReservation2 = new TestReservation($newRef2, $newDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());
		
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$userId = 109;
		$resourceId = 209;
		$title = "new title here";
		$description = "new description here";
		
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		// existing state
		$series->WithRepeatOptions($currentRepeatOptions);
		$series->WithInstance($oldReservation);
		$series->WithInstance($currentInstance);
		$series->WithInstance($newReservation1);
		$series->WithCurrentInstance($currentInstance);
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->Repeats($repeatDaily);
		$series->Update($userId, $resourceId, $title, $description);

		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "1 existing, 10 repeated dates");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$instanceRemovedEvent1 = new InstanceRemovedEvent($newReservation1);
		$instanceRemovedEvent2 = new InstanceRemovedEvent($newReservation1);
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		
		$this->assertTrue(in_array($instanceRemovedEvent1, $events), "missing ref {$newReservation1->ReferenceNumber()}");
		$this->assertTrue(in_array($instanceRemovedEvent2, $events), "missing ref {$newReservation2->ReferenceNumber()}");
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
		$currentSeriesDate = DateRange::Create('2010-01-01 08:30:00', '2010-01-01 12:30:00', 'UTC');

		$oldRef = 'old';
		$oldDates = $currentSeriesDate->AddDays(-1);
		$oldReservation = new TestReservation($oldRef, $oldDates);
		
		$currentRef = 'current';
		$currentInstance = new TestReservation($currentRef, $currentSeriesDate);
		
		$newRef1 = 'new1';
		$newDates1 = $currentSeriesDate->AddDays(1);
		$newReservation1 = new TestReservation($newRef1, $newDates1);
		
		$newRef2 = 'new2';
		$newDates2 = $currentSeriesDate->AddDays(10);
		$newReservation2 = new TestReservation($newRef2, $newDates2);
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50)->GetBegin());

		$userId = 109;
		$resourceId = 209;
		$title = "new title here";
		$description = "new description here";
		
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		// existing state
		$series->WithRepeatOptions($currentRepeatOptions);
		$series->WithInstance($oldReservation);
		$series->WithInstance($currentInstance);
		$series->WithInstance($newReservation1);
		$series->WithCurrentInstance($currentInstance);
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->Repeats($currentRepeatOptions);
		$series->Update($userId, $resourceId, $title, $description);

		$instances = $series->Instances();
		
		$this->assertEquals(3, count($instances), "should only be existing, future instances");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		$this->assertEquals(1, count($events));
		$this->assertTrue(in_array($seriesBranchedEvent, $events), "should have been branched");
	}
}
?>