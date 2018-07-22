<?php
/**
 * Copyright 2018 Nick Korbel
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
    /**
     * @var IAuthorizationService
     */
    private $authorizationService;

    public function __construct(IAuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function GetFunction(IReservationSlot $slot, $accessAllowed = false, $functionSuffix = '')
    {
        if ($slot->IsReserved()) {
            if ($this->IsMyReservation($slot)) {
                return "displayMyReserved$functionSuffix";
            }
            elseif ($this->IsAdminFor($slot))
            {
                return "displayAdminReserved$functionSuffix";
            }
            elseif ($this->AmIParticipating($slot)) {
                return "displayMyParticipating$functionSuffix";
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
        return $this->authorizationService->CanReserveFor($mySession, $slot->OwnerId());
    }

    private function AmIParticipating(IReservationSlot $slot)
    {
        $mySession = ServiceLocator::GetServer()->GetUserSession();
        return $slot->IsParticipating($mySession);
    }
}