<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');

class ReservationTests extends TestBase
{
	public function setUp(): void
	{
		parent::setup();
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testCreatingNewSeriesSetsAllSharedDataAndCreatesInstances()
	{
		$userId = 32;
		$resourceId = 10;
		$title = 'Title';
		$description = 'some long decription';
		$tz = 'America/Chicago';

		$userSession = new FakeUserSession();

		$startDateCst = '2010-02-02 12:15';
		$endDateCst = '2010-02-04 17:15';

		$startDateUtc = Date::Parse($startDateCst, $tz)->ToUtc();
		$endDateUtc = Date::Parse($endDateCst, $tz)->ToUtc();

		$dateRange = DateRange::Create($startDateCst, $endDateCst, $tz);
		$repeatedDate = DateRange::Create('2010-01-01', '2010-01-02', 'UTC');

		$repeatOptions = $this->createMock('IRepeatOptions');
		$repeatDates = array($repeatedDate);

		$repeatOptions->expects($this->once())
			->method('GetDates')
			->with($this->equalTo($dateRange->ToTimezone($userSession->Timezone)))
			->will($this->returnValue($repeatDates));

		$resource = new FakeBookableResource($resourceId);
		$series = ReservationSeries::Create(
			$userId,
			$resource,
			$title,
			$description,
			$dateRange,
			$repeatOptions,
			$userSession);

		$this->assertEquals($userId, $series->UserId());
		$this->assertEquals($resource, $series->Resource());
		$this->assertEquals($title, $series->Title());
		$this->assertEquals($description, $series->Description());
		$this->assertTrue($series->IsRecurring());
		$this->assertEquals($repeatOptions, $series->RepeatOptions());

		$instances = array_values($series->Instances());

		$this->assertEquals(count($repeatDates) + 1, count($instances), "should have original plus instances");
		$this->assertTrue($startDateUtc->Equals($instances[0]->StartDate()));
		$this->assertTrue($endDateUtc->Equals($instances[0]->EndDate()));

		$this->assertTrue($repeatedDate->GetBegin()->Equals($instances[1]->StartDate()));
		$this->assertTrue($repeatedDate->GetEnd()->Equals($instances[1]->EndDate()));
	}

	public function testCanGetSpecificInstanceByDate()
	{
		$startDate = Date::Parse('2010-02-02 12:15', 'UTC');
		$endDate = $startDate->AddDays(1);
		$dateRange = new DateRange($startDate, $endDate);

		$repeatOptions = $this->createMock('IRepeatOptions');

		$series = ReservationSeries::Create(1, new FakeBookableResource(1), null, null, $dateRange, $repeatOptions, new FakeUserSession());

		$instance = $series->CurrentInstance();

		$this->assertEquals($startDate, $instance->StartDate());
		$this->assertEquals($endDate, $instance->EndDate());
	}
}