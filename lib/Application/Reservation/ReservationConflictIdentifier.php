<?php
/**
 * Copyright 2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IReservationConflictIdentifier {
	/**
	 * @param $reservationSeries ReservationSeries
	 * @return IdentifiedConflict[]
	 */
	public function GetConflicts($reservationSeries);
}

class IdentifiedConflict {
	/**
	 * @var Reservation
	 */
	public $Reservation;
	/**
	 * @var IReservedItemView
	 */
	public $Conflict;

	/**
	 * @param Reservation $reservation
	 * @param IReservedItemView $conflict
	 */
	public function __construct(Reservation $reservation, IReservedItemView $conflict)
	{
		$this->Reservation = $reservation;
		$this->Conflict = $conflict;
	}
}

class ReservationConflictIdentifier implements IReservationConflictIdentifier
{
	/**
	 * @var IResourceAvailabilityStrategy
	 */
	private $strategy;
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IResourceAvailabilityStrategy $strategy, IScheduleRepository $scheduleRepository)
	{
		$this->strategy = $strategy;
		$this->scheduleRepository = $scheduleRepository;
	}

	/**
	 * @param $reservationSeries ReservationSeries
	 * @return IdentifiedConflict[]
	 */
	public function GetConflicts($reservationSeries)
	{
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
		if ($schedule->GetAllowConcurrentReservations())
		{
			return [];
		}

		/** @var IdentifiedConflict[] $conflicts */
		$conflicts = array();

		$reservations = $reservationSeries->Instances();

		$bufferTime = $reservationSeries->MaxBufferTime();

		$keyedResources = array();
		foreach ($reservationSeries->AllResources() as $resource)
		{
			$keyedResources[$resource->GetId()] = $resource;
		}

		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug("Checking for reservation conflicts, reference number %s on %s", $reservation->ReferenceNumber(), $reservation->StartDate());

			$startDate = $reservation->StartDate();
			$endDate = $reservation->EndDate();

			if ($bufferTime != null && !$reservationSeries->BookedBy()->IsAdmin)
			{
				$startDate = $startDate->SubtractInterval($bufferTime);
				$endDate = $endDate->AddInterval($bufferTime);
			}

			$existingItems = $this->strategy->GetItemsBetween($startDate, $endDate, array_keys($keyedResources));

			/** @var IReservedItemView $existingItem */
			foreach ($existingItems as $existingItem)
			{
				if (
						($bufferTime == null || $reservationSeries->BookedBy()->IsAdmin) &&
						($existingItem->GetStartDate()->Equals($reservation->EndDate()) ||
								$existingItem->GetEndDate()->Equals($reservation->StartDate()))
				)
				{
					continue;
				}

				if ($this->IsInConflict($reservation, $reservationSeries, $existingItem, $keyedResources))
				{
					Log::Debug("Reference number %s conflicts with existing %s with id %s on %s",
							   $reservation->ReferenceNumber(), get_class($existingItem), $existingItem->GetId(), $reservation->StartDate());

					$conflicts[] = new IdentifiedConflict($reservation, $existingItem);
				}
			}
		}

		return $conflicts;
	}

	protected function IsInConflict(Reservation $instance, ReservationSeries $series, IReservedItemView $existingItem, $keyedResources)
	{
		if ($existingItem->GetId() == $instance->ReservationId() ||
				$series->IsMarkedForDelete($existingItem->GetId()) ||
				$series->IsMarkedForUpdate($existingItem->GetId())
		)
		{
			return false;
		}

		if (array_key_exists($existingItem->GetResourceId(), $keyedResources))
		{
			return $existingItem->BufferedTimes()->Overlaps($instance->Duration());
		}

		return false;
	}
}