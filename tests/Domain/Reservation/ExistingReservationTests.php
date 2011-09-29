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
		$series->Update(99, new FakeBookableResource(999), 'new', 'new', new FakeUserSession());
		$series->Repeats($currentRepeatOptions);

		$instances = $series->Instances();
		
		$this->assertEquals(1, count($instances), "should only be existing");
		
		$events = $series->GetEvents();
		
		// remove all future events
		$seriesBranchedEvent = new SeriesBranchedEvent($series);
		$this->assertTrue($series->RequiresNewSeries(), "should require new series if this instance in a series is altered");
		$this->assertEquals(1, count($events));
		$this->assertEquals($seriesBranchedEvent, $events[0], "should have been branched");
		$this->assertEquals(new RepeatNone(), $series->RepeatOptions(), "repeat options should be cleared for new instance");
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
		
		$this->assertEquals(13, count($events), "1 branched, 10 created, 2 removed");
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

		$oldDates = $today->AddDays(-1);
		$oldReservation = new TestReservation('old', $oldDates);
				
		$currentSeriesDate = $today->AddDays(5);
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		
		$futureDates1 = $today->AddDays(1);
		$afterTodayButBeforeCurrent = new TestReservation('new1', $futureDates1);
		
		$futureDates2 = $today->AddDays(10);
		$afterCurrent = new TestReservation('new2', $futureDates2);
		
		$currentRepeatOptions = new RepeatYearly(1, $currentSeriesDate->AddDays(400)->GetBegin());
		
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($currentRepeatOptions);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($afterTodayButBeforeCurrent);
		$builder->WithInstance($afterCurrent);
		$builder->WithCurrentInstance($currentInstance);
		$series = $builder->Build();
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Repeats($repeatDaily);

		$instances = $series->Instances();
		
		$this->assertEquals(11, count($instances), "1 old, 1 current, 10 repeated dates");
		$this->assertTrue(in_array($currentInstance, $instances));
		
		$events = $series->GetEvents();
		
		$this->assertEquals(12, count($events), "2 removals, 10 adds");
		// remove all future events
		$instanceRemovedEvent1 = new InstanceRemovedEvent($afterTodayButBeforeCurrent);
		$instanceRemovedEvent2 = new InstanceRemovedEvent($afterCurrent);
		
		$this->assertTrue(in_array($instanceRemovedEvent1, $events), "missing ref {$afterTodayButBeforeCurrent->ReferenceNumber()}");
		$this->assertTrue(in_array($instanceRemovedEvent2, $events), "missing ref {$afterCurrent->ReferenceNumber()}");

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
	
	public function testWhenExtendingEndDateOfRepeatOptionsOnFullSeries()
	{
		$currentSeriesDate = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(1));
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		$futureInstance = new TestReservation('future', $currentSeriesDate->AddDays(11));
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($repeatDaily);
		$builder->WithInstance(new TestReservation('past', $currentSeriesDate->AddDays(-1)));
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureInstance);
		$builder->WithCurrentInstance($currentInstance);
		
		$series = $builder->Build();
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Repeats(new RepeatDaily(1, $currentSeriesDate->AddDays(20)->GetBegin()));
		
		$instances = $series->Instances();
		$this->assertEquals(22, count($instances), "1 past, 1 current, 20 future (including existing instance)");
		$this->assertTrue(in_array($currentInstance, $instances), "current should not have been altered");
		$this->assertTrue(in_array($futureInstance, $instances), "existing future should not have been altered");
		
		$events = $series->GetEvents();
		$this->assertEquals(19, count($events), "should have nothing other than new instance created events");
	}
	
	public function testWhenReducingEndDateOfRepeatOptionsOnFullSeries()
	{
		$currentSeriesDate = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(1));
		$currentInstance = new TestReservation('current', $currentSeriesDate);
		$futureInstance = new TestReservation('future', $currentSeriesDate->AddDays(20));
		$repeatDaily = new RepeatDaily(1, $currentSeriesDate->AddDays(10)->GetBegin());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($repeatDaily);
		$builder->WithInstance(new TestReservation('past', $currentSeriesDate->AddDays(-1)));
		$builder->WithInstance($currentInstance);
		$builder->WithInstance($futureInstance);
		$builder->WithCurrentInstance($currentInstance);
		
		$series = $builder->Build();
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$series->Repeats(new RepeatDaily(1, $currentSeriesDate->AddDays(19)->GetBegin()));
		
		$instances = $series->Instances();
		$this->assertEquals(21, count($instances), "1 past, 1 current, 19 future (including existing instance)");
		$this->assertTrue(in_array($currentInstance, $instances), "current should not have been altered");
		$this->assertFalse(in_array($futureInstance, $instances), "existing future should not have been altered");
		
		$events = $series->GetEvents();
		$this->assertEquals(20, count($events), "19 created, 1 deleted");
		$this->assertTrue(in_array(new InstanceRemovedEvent($futureInstance), $events));
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
		$series->Update(9, new FakeBookableResource(10), 'new', 'new', new FakeUserSession());
		$series->Repeats($repeatOptions);
		
		$events = $series->GetEvents();
		
		$this->assertEquals(2, count($series->Instances()));
		$this->assertEquals(0, count($events));
	}
	
	public function testChangingTimeForFullSeriesUpdatesAllInstanceTimes()
	{
		$repeatOptions = new RepeatDaily(1, Date::Now());
		$dateRange = DateRange::Create('2015-01-01 08:30', '2015-01-01 09:30', 'UTC');
		$instance1Date = $dateRange->AddDays(5);
		$instance2Date = $dateRange->AddDays(8);
		
		$instance1 = new TestReservation('123', $instance1Date, 100);
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRepeatOptions($repeatOptions);
		$builder->WithInstance($instance1);
		$builder->WithInstance(new TestReservation('223', $instance2Date, 101));
		$builder->WithCurrentInstance(new TestReservation('1', $dateRange, 102));
		
		$series = $builder->Build();
		$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);
		$newDuration = DateRange::Create('2015-01-01 09:30:00', '2015-01-02 00:00:00', 'UTC');
		$series->UpdateDuration($newDuration);
		
		$this->assertEquals($newDuration, $series->CurrentInstance()->Duration());
		
		$newInstance1Start = Date::Parse('2015-01-06 09:30:00', 'UTC');
		$newInstance1End = Date::Parse('2015-01-07 00:00:00', 'UTC');
		
		$newInstance2Start = Date::Parse('2015-01-09 09:30:00', 'UTC');
		$newInstance2End = Date::Parse('2015-01-10 00:00:00', 'UTC');
		
