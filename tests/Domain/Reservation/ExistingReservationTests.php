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

		$series->Repeats($repeatDaily);
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		
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
	
	public function testWhenApplyingUpdatesToFutureInstancesSeries()
	{
		$currentSeriesDate = DateRange::Create('2010-01-01 08:30:00', '2010-01-01 12:30:00', 'UTC');
		
		$currentRepeatOptions = new RepeatDaily(1, $currentSeriesDate->AddDays(50));
		
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$series->WithRepeatOptions($currentRepeatOptions);
		
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
	
		$series->WithInstance($oldReservation);
		$series->WithInstance($currentInstance);
		$series->WithInstance($newReservation1);
		$series->WithCurrentInstance($currentInstance);
		
		$repeatDaily = new RepeatDaily(
								1, 
								$currentSeriesDate->AddDays(10)->GetBegin());

		$series->Repeats($repeatDaily);
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		
		$userId = 109;
		$resourceId = 209;
		$title = "new title here";
		$description = "new description here";
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
		$this->assertTrue(in_array($seriesBranchedEvent, $events));
		
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