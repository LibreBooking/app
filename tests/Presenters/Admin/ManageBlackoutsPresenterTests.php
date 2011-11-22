<?php
require_once(ROOT_DIR . 'Presenters/Admin/ManageBlackoutsPresenter.php');

class ManageBlackoutsPresenterTests extends TestBase
{
	/**
	 * @var ManageBlackoutsPresenter
	 */
	private $presenter;

	/**
	 * @var IManageBlackoutsPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IManageBlackoutsService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $blackoutsService;

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

		$this->page = $this->getMock('IManageBlackoutsPage');
		$this->blackoutsService = $this->getMock('IManageBlackoutsService');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new ManageBlackoutsPresenter($this->page,
											$this->blackoutsService,
											$this->scheduleRepository,
											$this->resourceRepository);
	}
	
	public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
	{
		$userTimezone = $this->fakeUser->Timezone;
		$defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
		$defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();
		$searchedScheduleId = 15;
		$searchedResourceId = 105;

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

		$filter = $this->GetExpectedFilter($defaultStart, $defaultEnd, $searchedScheduleId, $searchedResourceId);
		$data = new PageableData();
		$this->blackoutsService->expects($this->once())
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
			->method('SetScheduleId')
			->with($this->equalTo($searchedScheduleId));

		$this->page->expects($this->once())
			->method('SetResourceId')
			->with($this->equalTo($searchedResourceId));
		
		$this->presenter->PageLoad($userTimezone);
	}

	public function testAddsNewBlackoutTimeForSingleResource()
	{
		$startDate = '1/1/2011';
		$endDate = '1/2/2011';
		$startTime = '01:30 PM';
		$endTime = '12:15 AM';
		$timezone = $this->fakeUser->Timezone;
		$dr = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
		$title = 'out of service';
		$conflictAction = ReservationConflictResolution::Delete;
		$conflictResolution = ReservationConflictResolution::Create($conflictAction);

		$this->ExpectPageToReturnCommonBlackoutInfo($startDate, $startTime, $endDate, $endTime, $title, $conflictAction);

		$resourceId = 123;
		$this->page->expects($this->once())
			->method('GetBlackoutResourceId')
			->will($this->returnValue($resourceId));

		$this->page->expects($this->once())
			->method('GetApplyBlackoutToAllResources')
			->will($this->returnValue(false));

		$this->blackoutsService->expects($this->once())
			->method('Add')
			->with($this->equalTo($dr), $this->equalTo(array($resourceId)), $this->equalTo($title), $this->equalTo($conflictResolution));
		
		$this->presenter->AddBlackout();
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @return BlackoutFilter
	 */
	private function GetExpectedFilter($startDate = null, $endDate = null, $scheduleId = null, $resourceId = null)
	{
		return new BlackoutFilter($startDate, $endDate, $scheduleId, $resourceId);
	}

	private function ExpectPageToReturnCommonBlackoutInfo($startDate, $startTime, $endDate, $endTime, $title, $conflictAction)
	{
		$this->page->expects($this->once())
			->method('GetBlackoutStartDate')
			->will($this->returnValue($startDate));

		$this->page->expects($this->once())
			->method('GetBlackoutStartTime')
			->will($this->returnValue($startTime));

		$this->page->expects($this->once())
			->method('GetBlackoutEndDate')
			->will($this->returnValue($endDate));

		$this->page->expects($this->once())
			->method('GetBlackoutEndTime')
			->will($this->returnValue($endTime));

		$this->page->expects($this->once())
			->method('GetBlackoutTitle')
			->will($this->returnValue($title));

		$this->page->expects($this->once())
			->method('GetBlackoutConflictAction')
			->will($this->returnValue($conflictAction));
	}
}

?>