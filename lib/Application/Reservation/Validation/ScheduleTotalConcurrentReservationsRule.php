<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');

class ScheduleTotalConcurrentReservationsRule implements IReservationValidationRule
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $reservationRepository;

	/**
	 * @var IScheduleRepository
	 */
	protected $scheduleRepository;
	private $timezone;

	public function __construct(IScheduleRepository $scheduleRepository, IReservationViewRepository $reservationRepository, $timezone)
	{
		$this->reservationRepository = $reservationRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->timezone = $timezone;
	}

	public function Validate($reservationSeries, $retryParameters)
	{
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
		if (!$schedule->EnforceConcurrentReservationMaximum())
		{
			return new ReservationRuleResult();
		}

		$isValid = true;
		$invalidDates = [];
		$totalConcurrentReservations = $schedule->GetTotalConcurrentReservations();

		foreach ($reservationSeries->Instances() as $instance)
		{
			$concurrent = 0;
			if ($reservationSeries->IsMarkedForDelete($instance->ReservationId()))
			{
				continue;
			}

			$reservations = $this->reservationRepository->GetReservations($instance->StartDate(), $instance->EndDate(), null, null,
																		  array($reservationSeries->ScheduleId()));

			foreach ($reservations as $existingItem)
			{
				if ($existingItem->ReferenceNumber == $instance->ReferenceNumber())
				{
					continue;
				}

				if ($existingItem->BufferedTimes()->Overlaps($instance->Duration()))
				{
					$concurrent++;
				}
			}


			if ($concurrent + count($reservationSeries->AllResourceIds()) > $totalConcurrentReservations)
			{
				$isValid = false;
				$invalidDates[] = $instance->StartDate();
			}
		}

		return new ReservationRuleResult($isValid, $this->GetErrorMessage($invalidDates, $totalConcurrentReservations));

	}

	/**
	 * @param $invalidDates Date[]
	 * @param $totalConcurrentReservationLimit int
	 * @return string;
	 */
	private function GetErrorMessage($invalidDates, $totalConcurrentReservationLimit)
	{
		$uniqueDates = array_unique($invalidDates);
		sort($uniqueDates);
		$resources = Resources::GetInstance();
		$format = $resources->GetDateFormat(ResourceKeys::DATE_GENERAL);
		$formatted = [];
		foreach($uniqueDates as $d) {
			$formatted[] = $d->ToTimezone($this->timezone)->Format($format);
		}

		$datesAsString = implode(",", $formatted);

		$errorString = new StringBuilder();
		$errorString->AppendLine(Resources::GetInstance()->GetString('ScheduleTotalReservationsError', array($totalConcurrentReservationLimit)));
		$errorString->Append($datesAsString);
		return $errorString->ToString();
	}
}