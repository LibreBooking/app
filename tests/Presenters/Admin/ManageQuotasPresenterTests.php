<?php
require_once(ROOT_DIR . 'Pages/Admin/ManageQuotasPage.php');

class ManageQuotasPresenterTests extends TestBase
{
	/**
	 * @var IManageQuotasPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var ManageQuotasPresenter
	 */
	private $presenter;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $resourceRepository;

	/**
	 * @var IGroupViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $groupRepository;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $scheduleRepository;

	/**
	 * @var QuotaRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $quotaRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageQuotasPage');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->groupRepository = $this->getMock('IGroupViewRepository');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->quotaRepository = $this->getMock('QuotaRepository');

		$this->presenter = new ManageQuotasPresenter(
			$this->page,
			$this->resourceRepository,
			$this->groupRepository,
			$this->scheduleRepository,
			$this->quotaRepository);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenInitializing()
	{
		$groups = array();
		$bookableResources = array();
		$schedules = array();

		$groupResult = new PageableData($groups);

		$quotaList = array();
		
		$this->resourceRepository->expects($this->once())
			->method('GetResourceList')
			->will($this->returnValue($bookableResources));

		$this->page->expects($this->once())
			->method('BindResources')
			->with($this->equalTo($bookableResources));

		$this->groupRepository->expects($this->once())
			->method('GetList')
			->will($this->returnValue($groupResult));

		$this->page->expects($this->once())
			->method('BindGroups')
			->with($this->equalTo($groups));

		$this->scheduleRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($schedules));

		$this->page->expects($this->once())
			->method('BindSchedules')
			->with($this->equalTo($schedules));

		$this->quotaRepository->expects($this->once())
			->method('GetAll')
			->will($this->returnValue($quotaList));

		$this->presenter->PageLoad();
	}

	public function testWhenAdding()
	{
		$duration = QuotaDuration::Day;
		$limit = 2;
		$unit = QuotaUnit::Hours;
		$resourceId = 987;
		$groupId = 8287;
		$scheduleId = 400;
		
		$this->page->expects($this->once())
				->method('GetDuration')
				->will($this->returnValue($duration));

		$this->page->expects($this->once())
				->method('GetLimit')
				->will($this->returnValue($limit));

		$this->page->expects($this->once())
				->method('GetUnit')
				->will($this->returnValue($unit));

		$this->page->expects($this->once())
				->method('GetResourceId')
				->will($this->returnValue($resourceId));

		$this->page->expects($this->once())
				->method('GetGroupId')
				->will($this->returnValue($groupId));

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue($scheduleId));
		
		$expectedQuota = Quota::Create($duration, $limit, $unit, $resourceId, $groupId, $scheduleId);

		$this->quotaRepository->expects($this->once())
			->method('Add')
			->with($this->equalTo($expectedQuota));

		$this->presenter->AddQuota();
	}
}

?>