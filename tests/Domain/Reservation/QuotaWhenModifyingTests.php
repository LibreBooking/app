<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/ExistingReservationSeriesBuilder.php');

class QuotaWhenModifyingTests extends TestBase
{
	/**
	 * @var string
	 */
	var $tz;

	/**
	 * @var Schedule
	 */
	var $schedule;

	/**
	 * @var IReservationViewRepository
	 */
	var $reservationViewRepository;

	/**
	 * @var FakeUser
	 */
	var $user;

	public function setup()
	{
		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->tz = 'UTC';
		$this->schedule = new Schedule(1, null, null, null, null, $this->tz);

		$this->user = new FakeUser();
		
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenNotChangingExistingTimes()
	{
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $this->tz);
		$r1End = Date::Parse('2011-04-03 2:30', $this->tz);

		$r2start = Date::Parse('2011-04-04 1:30', $this->tz);
		$r2End = Date::Parse('2011-04-04 2:30', $this->tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End));
		$existing2 = new TestReservation($ref2, new DateRange($r2start, $r2End));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($existing2);
		$series = $builder->BuildTestVersion();

		$res1 = new ReservationItemView($ref1, $r1start, $r1End, '',  $series->ResourceId());
		$res2 = new ReservationItemView($ref2, $r2start, $r2End, '', $series->ResourceId());
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenChangingExistingTimes()
	{
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitHours(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $this->tz);
		$r1End = Date::Parse('2011-04-03 2:30', $this->tz);

		$r2start = Date::Parse('2011-04-04 1:30', $this->tz);
		$r2End = Date::Parse('2011-04-04 2:30', $this->tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End));
		$existing2 = new TestReservation($ref2, new DateRange($r2start, $r2End));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($existing2);
		$series = $builder->BuildTestVersion();
		
		$series->UpdateDuration(new DateRange($r1start, $r1End->SetTimeString("3:00")));

		$this->SearchReturns(array());

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}
	
	public function testWhenAddingNewReservations()
	{
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $this->tz);
		$r1End = Date::Parse('2011-04-03 2:30',$this->tz);

		$r2start = Date::Parse('2011-04-04 1:30', $this->tz);
		$r2End = Date::Parse('2011-04-04 2:30', $this->tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End));
		$new = new TestReservation($ref2, new DateRange($r2start, $r2End));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($new);
		
		$series = $builder->BuildTestVersion();

		$res1 = new ReservationItemView($ref1, $r1start, $r1End, '',  $series->ResourceId());
		$res2 = new ReservationItemView('something else', $r2start, $r2End, '', $series->ResourceId());
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}
	
	public function testWhenDeletingAnInstanceItDoesNotCount()
	{
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$ref3 = 'ref3';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);
		
		$r1start = Date::Parse('2011-04-03 1:30', $this->tz);
		$r1End = Date::Parse('2011-04-03 2:30',$this->tz);

		$r2start = Date::Parse('2011-04-04 1:30', $this->tz);
		$r2End = Date::Parse('2011-04-04 2:30', $this->tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End), 1);
		$deleted = new TestReservation($ref2, new DateRange($r2start, $r2End), 2);
		$new = new TestReservation($ref3, new DateRange($r2start, $r2End), 3);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($deleted)
				->WithInstance($new);

		$series = $builder->BuildTestVersion();
		$series->RemoveInstance($deleted);

		$res1 = new ReservationItemView($ref1, $r1start, $r1End, '',  $series->ResourceId(), $existing1->ReservationId());
		$res2 = new ReservationItemView($ref2, $r1start, $r1End, '',  $series->ResourceId(), $deleted->ReservationId());
		$res3 = new ReservationItemView($ref3, $r2start, $r2End, '', $series->ResourceId(),  $new->ReservationId());
		$reservations = array($res1, $res2, $res3);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}
	
	private function SearchReturns($reservations)
	{
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->anything(), $this->anything(), $this->anything(), $this->anything())
			->will($this->returnValue($reservations));
	}
}

?>