<?php
/**
Copyright 2012-2019 Nick Korbel

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

class Report_RangeTests extends TestBase
{
	/**
	 * @var Date
	 */
	private $now;

	/**
	 * @var string
	 */
	private $timezone;

	public function setUp(): void
	{
		parent::setup();

		$this->now = Date::Parse('2011-07-20 13:41:22', 'America/Chicago');
		Date::_SetNow($this->now);

		$this->timezone = $this->now->Timezone();
	}

	public function testGetsCurrentMonth()
	{
		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->timezone);

		$this->assertTrue(Date::Parse('2011-07-01', $this->fakeUser->Timezone)->Equals($range->Start()));
		$this->assertTrue(Date::Parse('2011-07-31', $this->fakeUser->Timezone)->Equals($range->End()));
		$this->assertEquals(31, count($range->Dates()));
	}

	public function testGetsCurrentWeek()
	{
		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->timezone);

		$this->assertTrue(Date::Parse('2011-07-17', $this->fakeUser->Timezone)->Equals($range->Start()));
		$this->assertTrue(Date::Parse('2011-07-23', $this->fakeUser->Timezone)->Equals($range->End()));
	}

	public function testGetsToday()
	{
		$range = new Report_Range(Report_Range::TODAY, null, null, $this->timezone);

		$this->assertTrue(Date::Parse('2011-07-20', $this->fakeUser->Timezone)->Equals($range->Start()));
		$this->assertTrue(Date::Parse('2011-07-20', $this->fakeUser->Timezone)->Equals($range->End()));
	}

	public function testDefaultsStartAndEnd()
	{
		$range = new Report_Range(Report_Range::DATE_RANGE, null, null, $this->timezone);

		$this->assertTrue(Date::Min()->Equals($range->Start()));
		$this->assertTrue(Date::Max()->Equals($range->End()));

	}
}