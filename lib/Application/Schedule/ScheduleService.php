<?php
/**
 * Copyright 2013-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
Booked SchedulereIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
Booked SchedulerduleIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IScheduleService
{
	/**
	 * @param bool $includeInaccessible
	 * @param UserSession $session
	 * @return Schedule[]
	 */
	public function GetAll($includeInaccessible = true, UserSession $session = null);

	/**
	 * @param int $scheduleId
	 * @param ILayoutFactory $layoutFactory factory to use to create the schedule layout
	 * @return IScheduleLayout
	 */
	public function GetLayout($scheduleId, ILayoutFactory $layoutFactory);
}

class ScheduleService implements IScheduleService
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceService
	 */
	private $resourceService;

	public function __construct(IScheduleRepository $scheduleRepository, IResourceService $resourceService)
	{
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceService = $resourceService;
	}

	public function GetAll($includeInaccessible = true, UserSession $session = null)
	{
		$schedules = $this->scheduleRepository->GetAll();

		if ($includeInaccessible == false)
		{
			$resources = $this->resourceService->GetAllResources($includeInaccessible, $session);
			$availableSchedules = array();

			if (count($resources) > 0)
			{
				foreach ($schedules as $schedule)
				{
					foreach ($resources as $resource)
					{
						if ($resource->ScheduleId == $schedule->GetId())
						{
							$availableSchedules[] = $schedule;
							break;
						}
					}
				}
			}

			return $availableSchedules;
		}
		else
		{
			return $schedules;
		}
	}

	public function GetLayout($scheduleId, ILayoutFactory $layoutFactory)
	{
		return $this->scheduleRepository->GetLayout($scheduleId, $layoutFactory);
	}
}

?>