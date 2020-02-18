<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageSchedulesPage.php');

class ManageSchedulesPresenterTests extends TestBase
{
	/**
	 * @var IUpdateSchedulePage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepo;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepo;

	/**
	 * @var IGroupViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $groupRepo;

	/**
	 * @var ManageScheduleService
	 */
	private $service;

	public function setUp(): void
	{
		parent::setup();

		$this->page = $this->createMock('IManageSchedulesPage');
		$this->scheduleRepo = $this->createMock('IScheduleRepository');
		$this->resourceRepo = $this->createMock('IResourceRepository');
		$this->groupRepo = $this->createMock('IGroupViewRepository');

		$this->service = new ManageScheduleService($this->scheduleRepo, $this->resourceRepo);
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testLayoutIsParsedFromPage()
	{
		$scheduleId = 98;
		$timezone = 'America/Chicago';
		$reservableSlots = '00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n';
		$blockedSlots = '00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n';

		$expectedLayout = ScheduleLayout::Parse($timezone, $reservableSlots, $blockedSlots);

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue($scheduleId));

		$this->page->expects($this->once())
				->method('GetLayoutTimezone')
				->will($this->returnValue($timezone));

		$this->page->expects($this->once())
				->method('GetUsingSingleLayout')
				->will($this->returnValue(true));

		$this->page->expects($this->once())
				->method('GetReservableSlots')
				->will($this->returnValue($reservableSlots));

		$this->page->expects($this->once())
				->method('GetBlockedSlots')
				->will($this->returnValue($blockedSlots));

		$this->scheduleRepo->expects($this->once())
				->method('AddScheduleLayout')
				->with($this->equalTo($scheduleId), $this->equalTo($expectedLayout));

		$presenter = new ManageSchedulesPresenter($this->page, $this->service, $this->groupRepo);
		$presenter->ChangeLayout();
	}

	public function testDailyLayoutIsParsedFromPage()
	{
		$scheduleId = 98;
		$timezone = 'America/Chicago';
		$reservableSlots = array();
		$blockedSlots = array();

		for ($i = 0; $i < 7; $i++)
		{
			$reservableSlots[$i] = '00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n';
			$blockedSlots[$i] = '00:00 - 01:00 Label 1 A\n1:00- 2:00\r\n02:00 -3:30\n03:30-12:00\r\n';
		}

		$expectedLayout = ScheduleLayout::ParseDaily($timezone, $reservableSlots, $blockedSlots);

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue($scheduleId));

		$this->page->expects($this->once())
				->method('GetLayoutTimezone')
				->will($this->returnValue($timezone));

		$this->page->expects($this->once())
				->method('GetUsingSingleLayout')
				->will($this->returnValue(false));

		$this->page->expects($this->once())
				->method('GetDailyReservableSlots')
				->will($this->returnValue($reservableSlots));

		$this->page->expects($this->once())
				->method('GetDailyBlockedSlots')
				->will($this->returnValue($blockedSlots));

		$this->scheduleRepo->expects($this->once())
				->method('AddScheduleLayout')
				->with($this->equalTo($scheduleId), $this->equalTo($expectedLayout));

		$presenter = new ManageSchedulesPresenter($this->page, $this->service, $this->groupRepo);
		$presenter->ChangeLayout();
	}

	public function testNewScheduleIsAdded()
	{
		$sourceScheduleId = 198;
		$name = 'new name';
		$startDay = '3';
		$daysVisible = '7';

		$expectedSchedule = new Schedule(null, $name, false, $startDay, $daysVisible);

		$this->page->expects($this->once())
				->method('GetSourceScheduleId')
				->will($this->returnValue($sourceScheduleId));

		$this->page->expects($this->once())
				->method('GetScheduleName')
				->will($this->returnValue($name));

		$this->page->expects($this->once())
				->method('GetStartDay')
				->will($this->returnValue($startDay));

		$this->page->expects($this->once())
				->method('GetDaysVisible')
				->will($this->returnValue($daysVisible));

		$this->scheduleRepo->expects($this->once())
				->method('Add')
				->with($this->equalTo($expectedSchedule), $this->equalTo($sourceScheduleId));

		$presenter = new ManageSchedulesPresenter($this->page, $this->service, $this->groupRepo);
		$presenter->Add();
	}

	public function testDeletesSchedule()
	{
		$scheduleId = 1;
		$targetId = 2;

		$schedule = new Schedule(null, 'name', false, 0, 4);

		$resource1 = new FakeBookableResource(1, 'name1');
		$resource2 = new FakeBookableResource(2, 'name2');
		$resource1->SetScheduleId($targetId);
		$resource2->SetScheduleId($targetId);

		$resources = array($resource1, $resource2);

		$this->page->expects($this->once())
				->method('GetScheduleId')
				->will($this->returnValue($scheduleId));

		$this->page->expects($this->once())
				->method('GetTargetScheduleId')
				->will($this->returnValue($targetId));

		$this->scheduleRepo->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($schedule));

		$this->scheduleRepo->expects($this->once())
				->method('Delete')
				->with($this->equalTo($schedule));

		$this->resourceRepo->expects($this->once())
				->method('GetScheduleResources')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($resources));

		$this->resourceRepo->expects($this->at(1))
				->method('Update')
				->with($this->equalTo($resource1));

		$this->resourceRepo->expects($this->at(2))
				->method('Update')
				->with($this->equalTo($resource2));

		$presenter = new ManageSchedulesPresenter($this->page, $this->service, $this->groupRepo);

		$presenter->Delete();
	}
}

?>