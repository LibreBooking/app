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
		throw new Exception('working on this');
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$series->WithRepeatOptions(new RepeatNone());
		
		$currentInstance = $series->CurrentInstance();
		
		$repeatDaily = new RepeatDaily(
								1, 
								Date::Now()->AddDays(10), 
								$currentInstance->Duration());

		$series->ApplyChangesTo(SeriesUpdateScope::ThisInstance);	
		$series->Update($userId, $resourceId, $title, $description);
		$series->Repeats($repeatDaily);
		
		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "existing plus repeated dates");
		$updates = $series->GetUpdates();
		
		
		// alter series
		// 
	}
}
?>