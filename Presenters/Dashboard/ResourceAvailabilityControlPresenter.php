<?php
/**
 * Copyright 2015 Nick Korbel
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

require_once(ROOT_DIR . 'Controls/Dashboard/ResourceAvailabilityControl.php');

class ResourceAvailabilityControlPresenter
{
	/**
	 * @var IResourceAvailabilityControl
	 */
	private $control;

	/**
	 * @var IResourceService
	 */
	private $resourceService;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IResourceAvailabilityControl $control,
								IResourceService $resourceService,
								IReservationViewRepository $reservationViewRepository)
	{
		$this->control = $control;
		$this->resourceService = $resourceService;
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function PageLoad(UserSession $user)
	{
		$now = Date::Now();

		$resources = $this->resourceService->GetAllResources(false, $user);
		$reservations = $this->GetReservations($this->reservationViewRepository->GetReservationList($now, $now));
		$next = $this->reservationViewRepository->GetNextReservations($now);

		$available = array();
		$unavailable = array();
		$allday = array();

		foreach ($resources as $resource)
		{
			$reservation = $this->GetOngoingReservation($resource, $reservations);

			if ($reservation != null)
			{
				if (!$reservation->EndDate->DateEquals(Date::Now()))
				{
					$allday[] = new UnavailableDashboardItem($resource, $reservation);
				}
				else
				{
					$unavailable[] = new UnavailableDashboardItem($resource, $reservation);
				}
			}
			else
			{
				if (array_key_exists($resource->GetId(), $next))
				{
					$available[] = new AvailableDashboardItem($resource, $next[$resource->GetId()]);
				}
				else
				{
					$available[] = new AvailableDashboardItem($resource);
				}
			}
		}

		$this->control->SetAvailable($available);
		$this->control->SetUnavailable($unavailable);
		$this->control->SetUnavailableAllDay($allday);
	}

	/**
	 * @param ResourceDto $resource
	 * @param ReservationItemView[] $reservations
	 * @return ReservationItemView|null
	 */
	private function GetOngoingReservation($resource, $reservations)
	{
		if (array_key_exists($resource->GetId(), $reservations))
		{
			return $reservations[$resource->GetId()];
		}

		return null;
	}

	/**
	 * @param ReservationItemView[] $reservations
	 * @return ReservationItemView[]
	 */
	private function GetReservations($reservations)
	{
		$indexed = array();
		foreach ($reservations as $reservation)
		{
			$indexed[$reservation->ResourceId] = $reservation;
		}

		return $indexed;
	}
}
