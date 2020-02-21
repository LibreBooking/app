<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Responses/ScheduleItemResponse.php');

class SchedulesResponse extends RestResponse
{
    /**
     * @var ScheduleItemResponse[]
     */
    public $schedules = array();

	/**
	 * @param IRestServer $server
	 * @param array|Schedule[] $schedules
	 */
	public function __construct(IRestServer $server, $schedules)
	{
		foreach ($schedules as $schedule)
		{
			$this->schedules[] = new ScheduleItemResponse($server, $schedule);
		}
	}

	public static function Example()
	{
		return new ExampleSchedulesResponse();
	}
}

class ExampleSchedulesResponse extends SchedulesResponse
{
	public function __construct()
	{
		$this->schedules = array(ScheduleItemResponse::Example());
	}
}
