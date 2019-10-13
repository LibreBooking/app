<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class DisplaySlotFactory
{
    public function GetFunction(IReservationSlot $slot, $accessAllowed = false, $functionSuffix = '')
    {
        if ($slot->IsReserved()) {
            if ($this->IsMyReservation($slot)) {
                return "displayMyReserved$functionSuffix";
            }
            elseif ($this->AmIParticipating($slot)) {
                return "displayMyParticipating$functionSuffix";
            }
			elseif ($this->IsAdminFor($slot))
            {
                return "displayAdminReserved$functionSuffix";
            }
            else {

                return "displayReserved$functionSuffix";
            }
        }
        else {
            if (!$accessAllowed) {
                return "displayRestricted$functionSuffix";
            }
            else {
                if ($slot->IsPastDate(Date::Now()) && !$this->UserHasAdminRights()) {
                    return "displayPastTime$functionSuffix";
                }
                else {
                    if ($slot->IsReservable()) {
                        return "displayReservable$functionSuffix";
                    }
                    else {
                        return "displayUnreservable$functionSuffix";
                    }
                }
            }
        }

        return null;
    }

    private function UserHasAdminRights()
    {
        return ServiceLocator::GetServer()->GetUserSession()->IsAdmin;
    }

    private function IsMyReservation(IReservationSlot $slot)
    {
        $mySession = ServiceLocator::GetServer()->GetUserSession();
        return $slot->IsOwnedBy($mySession);
    }

    private function IsAdminFor(IReservationSlot $slot)
    {
        $mySession = ServiceLocator::GetServer()->GetUserSession();
        return $mySession->IsAdmin || $mySession->IsAdminForGroup($slot->OwnerGroupIds());
    }

    private function AmIParticipating(IReservationSlot $slot)
    {
        $mySession = ServiceLocator::GetServer()->GetUserSession();
        return $slot->IsParticipating($mySession);
    }

    /**
     * @param SchedulePeriod[] $periods
     * @param Date $start
     * @param Date $end
     * @return string
     */
    public function GetCondensedPeriodLabel($periods, $start, $end) {
        foreach($periods as $period) {
            if ($period->IsLabelled()) {
                if ($period->BeginDate()->Equals($start)) {
                    return $period->Label() . ' - ' . $period->LabelEnd();
                }
            }
        }
        $format = Resources::GetInstance()->GetDateFormat('period_time');
        return $start->Format($format) . ' - ' . $end->Format($format);
    }
}