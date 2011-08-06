<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/ExistingReservationSeriesBuilder.php');

class QuotaWhenModifyingTests extends TestBase
{
	var $tz;
	/**
	 * @var IReservationViewRepository
	 */
	var $reservationViewRepository;

	public function setup()
	{
		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->tz = 'America/Chicago';
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenNotChangingExistingTimes()
	{
		$tz = 'UTC';
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $tz);
		$r1End = Date::Parse('2011-04-03 2:30', $tz);

		$r2start = Date::Parse('2011-04-04 1:30', $tz);
		$r2End = Date::Parse('2011-04-04 2:30', $tz);

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

		$exceeds = $quota->ExceedsQuota($series, $this->reservationViewRepository, $this->tz);

		$this->assertFalse($exceeds);
	}

	public function testWhenChangingExistingTimes()
	{
		$tz = 'UTC';
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitHours(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $tz);
		$r1End = Date::Parse('2011-04-03 2:30', $tz);

		$r2start = Date::Parse('2011-04-04 1:30', $tz);
		$r2End = Date::Parse('2011-04-04 2:30', $tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End));
		$existing2 = new TestReservation($ref2, new DateRange($r2start, $r2End));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($existing2);
		$series = $builder->BuildTestVersion();
		
		$series->UpdateDuration(new DateRange($r1start, $r1End->SetTimeString("3:00")));

		$this->SearchReturns(array());

		$exceeds = $quota->ExceedsQuota($series, $this->reservationViewRepository, $this->tz);

		$this->assertTrue($exceeds);
	}
	
	public function testWhenAddingNewReservations()
	{
		$tz = 'UTC';
		$ref1 = 'ref1';
		$ref2 = 'ref2';
		$duration = new QuotaDurationDay();
		$limit = new QuotaLimitCount(1);

		$quota = new Quota(1, $duration, $limit);

		$r1start = Date::Parse('2011-04-03 1:30', $tz);
		$r1End = Date::Parse('2011-04-03 2:30', $tz);

		$r2start = Date::Parse('2011-04-04 1:30', $tz);
		$r2End = Date::Parse('2011-04-04 2:30', $tz);

		$existing1 = new TestReservation($ref1, new DateRange($r1start, $r1End));
		$new = new TestReservation($ref2, new DateRange($r2start, $r2End));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithCurrentInstance($existing1)
				->WithInstance($existing1)
				->WithInstance($new);
		
		$series = $builder->BuildTestVersion();

		$res1 = new ReservationItemView($ref1, $r1start, $r1End, '',  $series->ResourceId());
		$res2 = new ReservationItemView('something else', $r2start, $r2End, '', $series->ResourceId());
		$reservations = array($res1, $res2);

		$this->SearchReturns($reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->reservationViewRepository, $this->tz);

		$this->assertTrue($exceeds);
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