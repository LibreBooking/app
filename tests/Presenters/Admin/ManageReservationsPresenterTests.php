<?php
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ManageReservationsPresenterTests extends TestBase
{
	/**
	 * @var ManageReservationsPresenter
	 */
	private $presenter;

	/**
	 * @var IManageReservationsPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	/**
	 * @var IReservationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageReservationsPage');
		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->reservationRepository = $this->getMock('IReservationRepository');

		$this->presenter = new ManageReservationsPresenter($this->page,
											$this->reservationViewRepository,
											$this->scheduleRepository,
											$this->resourceRepository,
											$this->reservationRepository);
	}
	
	public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
	{
		$userTimezone = 'America/Chicago';
		$defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
		$defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();
		$searchedScheduleId = 15;
		$searchedResourceId = 105;
		$searchedUserId = 111;
		$searchedReferenceNumber = 'abc123';
		$searchedUserName = 'some user';

		$this->page->expects($this->atLeastOnce())
				->method('GetStartDate')
				->will($this->returnValue(null));

		$this->page->expects($this->atLeastOnce())
				->method('GetEndDate')
				->will($this->returnValue(null));

		$this->page->expects($this->once())
			->method('GetScheduleId')
			->will($this->returnValue($searchedScheduleId));

		$this->page->expects($this->once())
			->method('GetResourceId')
			->will($this->returnValue($searchedResourceId));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($searchedUserId));

		$this->page->expects($this->once())
			->method('GetUserName')
			->will($this->returnValue($searchedUserName));

		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($searchedReferenceNumber));

		$filter = $this->GetExpectedFilter($defaultStart, $defaultEnd, $searchedReferenceNumber, $searchedScheduleId, $searchedResourceId, $searchedUserId);
		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($this->anything(), $this->anything(), null, null, $filter)
				->will($this->returnValue($data));

		$this->page->expects($this->once())
				->method('SetStartDate')
				->with($this->equalTo($defaultStart));

		$this->page->expects($this->once())
				->method('SetEndDate')
				->with($this->equalTo($defaultEnd));

		$this->page->expects($this->once())
			->method('SetReferenceNumber')
			->with($this->equalTo($searchedReferenceNumber));

		$this->page->expects($this->once())
			->method('SetScheduleId')
			->with($this->equalTo($searchedScheduleId));

		$this->page->expects($this->once())
			->method('SetResourceId')
			->with($this->equalTo($searchedResourceId));

		$this->page->expects($this->once())
			->method('SetUserId')
			->with($this->equalTo($searchedUserId));

		$this->page->expects($this->once())
			->method('SetUserName')
			->with($this->equalTo($searchedUserName));
		
		$this->presenter->PageLoad($userTimezone);
	}

	public function testDeleteRemovesReservation()
	{
		$referenceNumber = '123';
		$scope = SeriesUpdateScope::FullSeries;
		
		$reservation = $this->getMock('ExistingReservationSeries');;
		
		$this->page->expects($this->once())
			->method('GetDeleteReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetDeleteScope')
			->will($this->returnValue($scope));

		$this->reservationRepository->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($reservation));

		$reservation->expects($this->once())
			->method('ApplyChangesTo')
			->with($this->equalTo($scope));
		
		$reservation->expects($this->once())
			->method('Delete')
			->with($this->equalTo($this->fakeUser));
		
		$this->reservationRepository->expects($this->once())
			->method('Delete')
			->with($this->equalTo($reservation))
			->will($this->returnValue($reservation));

		$this->presenter->DeleteReservation($this->fakeUser);
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @return ISqlFilter
	 */
	private function GetExpectedFilter($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null)
	{
		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId);
		return $filter->GetFilter();
	}
}

?>
