<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/SchedulesWebService.php');

class SchedulesWebServiceTests extends TestBase
{
	/**
	 * @var SchedulesWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->scheduleRepository = $this->getMock('IScheduleRepository');

		$this->service = new SchedulesWebService($this->server, $this->scheduleRepository);
	}

	public function testGetsAllSchedules()
	{
		$schedules = array(new FakeSchedule());

		$this->scheduleRepository->expects($this->once())
				->method('GetAll')
				->will($this->returnValue($schedules));

		$this->service->GetSchedules();

		$expectedResponse = new SchedulesResponse($this->server, $schedules);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testGetsScheduleById()
	{
		$scheduleId = 89181;

		$schedule = new FakeSchedule($scheduleId);
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($schedule));

		$this->scheduleRepository->expects($this->once())
				->method('GetLayout')
				->with($this->equalTo($scheduleId), $this->equalTo(new ScheduleLayoutFactory('UTC')))
				->will($this->returnValue($layout));

		$this->service->GetSchedule($scheduleId);

		$expectedResponse = new ScheduleResponse($schedule, $layout);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testWhenScheduleNotFound()
	{
		$scheduleId = 89181;
		$this->scheduleRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue(null));

		$this->service->GetSchedule($scheduleId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
	}
}

?>