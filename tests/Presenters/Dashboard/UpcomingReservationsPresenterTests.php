<?php

require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');

class UpcomingReservationsPresenterTests extends TestBase
{
	/**
	 * @var UpcomingReservationsPresenter
	 */
	private $presenter;

	/**
	 * @var IUpcomingReservationsControl
	 */
	private $control;

	/**
	 * @var IReservationViewRepository
	 */
	private $repository;

	public function setUp(): void
	{
		parent::setup();

		$this->control = $this->createMock('IUpcomingReservationsControl');
		$this->repository = $this->createMock('IReservationViewRepository');
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testGetsUpToTwoWeeksWorthOfReservationsThatCurrentUserScheduled()
	{
		$now = Date::Parse('2011-03-24', 'UTC'); // thursday
		Date::_SetNow($now);

		$startDate = $now;
		$endDate = Date::Parse('2011-04-02', 'UTC');
		$userId = $this->fakeUser->UserId;
		$timezone = $this->fakeUser->Timezone;

		$reservations = array();


		$this->repository->expects($this->once())
			->method('GetReservations')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($userId), $this->equalTo(ReservationUserLevel::ALL))
			->will($this->returnValue($reservations));

		$this->control->expects($this->once())
			->method('SetTimezone')
			->with($this->equalTo($timezone));

		$this->control->expects($this->once())
			->method('BindToday')
			->with($this->anything());

		$this->control->expects($this->once())
			->method('BindTomorrow')
			->with($this->anything());

		$this->control->expects($this->once())
			->method('BindThisWeek')
			->with($this->anything());

		$this->control->expects($this->once())
			->method('BindNextWeek')
			->with($this->anything());

		$presenter = new UpcomingReservationsPresenter($this->control, $this->repository);
		$presenter->SetSearchCriteria($userId, ReservationUserLevel::ALL);

		$presenter->PageLoad();
	}

	public function testGroupsReservations()
	{
		$this->fakeUser->Timezone = 'UTC';
		$now = Date::Parse('2016-04-28'); // thursday
		Date::_SetNow($now);

		$today = new ReservationItemView('1', $now, $now);
		$tomorrow = new ReservationItemView('2', $now->AddDays(1), $now->AddDays(1));  // friday
		$thisWeek = new ReservationItemView('3', $now->AddDays(2), $now->AddDays(2));  // saturday
		$nextWeek = new ReservationItemView('4', $now->AddDays(3), $now->AddDays(3));  // sunday of next week

		$reservations[] = $today;
		$reservations[] = $tomorrow;
		$reservations[] = $thisWeek;
		$reservations[] = $nextWeek;

		$this->repository->expects($this->once())
			->method('GetReservations')
			->with($this->anything(), $this->anything(), $this->anything())
			->will($this->returnValue($reservations));

		$this->control->expects($this->once())
			->method('BindToday')
			->with($this->equalTo(array($today)));

		$this->control->expects($this->once())
			->method('BindTomorrow')
			->with($this->equalTo(array($tomorrow)));

		$this->control->expects($this->once())
			->method('BindThisWeek')
			->with($this->equalTo(array($thisWeek)));

		$this->control->expects($this->once())
			->method('BindNextWeek')
			->with($this->equalTo(array($nextWeek)));

		$presenter = new UpcomingReservationsPresenter($this->control, $this->repository);
		$presenter->PageLoad();
	}
}
