<?php
/**
Copyright 2011-2013 Nick Korbel

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
		
		$this->page->expects($this->atLeastOnce())
				->method('GetDuration')
				->will($this->returnValue($duration));

		$this->page->expects($this->atLeastOnce())
				->method('GetLimit')
				->will($this->returnValue($limit));

		$this->page->expects($this->atLeastOnce())
				->method('GetUnit')
				->will($this->returnValue($unit));

		$this->page->expects($this->atLeastOnce())
				->method('GetResourceId')
				->will($this->returnValue($resourceId));

		$this->page->expects($this->atLeastOnce())
				->method('GetGroupId')
				->will($this->returnValue($groupId));

		$this->page->expects($this->atLeastOnce())
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