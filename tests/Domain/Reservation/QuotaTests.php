<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/ExistingReservationSeriesBuilder.php');

class QuotaTests extends TestBase
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

	public function testWhenUserHasNoReservationsOnSameDayForSelectedResources()
	{
		$quota = new Quota(1);

		$startDate = Date::Parse('2011-04-03 12:30', $this->tz);
		$endDate = Date::Parse('2011-04-03 1:30', $this->tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);

		$res1 = new ReservationItemView('', $startDate, $endDate, '', 3, 98712);
		$res2 = new ReservationItemView('', $startDate, $endDate, '', 4, 98713);
		$res3 = new ReservationItemView('', $startDate->AddDays(1), $endDate->AddDays(1), '', $series->ResourceId(), 98713);
		$reservations = array($res1, $res2);

		$startSearch = $startDate->GetDate();
		$endSearch = $endDate->AddDays(1)->GetDate();

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);
		
		$exceeds = $quota->ExceedsQuota($series, $this->reservationViewRepository);

		$this->assertFalse($exceeds);
	}

	public function testWhenReservationExistsOnSameDayForSameResource()
	{
		$quota = new Quota(1);
		
		$startDate = Date::Parse('2011-04-03 12:30', $this->tz);
		$endDate = Date::Parse('2011-04-03 1:30', $this->tz);

		$series = $this->GetHourLongReservation($startDate, $endDate);
		
		$res1 = new ReservationItemView('', $startDate->SetTimeString('3:30'), $endDate->SetTimeString('5:00'), '', $series->ResourceId(), 98712);
		$reservations = array($res1);

		$startSearch = $startDate->GetDate();
		$endSearch = $endDate->AddDays(1)->GetDate();

		$this->ShouldSearchBy($startSearch, $endSearch, $series, $reservations);

		$exceeds = $quota->ExceedsQuota($series, $this->reservationViewRepository);

		$this->assertTrue($exceeds);
	}

	private function GetHourLongReservation($startDate, $endDate)
	{
		$userId = 12;
		$resource1 = 13;
		$resource2 = 14;

		$hourLongReservation = new DateRange($startDate, $endDate, $this->tz);

		$series = ReservationSeries::Create($userId, $resource1, 1, null, null, $hourLongReservation, new RepeatNone());
		$series->AddResource($resource2);

		return $series;
	}

	private function ShouldSearchBy($startSearch, $endSearch, $series, $reservations)
	{
		$this->reservationViewRepository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($startSearch), $this->equalTo($endSearch), $this->equalTo($series->UserId()), $this->equalTo(ReservationUserLevel::OWNER))
			->will($this->returnValue($reservations));
	}
}

?>
