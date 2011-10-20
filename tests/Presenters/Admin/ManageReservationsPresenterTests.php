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
	 * @var IManageReservationsService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationsService;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageReservationsPage');
		$this->reservationsService = $this->getMock('IManageReservationsService');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new ManageReservationsPresenter($this->page,
											$this->reservationsService,
											$this->scheduleRepository,
											$this->resourceRepository);
	}
	
	public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
	{
		$userTimezone = 'America/Chicago';
		$defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
		$defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();
		$searchedScheduleId = 15;
		$searchedResourceId = 105;
		$searchedStatusId = ReservationStatus::Pending;
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
			->method('GetReservationStatusId')
			->will($this->returnValue($searchedStatusId));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($searchedUserId));

		$this->page->expects($this->once())
			->method('GetUserName')
			->will($this->returnValue($searchedUserName));

		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($searchedReferenceNumber));

		$filter = $this->GetExpectedFilter($defaultStart, $defaultEnd, $searchedReferenceNumber, $searchedScheduleId, $searchedResourceId, $searchedUserId, $searchedStatusId);
		$data = new PageableData();
		$this->reservationsService->expects($this->once())
				->method('LoadFiltered')
				->with($this->anything(), $this->anything(), $this->equalTo($filter), $this->equalTo($this->fakeUser))
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
			->method('SetReservationStatusId')
			->with($this->equalTo($searchedStatusId));

		$this->page->expects($this->once())
			->method('SetUserId')
			->with($this->equalTo($searchedUserId));

		$this->page->expects($this->once())
			->method('SetUserName')
			->with($this->equalTo($searchedUserName));
		
		$this->presenter->PageLoad($userTimezone);
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @param int $statusId
	 * @return ReservationFilter
	 */
	private function GetExpectedFilter($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null, $statusId = null)
	{
		return new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $statusId);
	}
}

?>