//		$this->assertEquals(new DateRange($newInstance1Start, $newInstance1End), $series->GetInstance($newInstance1Start)->Duration());
//		$this->assertEquals(new DateRange($newInstance2Start, $newInstance2End), $series->GetInstance($newInstance2Start)->Duration());
		
		$events = $series->GetEvents();
		$this->assertTrue(in_array(new InstanceUpdatedEvent($instance1), $events));
		
	}
	
	public function testUpdateSingleInstanceToAnEarlierTime()
	{
		$now = Date::Now();
		
		$newStart = Date::Parse('2010-01-01 04:00:00', 'UTC');
		$start = Date::Parse('2010-01-01 05:00:00', 'UTC');
		$end = Date::Parse('2010-01-01 07:00:00', 'UTC');
		
		$future1 = new TestReservation('1', new DateRange($now->AddDays(5), $now->AddDays(5)));
		$future2 = new TestReservation('2', new DateRange($now->AddDays(6), $now->AddDays(6)));
		$current = new TestReservation('3', new DateRange($start, $end));
		
		$existing = new ExistingReservationSeries();
		$existing->WithInstance($future1);
		$existing->WithInstance($future2);
		$existing->WithCurrentInstance($current);
		
		$existing->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$existing->UpdateDuration(new DateRange($newStart, $end));
		
		$newCurrent = $existing->CurrentInstance();
		
		$this->assertTrue($newCurrent->StartDate()->Equals($newStart));
		$this->assertTrue($newCurrent->EndDate()->Equals($end));
	}
	
	public function testWhenChangingTimeToFutureInstances()
	{
		$currentSeriesDate = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(2));

		$oldDates = $currentSeriesDate->AddDays(-4);
		$oldReservation = new TestReservation('old', $oldDates, 1);
		
		$currentInstance = new TestReservation('current', $currentSeriesDate, 2);
		
		$futureDates1 = $currentSeriesDate->AddDays(1);
		$futureReservation1 = new TestReservation('new1', $futureDates1, 3);
		
		$futureDates2 = $currentSeriesDate->AddDays(10);
		$futureReservation2 = new TestReservation('new2', $futureDates2, 4);
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($currentInstance);
		$builder->WithInstance($oldReservation);
		$builder->WithInstance($futureReservation1);
		$builder->WithInstance($futureReservation2);
		$series = $builder->Build();
		// updates
		$series->ApplyChangesTo(SeriesUpdateScope::FutureInstances);
		$series->UpdateDuration($currentSeriesDate->AddDays(1));

		//$instances = $series->Instances();

		$events = $series->GetEvents();
		
		//$this->assertEquals(1, count($events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($currentInstance), $events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($futureReservation1), $events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($futureReservation2), $events));
	}

	public function testChangingParticipantsAddsNewRemovesOldAndKeepsOverlap()
	{
		$existingParticipants = array(1, 2, 3, 4);
		$newParticipants = array(1, 5, 4, 6);

		$reservation = new TestReservation();
		$reservation->WithParticipants($existingParticipants);
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($reservation);
		$series = $builder->Build();

		$series->ChangeParticipants($newParticipants);

		$this->assertEquals(2, count($reservation->AddedParticipants()));
		$this->assertEquals(array(5, 6), $reservation->AddedParticipants());
		$this->assertEquals(array(2, 3), $reservation->RemovedParticipants());
		$this->assertEquals(array(1, 4), $reservation->UnchangedParticipants());
	}

	public function testChangingInviteesAddsNewRemovesOldAndKeepsOverlap()
	{
		$existingInvitees = array(1, 2, 3, 4);
		$newInvitees = array(1, 5, 4, 6);

		$reservation = new TestReservation();
		$reservation->WithInvitees($existingInvitees);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($reservation);
		$series = $builder->Build();

		$series->ChangeInvitees($newInvitees);

		$this->assertEquals(2, count($reservation->AddedInvitees()));
		$this->assertEquals(array(5, 6), $reservation->AddedInvitees());
		$this->assertEquals(array(2, 3), $reservation->RemovedInvitees());
		$this->assertEquals(array(1, 4), $reservation->UnchangedInvitees());
	}
	
	public function testDuplicateEventsAreIgnored()
	{
		$reservation = new TestReservation();
		$reservation->WithInvitees(array(1));
		$reservation->SetReservationId(100);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($reservation);
		$series = $builder->Build();

		$series->ChangeInvitees(array(2));
		$series->ChangeInvitees(array(3));

		$events = $series->GetEvents();
		$unique = array_unique($events);
		
		$this->assertEquals(count($unique), count($events));
	}

	public function testAcceptsInvitesForEachInstance()
	{
		$userId = 1;
		
		$r1 = new TestReservation();
		$r1->WithInvitees(array($userId));
		$r1->SetReservationId(100);

		$r2 = new TestReservation();
		$r2->WithInvitees(array($userId));
		$r2->SetReservationId(100);

		$r3 = new TestReservation();
		$r3->WithInvitees(array(10));
		$r3->SetReservationId(100);
		
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($r1);
		$builder->WithInstance($r2);
		$builder->WithInstance($r3);

		$series = $builder->Build();

		$series->AcceptInvitation($userId);

		$events = $series->GetEvents();

		$this->assertContains($userId, $r1->AddedParticipants());
		$this->assertContains($userId, $r1->RemovedInvitees());

		$this->assertContains($userId, $r2->AddedParticipants());
		$this->assertContains($userId, $r2->RemovedInvitees());

		$this->assertTrue(in_array(new InstanceUpdatedEvent($r1), $events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($r2), $events));
		$this->assertFalse(in_array(new InstanceUpdatedEvent($r3), $events));
	}

	public function testDeclinesInvitesForEachInstance()
	{
		$userId = 1;

		$r1 = new TestReservation();
		$r1->WithInvitees(array($userId));
		$r1->SetReservationId(100);

		$r2 = new TestReservation();
		$r2->WithInvitees(array($userId));
		$r2->SetReservationId(100);

		$r3 = new TestReservation();
		$r3->WithInvitees(array(10));
		$r3->SetReservationId(100);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($r1);
		$builder->WithInstance($r2);
		$builder->WithInstance($r3);

		$series = $builder->Build();

		$series->DeclineInvitation($userId);

		$events = $series->GetEvents();

		$this->assertContains($userId, $r1->RemovedInvitees());
		$this->assertContains($userId, $r2->RemovedInvitees());

		$this->assertTrue(in_array(new InstanceUpdatedEvent($r1), $events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($r2), $events));
		$this->assertFalse(in_array(new InstanceUpdatedEvent($r3), $events));
	}

	public function testRemovesParticipationFromCurrentInstance()
	{
		$userId = 1;

		$r1 = new TestReservation();
		$r1->WithParticipant($userId);
		$r1->SetReservationId(100);

		$r2 = new TestReservation();
		$r2->WithParticipant($userId);
		$r2->SetReservationId(100);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($r1);
		$builder->WithInstance($r2);

		$series = $builder->Build();

		$series->CancelInstanceParticipation($userId);

		$events = $series->GetEvents();

		$this->assertContains($userId, $r1->RemovedParticipants());
		$this->assertEmpty($r2->RemovedInvitees());

		$this->assertTrue(in_array(new InstanceUpdatedEvent($r1), $events));
		$this->assertFalse(in_array(new InstanceUpdatedEvent($r2), $events));
	}

	public function testRemovesParticipationFromAllInstances()
	{
		$userId = 1;

		$r1 = new TestReservation();
		$r1->WithParticipant($userId);
		$r1->SetReservationId(100);

		$r2 = new TestReservation();
		$r2->WithParticipant($userId);
		$r2->SetReservationId(101);

		$r3 = new TestReservation();
		$r3->WithParticipant(89);
		$r3->SetReservationId(102);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($r1);
		$builder->WithInstance($r2);
		$builder->WithInstance($r3);

		$series = $builder->Build();

		$series->CancelAllParticipation($userId);

		$events = $series->GetEvents();

		$this->assertContains($userId, $r1->RemovedParticipants());
		$this->assertContains($userId, $r2->RemovedParticipants());
		$this->assertEmpty($r3->RemovedInvitees());

		$this->assertTrue(in_array(new InstanceUpdatedEvent($r1), $events));
		$this->assertTrue(in_array(new InstanceUpdatedEvent($r2), $events));
		$this->assertFalse(in_array(new InstanceUpdatedEvent($r3), $events));
	}

	public function testChangesResources()
	{
		$builder = new ExistingReservationSeriesBuilder();

		$unchanged = new FakeBookableResource(1);
		$added = new FakeBookableResource(2);
		$removed = new FakeBookableResource(3);
		
		$series = $builder->Build();
		$series->WithResource(new FakeBookableResource($unchanged));
		$series->WithResource(new FakeBookableResource($removed));

		$series->ChangeResources(array($unchanged, $added));

		$events = $series->GetEvents();

		$this->assertTrue(in_array(new ResourceRemovedEvent($removed, $series), $events));
		$this->assertTrue(in_array(new ResourceAddedEvent($added, $series), $events));
	}
}
?>