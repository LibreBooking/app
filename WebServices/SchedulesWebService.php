<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/SchedulesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ScheduleResponse.php');

class SchedulesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IRestServer $server, IScheduleRepository $scheduleRepository)
	{
		$this->server = $server;
		$this->scheduleRepository = $scheduleRepository;
	}

	/**
	 * @name GetAllSchedules
	 * @description Loads all schedules
	 * @response SchedulesResponse
	 * @return void
	 */
	public function GetSchedules()
	{
		$schedules = $this->scheduleRepository->GetAll();

		$this->server->WriteResponse(new SchedulesResponse($this->server, $schedules));
	}

	/**
	 * @name GetSchedule
	 * @description Loads a specific schedule by id
	 * @response ScheduleResponse
	 * @param $scheduleId
	 * @return void
	 */
	public function GetSchedule($scheduleId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);

		if ($schedule != null)
		{
			$layout = $this->scheduleRepository->GetLayout($schedule->GetId(), new ScheduleLayoutFactory($this->server->GetSession()->Timezone));
			$this->server->WriteResponse(new ScheduleResponse($this->server, $schedule, $layout));
		}
		else
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
	}
}

?>