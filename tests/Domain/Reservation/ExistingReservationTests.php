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
		
		$repeatDaily = new RepeatDaily(
								1, 
								Date::Now()->AddDays(10), 
								$currentInstance->Duration());

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
		throw new Exception('working on this one');
		
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$series->With(new RepeatNone());
		
		$currentInstance = $series->CurrentInstance();
		
		$repeatDaily = new RepeatDaily(
								1, 
								Date::Now()->AddDays(10), 
								$currentInstance->Duration());

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
		
		// remove all future events
		$instanceRemovedEvent = new InstanceRemovedEvent($instance);
		
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