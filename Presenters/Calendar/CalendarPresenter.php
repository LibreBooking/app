<?php
/**
 * Copyright 2011-2019 Nick Korbel
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

        $dateRange = new DateRange($this->GetStartDate(), $this->GetEndDate()->AddDays(1));
        $blackouts = $this->reservationRepository->GetBlackoutsWithin(
            $dateRange,
            $selectedScheduleId,
            $selectedResourceId);

        $availableSlots = array();
        if (!empty($selectedResourceId) || !empty($selectedScheduleId)) {

            if (!empty($selectedResourceId)) {
                $resources = [$this->resourceService->GetResource($selectedResourceId)];
                $selectedScheduleId = $resources[0]->GetScheduleId();
            }

            $scheduleLayout = $this->scheduleRepository->GetLayout($selectedScheduleId, new ScheduleLayoutFactory());
            if ($scheduleLayout->UsesCustomLayout()) {
                foreach ($dateRange->Dates() as $date) {
                    $slots = $scheduleLayout->GetLayout($date, true);
                    foreach ($slots as $slot) {
                        if (!$slot->EndDate()->LessThanOrEqual(Date::Now()) && !$this->OverlapsAnyReservation($slot, $reservations) && !$this->OverlapsAnyBlackout($slot, $blackouts)) {
                            $availableSlots[] = new ReservableCalendarSlot($slot, $selectedResourceId, $selectedScheduleId);
                        }
                    }
                }
            }
        }

        $this->page->BindEvents(CalendarReservation::FromScheduleReservationList(
            $reservations,
            $blackouts,
            $availableSlots,
            $resources,
            $userSession,
            $this->privacyFilter,
            $this->slotLabelFactory));
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

    /**
     * @param SchedulePeriod $slot
     * @param ReservationItemView[] $reservations
     * @return bool
     */
    private function OverlapsAnyReservation($slot, $reservations)
    {
        foreach ($reservations as $reservation) {
            if ($reservation->Date->Overlaps(new DateRange($slot->BeginDate(), $slot->EndDate()))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param SchedulePeriod $slot
     * @param BlackoutItemView[] $blackouts
     * @return bool
     */
    private function OverlapsAnyBlackout($slot, $blackouts)
    {
        foreach ($blackouts as $blackout) {
            if ($blackout->Date->Overlaps(new DateRange($slot->BeginDate(), $slot->EndDate()))) {
                return true;
            }
        }
        return false;
    }
}

