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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationMovePage.php');

class ReservationMovePresenter
{
	/**
	 * @var IReservationMovePage
	 */
	private $page;

	/**
	 * @var IUpdateReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var IReservationHandler
	 */
	private $handler;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var UserSession
	 */
	private $userSession;

	public function __construct(
			IReservationMovePage $page,
			IUpdateReservationPersistenceService $persistenceService,
			IReservationHandler $handler,
			IResourceRepository $resourceRepository,
			UserSession $userSession)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
		$this->resourceRepository = $resourceRepository;
		$this->userSession = $userSession;
	}

	public function PageLoad()
	{
		$referenceNumber = $this->page->GetReferenceNumber();
		$existingSeries = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
		$existingSeries->UpdateBookedBy(ServiceLocator::GetServer()->GetUserSession());
		$existingSeries->ApplyChangesTo(SeriesUpdateScope::ThisInstance);

		$currentDuration = $existingSeries->CurrentInstance()->Duration();
		$newStart = Date::Parse($this->page->GetStartDate(), $this->userSession->Timezone);

		$difference = DateDiff::BetweenDates($currentDuration->GetBegin(), $newStart);

		$newDuration = new DateRange($newStart, $currentDuration->GetEnd()->ApplyDifference($difference));
		$existingSeries->UpdateDuration($newDuration);
		$this->AdjustResource($existingSeries);

		$this->handler->Handle($existingSeries, $this->page);
	}

	private function AdjustResource(ExistingReservationSeries $existingSeries)
	{
		$originalResourceId = $this->page->GetOriginalResourceId();
		$resourceId = $this->page->GetResourceId();

		if ($originalResourceId == $resourceId)
		{
			return;
		}

		$additionalResources = $existingSeries->AdditionalResources();
		$allResourceIds = $existingSeries->AllResourceIds();
		$newResource = $existingSeries->Resource();

		if (in_array($resourceId, $allResourceIds))
		{
			$updatedAdditionalResources = array();

			foreach ($additionalResources as $resource)
			{
				if ($resourceId != $resource->GetId())
				{
					$updatedAdditionalResources[] = $resource;
				}
				else
				{
					$newResource = $resource;
				}
			}

			$existingSeries->ChangeResources($updatedAdditionalResources);
		}
		else
		{
			$newResource = $this->resourceRepository->LoadById($resourceId);
		}

		$existingSeries->Update($existingSeries->UserId(), $newResource, $existingSeries->Title(), $existingSeries->Description(), $this->userSession);

	}
}