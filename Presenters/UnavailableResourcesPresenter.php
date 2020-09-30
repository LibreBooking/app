<?php
/**
 * Copyright 2017-2020 Nick Korbel
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
require_once(ROOT_DIR . 'Presenters/UnavailableResourcesPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class UnavailableResourcesPresenter
{
    /**
     * @var IAvailableResourcesPage
     */
    private $page;
    /**
     * @var IReservationConflictIdentifier
     */
    private $reservationConflictIdentifier;
    /**
     * @var UserSession
     */
    private $userSession;
    /**
     * @var IResourceRepository
     */
    private $resourceRepository;
    /**
     * @var IReservationRepository
     */
    private $reservationRepository;

    public function __construct(IAvailableResourcesPage $page,
                                IReservationConflictIdentifier $reservationConflictIdentifier,
                                UserSession $userSession,
                                IResourceRepository $resourceRepository,
                                IReservationRepository $reservationRepository)
    {
        $this->page = $page;
        $this->reservationConflictIdentifier = $reservationConflictIdentifier;
        $this->userSession = $userSession;
        $this->resourceRepository = $resourceRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function PageLoad()
    {
        $duration = DateRange::Create($this->page->GetStartDate() . ' ' . $this->page->GetStartTime(),
            $this->page->GetEndDate() . ' ' . $this->page->GetEndTime(), $this->userSession->Timezone);

        $resources = $this->resourceRepository->GetScheduleResources($this->page->GetScheduleId());

        $unavailable = array();
        $referenceNumber = $this->page->GetReferenceNumber();
        $series = null;
        $existingSeries = false;
        if (!empty($referenceNumber)) {
            $series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);
            $series->UpdateDuration($duration);
            $existingSeries = true;
        }

        foreach ($resources as $resource) {

            if (!$existingSeries) {
                $series = ReservationSeries::Create($this->userSession->UserId, $resource, "", "", $duration, new RepeatNone(), $this->userSession);
            }
            $conflict = $this->reservationConflictIdentifier->GetConflicts($series);

            if (!$conflict->AllowReservation()) {
                $unavailable[] = $resource->GetId();
            }
        }

        $this->page->BindUnavailable(array_unique($unavailable));
    }
}