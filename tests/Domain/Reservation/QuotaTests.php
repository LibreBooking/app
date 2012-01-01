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

class QuotaTests extends TestBase
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

		$this->tz = 'America/Chicago';
		$this->schedule = new Schedule(1, null, null, null, null, $this->tz);

		$this->user = new FakeUser();

		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenUserHasLessThanAllowedReservationsOnSameDayForSelectedResources()
	{
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(2);
		
		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-04-03 1:30', 'UTC');
		$endDate = Date::Parse('2011-04-03 2:30', 'UTC');

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', $startDate, $endDate, '', 3, 98712);
		$res2 = new ReservationItemView('', $startDate, $endDate, '', 4, 98713);
		$res3 = new ReservationItemView('', $startDate->SetTimeString('3:30'), $endDate->SetTimeString('4:30'), '', $series->ResourceId(), 98713);
		// next day in America/Chicago
		$res4 = new ReservationItemView('', $startDate->SetTimeString('6:30'), $endDate->SetTimeString('20:30'), '', $series->ResourceId(), 98713);
		$reservations = array($res1, $res2, $res3, $res4);

		$startSearch = $startDate->ToTimezone($this->tz)->GetDate();
		$endSearch = $endDate->ToTimezone($this->tz)->AddDays(1)->GetDate();

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);
		
		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenTotalLimitIsExceededOnSameDayForSameResource()
	{
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);
				
		$quota = new Quota(1, $duration, $limit);
		
		$startDate = Date::Parse('2011-04-03 1:30', 'UTC');
		$endDate = Date::Parse('2011-04-03 2:30', 'UTC');

		$series = $this->GetHourLongReservation($startDate, $endDate);
		
		$res1 = new ReservationItemView('', $startDate->SetTimeString('3:30'), $endDate->SetTimeString('8:00'), '', $series->ResourceId(), 98712);
		$reservations = array($res1);

		$startSearch = $startDate->ToTimezone($this->tz)->GetDate();
		$endSearch = $endDate->ToTimezone($this->tz)->AddDays(1)->GetDate();

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenHourlyLimitIsNotExceeded()
	{
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitHours(1.5);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-04-03 0:30', 'UTC');
		$endDate = Date::Parse('2011-04-03 1:30', 'UTC');

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', $startDate->SetTimeString('00:00'), $endDate->SetTimeString('00:30'), '', $series->ResourceId(), 98712);
		$reservations = array($res1);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenHourlyLimitIsExceededOnSameDayForSameResource()
	{
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitHours(1.5);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-04-03 0:30', 'UTC');
		$endDate = Date::Parse('2011-04-03 1:30', 'UTC');

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', $startDate->SetTimeString('00:00'), $endDate->SetTimeString('00:31'), '', $series->ResourceId(), 98712);
		$reservations = array($res1);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenTotalLimitIsExceededForWeek()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationWeek();
		$limit = new QuotaLimitCount(2);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-03 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-04 1:30', $tz),  Date::Parse('2011-08-04 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-05 1:30', $tz), Date::Parse('2011-08-05 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$startSearch = Date::Parse('2011-07-24 00:00', $tz);
		$endSearch = Date::Parse('2011-08-07 00:00', $tz);

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenTotalLimitIsNotExceededForWeek()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationWeek();
		$limit = new QuotaLimitCount(3);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-03 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-04 1:30', $tz),  Date::Parse('2011-08-04 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-05 1:30', $tz), Date::Parse('2011-08-05 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$startSearch = Date::Parse('2011-07-24 00:00', $tz);
		$endSearch = Date::Parse('2011-08-07 00:00', $tz);

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}
	
	public function testWhenTotalLimitIsExceededForAReservationLastingMultipleWeeks()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationWeek();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-07 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-08 1:30', $tz),  Date::Parse('2011-08-08 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1);
		
		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenHourLimitIsExceededForMultipleReservationsInOneWeek()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationWeek();
		$limit = new QuotaLimitHours(2);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-31 5:30', $tz);
		$endDate = Date::Parse('2011-07-31 6:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-05 1:30', $tz),  Date::Parse('2011-08-05 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-06 11:00', $tz),  Date::Parse('2011-08-07 0:00', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}
	
	public function testWhenHourLimitIsExceededForReservationLastingMultipleWeeks()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationWeek();
		$limit = new QuotaLimitHours(39);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-07 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$reservations = array();

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenTotalLimitIsNotExceededForMonth()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
		
		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitCount(3);

		$quota = new Quota(1, $duration, $limit);

		// week 07/31/2011 - 08/05/2011
		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-03 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-04 1:30', $tz),  Date::Parse('2011-08-05 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-25 1:30', $tz), Date::Parse('2011-08-28 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$startSearch = Date::Parse('2011-07-01 00:00', $tz);
		$endSearch = Date::Parse('2011-09-01 00:00', $tz);

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenTotalLimitIsExceededForMonth()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);

		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitCount(2);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-08-01 5:30', $tz);
		$endDate = Date::Parse('2011-08-03 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-04 1:30', $tz),  Date::Parse('2011-08-05 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-25 1:30', $tz), Date::Parse('2011-08-28 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenTotalLimitIsExceededForReservationThatSpansMoreThanOneMonth()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
				
		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-07-30 5:30', $tz);
		$endDate = Date::Parse('2011-08-03 5:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-07-01 1:30', $tz),  Date::Parse('2011-07-02 2:30', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenHourLimitIsExceededForReservationWithinAMonth()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);

		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitHours(4);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-08-01 5:30', $tz);
		$endDate = Date::Parse('2011-08-01 6:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-02 1:30', $tz),  Date::Parse('2011-08-02 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-31 21:30', $tz),  Date::Parse('2011-09-01 0:00', $tz), '', $series->ResourceId(), 98712);
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenHourLimitIsExceededForReservationLastingLongerThanOneMonth()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);

		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitHours(4);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-07-31 5:30', $tz);
		$endDate = Date::Parse('2011-08-01 6:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$this->SearchReturns(array());

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenMonthlyHourLimitIsNotExceededForReservation()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);
				
		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitHours(4);

		$quota = new Quota(1, $duration, $limit);

		$startDate = Date::Parse('2011-07-31 21:30', $tz);
		$endDate = Date::Parse('2011-08-01 2:30', $tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', Date::Parse('2011-07-02 2:00', $tz),  Date::Parse('2011-07-02 2:30', $tz), '', $series->ResourceId(), 98712);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-31 23:30', $tz),  Date::Parse('2011-09-01 3:00', $tz), '', $series->ResourceId(), 98712);
		$this->SearchReturns(array($res1, $res2));

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenAggregatedResourceTimesForScheduleAreExceeded()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);

		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitHours(4);

		$scheduleId = 1;
		
		$quota = new Quota(1, $duration, $limit, null, null, $scheduleId);

		$startDate = Date::Parse('2011-08-05 1:30', $tz);
		$endDate = Date::Parse('2011-08-05 2:30', $tz);

		// 2 one hour reservations
		$series = $this->GetHourLongReservation($startDate, $endDate, 1, 2, $scheduleId);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-01 00:00', $tz),  Date::Parse('2011-08-01 2:00', $tz), '', 999, 98712, null, null, null, $scheduleId);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-01 02:00', $tz),  Date::Parse('2011-08-01 3:00', $tz), '', 888, 98712, null, null, null, $scheduleId);
		$this->SearchReturns(array($res1, $res2));

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	public function testWhenAggregatedResourceTimesForScheduleAreNotExceeded()
	{
		$tz = 'UTC';
		$this->schedule->SetTimezone($tz);

		$duration = new QuotaDurationMonth();
		$limit = new QuotaLimitHours(4);

		$scheduleId = 1;

		$quota = new Quota(1, $duration, $limit, null, null, $scheduleId);

		$startDate = Date::Parse('2011-08-05 1:30', $tz);
		$endDate = Date::Parse('2011-08-05 2:30', $tz);

		// 2 one hour reservations
		$series = $this->GetHourLongReservation($startDate, $endDate, 1, 2, $scheduleId);

		$res1 = new ReservationItemView('', Date::Parse('2011-08-01 00:00', $tz),  Date::Parse('2011-08-01 1:00', $tz), '', 999, 98712, null, null, null, $scheduleId);
		$res2 = new ReservationItemView('', Date::Parse('2011-08-01 02:00', $tz),  Date::Parse('2011-08-01 3:00', $tz), '', 888, 98712, null, null, null, $scheduleId);
		$this->SearchReturns(array($res1, $res2));

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testDoesNotCheckWhenNoResourcesApply()
	{
		$resourceId = 100;
		$startDate = Date::Parse('2011-07-31 21:30', $this->tz);
		$endDate = Date::Parse('2011-08-01 2:30', $this->tz);
		
		$quota = new Quota(1, new QuotaDurationDay(), new QuotaLimitCount(0), $resourceId, null, null);

		$series = $this->GetHourLongReservation($startDate, $endDate, 101, 102);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testDoesNotCheckWhenNoGroupsApply()
	{
		$g1 = new UserGroup(1, null);
		$g2 = new UserGroup(2, null);
		$this->user->SetGroups(array($g1,$g2));
		
		$groupId = 4;
		$startDate = Date::Parse('2011-07-31 21:30', $this->tz);
		$endDate = Date::Parse('2011-08-01 2:30', $this->tz);

		$quota = new Quota(1, new QuotaDurationDay(), new QuotaLimitCount(0), null, $groupId, null);

		$series = $this->GetHourLongReservation($startDate, $endDate, 101, 102);

		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testDoesNotCheckWhenNoSchedulesApply()
	{
		$series = $this->GetHourLongReservation(Date::Now(), Date::Now(), 101, 102, 999);
		
		$quota = new Quota(1, new QuotaDurationDay(), new QuotaLimitCount(0), 101, 102, 888);
		$exceeds = $quota->ExceedsQuota($series, $this->user, $this->schedule, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}
	
	private function GetHourLongReservation($startDate, $endDate, $resourceId1 = null, $resourceId2 = null, $scheduleId = null)
	{
		$userId = 12;
		$resource1 = empty($resourceId1) ? 13 : $resourceId1;
		$resource2 = empty($resourceId2) ? 14 : $resourceId2;
		$schedule = empty($scheduleId) ? 1 : $scheduleId;

		$hourLongReservation = new DateRange($startDate, $endDate, $this->tz);

		$resource = new FakeBookableResource($resource1);
		$resource->SetScheduleId($schedule);
		$series = ReservationSeries::Create($userId, $resource, null, null, $hourLongReservation, new RepeatNone(), new FakeUserSession());
		$series->AddResource(new FakeBookableResource($resource2));

		return $series;
	}

	private function ShouldSearchBy($startSearch, $endSearch, $series, $reservations)
	{
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($startSearch), $this->equalTo($endSearch), $this->equalTo($series->UserId()), $this->equalTo(ReservationUserLevel::OWNER))
			->will($this->returnValue($reservations));
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