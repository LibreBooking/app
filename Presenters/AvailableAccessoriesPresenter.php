<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/AccessoryAggregation.php');

class AvailableAccessoriesPresenter
{
	/**
	 * @var IAvailableAccessoriesPage
	 */
	private $page;
	/**
	 * @var IAccessoryRepository
	 */
	private $accessoryRepository;
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;
	/**
	 * @var UserSession
	 */
	private $userSession;

	public function __construct(IAvailableAccessoriesPage $page, IAccessoryRepository $accessoryRepository, IReservationViewRepository $reservationViewRepository, UserSession $userSession)
	{
		$this->page = $page;
		$this->accessoryRepository = $accessoryRepository;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userSession = $userSession;
	}

	public function PageLoad()
	{
		$accessories = $this->accessoryRepository->LoadAll();

		$duration = DateRange::Create($this->page->GetStartDate() . ' ' . $this->page->GetStartTime(), $this->page->GetEndDate() . ' ' . $this->page->GetEndTime(), $this->userSession->Timezone);
		$accessoryReservations = $this->reservationViewRepository->GetAccessoriesWithin($duration);

		$aggregation = new AccessoryAggregation($accessories, $duration);

		foreach ($accessoryReservations as $accessoryReservation)
		{
			if ($this->page->GetReferenceNumber() != $accessoryReservation->GetReferenceNumber())
			{
				$aggregation->Add($accessoryReservation);
			}
		}

		$realAvailability = array();

		foreach ($accessories as $accessory)
		{
			$id = $accessory->GetId();

			$available = $accessory->GetQuantityAvailable();
			if ($available != null)
			{
				$reserved = $aggregation->GetQuantity($id);
				$realAvailability[] = new AccessoryAvailability($id, max(0,$available - $reserved));
			}
			else
			{
				$realAvailability[] = new AccessoryAvailability($id, null);
			}
		}
		$this->page->BindAvailability($realAvailability);
	}
}