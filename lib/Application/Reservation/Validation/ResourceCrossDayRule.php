<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ResourceCrossDayRule implements IReservationValidationRule
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IScheduleRepository $scheduleRepository)
	{
		$this->scheduleRepository = $scheduleRepository;
	}

	public function Validate($reservationSeries, $retryParameters)
	{
		foreach ($reservationSeries->AllResources() as $resource)
		{
			if (!$resource->GetAllowMultiday())
			{
				$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
				$tz = $schedule->GetTimezone();
				$isSameDay = $reservationSeries->CurrentInstance()->StartDate()->ToTimezone($tz)->DateEquals($reservationSeries->CurrentInstance()->EndDate()->ToTimezone($tz));

				return new ReservationRuleResult($isSameDay, Resources::GetInstance()->GetString('MultiDayRule', $resource->GetName()));
			}
		}

		return new ReservationRuleResult();
	}
}