<?php
/**
Copyright 2012-2014 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class SchedulePeriodRuleTests extends TestBase
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IScheduleLayout
	 */
	private $layout;

	/**
	 * @var SchedulePeriodRule
	 */
	private $rule;

	public function setup()
	{
		parent::setup();

		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->layout = $this->getMock('IScheduleLayout');

		$this->rule = new SchedulePeriodRule($this->scheduleRepository, $this->fakeUser);
	}

	public function testFailsWhenStartTimeDoesNotMatchPeriod()
	{
		$date = Date::Now();
		$dates = new DateRange($date, $date);
		$scheduleId = 1232;
		$resource = new FakeBookableResource(1);
		$resource->SetScheduleId($scheduleId);

		$series = ReservationSeries::Create(1, $resource, null, null, $dates, new RepeatNone(), $this->fakeUser);

		$this->scheduleRepository
				->expects($this->once())
				->method('GetLayout')
				->with($this->equalTo($scheduleId),
					   $this->equalTo(new ScheduleLayoutFactory($this->fakeUser->Timezone)))
				->will($this->returnValue($this->layout));

		$this->layout
				->expects($this->at(0))
				->method('GetPeriod')
				->with($this->equalTo($series->CurrentInstance()->StartDate()))
				->will($this->returnValue(new SchedulePeriod($date, $date->AddMinutes(1))));

		$result = $this->rule->Validate($series);

		$this->assertFalse($result->IsValid());
	}

	public function testFailsWhenEndTimeDoesNotMatchPeriod()
	{
		$date = Date::Now();
		$dates = new DateRange($date, $date);
		$scheduleId = 1232;
		$resource = new FakeBookableResource(1);
		$resource->SetScheduleId($scheduleId);

		$series = ReservationSeries::Create(1, $resource, null, null, $dates, new RepeatNone(), $this->fakeUser);

		$this->scheduleRepository
				->expects($this->once())
				->method('GetLayout')
				->with($this->equalTo($scheduleId),
					   $this->equalTo(new ScheduleLayoutFactory($this->fakeUser->Timezone)))
				->will($this->returnValue($this->layout));

		$this->layout
				->expects($this->at(0))
				->method('GetPeriod')
				->with($this->equalTo($series->CurrentInstance()->StartDate()))
				->will($this->returnValue(new SchedulePeriod($date, $date)));

		$this->layout
				->expects($this->at(1))
				->method('GetPeriod')
				->with($this->equalTo($series->CurrentInstance()->EndDate()))
				->will($this->returnValue(new SchedulePeriod($date->AddMinutes(1), $date)));

		$result = $this->rule->Validate($series);

		$this->assertFalse($result->IsValid());
	}

	public function testSucceedsWhenStartAndEndTimeMatchPeriods()
	{
		$date = Date::Now();
		$dates = new DateRange($date, $date);
		$scheduleId = 1232;
		$resource = new FakeBookableResource(1);
		$resource->SetScheduleId($scheduleId);

		$series = ReservationSeries::Create(1, $resource, null, null, $dates, new RepeatNone(), $this->fakeUser);

		$this->scheduleRepository
				->expects($this->once())
				->method('GetLayout')
				->with($this->equalTo($scheduleId),
					   $this->equalTo(new ScheduleLayoutFactory($this->fakeUser->Timezone)))
				->will($this->returnValue($this->layout));

		$period = new SchedulePeriod($date, $date);
		$this->layout
				->expects($this->at(0))
				->method('GetPeriod')
				->with($this->equalTo($series->CurrentInstance()->StartDate()))
				->will($this->returnValue($period));

		$this->layout
				->expects($this->at(1))
				->method('GetPeriod')
				->with($this->equalTo($series->CurrentInstance()->EndDate()))
				->will($this->returnValue($period));

		$result = $this->rule->Validate($series);

		$this->assertTrue($result->IsValid());
	}
}

?>