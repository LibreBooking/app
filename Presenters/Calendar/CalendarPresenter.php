<?php
/**
Copyright 2011-2017 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarFilters.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarCommon.php');

class CalendarPresenter extends CommonCalendarPresenter
{
    /**
     * @param UserSession $userSession
     * @param int $selectedScheduleId
     * @param int $selectedResourceId
     * @return ReservationItemView[]
     */
    protected function BindEvents($userSession, $selectedScheduleId, $selectedResourceId)
    {
        $resources = $this->GetAllResources($userSession);

        $reservations = $this->reservationRepository->GetReservations(
            $this->GetStartDate(),
            $this->GetEndDate()->AddDays(1),
            null,
            null,
            $selectedScheduleId,
            $selectedResourceId);

        $this->page->BindEvents(CalendarReservation::FromScheduleReservationList(
            $reservations,
            $resources,
            $userSession,
            $this->privacyFilter));
    }

    protected function BindSubscriptionDetails($userSession, $selectedResourceId, $selectedScheduleId)
    {
        if (!empty($selectedResourceId)) {
            $subscriptionDetails = $this->subscriptionService->ForResource($selectedResourceId);
        }
        else {
            if (!empty($selectedScheduleId)) {
                $subscriptionDetails = $this->subscriptionService->ForSchedule($selectedScheduleId);
            }
            else {
                $subscriptionDetails = new CalendarSubscriptionDetails(false);
            }
        }
        $this->page->BindSubscription($subscriptionDetails);
    }
}

