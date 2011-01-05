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
		$this->markTestIncomplete("come back to this after reservation series is refactored");
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$series->WithRepeatOptions(new RepeatNone());
		
		$currentInstance = $series->CurrentInstance();
		
		$repeatDaily = new RepeatDaily(
								$interval, 
								Date::Now()->AddDays(10), 
								$currentInstance->Duration());
		
		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);	
		$series->UpdateDuration();
		$series->Update($userId, $resourceId, $scheduleId, $title, $description);
		$series->Repeats($repeatDaily);
		
		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances));
		$updates = $series->GetUpdates();
		
		// alter series
		// 
	}
}
?>