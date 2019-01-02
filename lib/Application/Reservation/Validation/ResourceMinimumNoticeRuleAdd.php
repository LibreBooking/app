<?php

/**
 * Copyright 2011-2019 Nick Korbel
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

class ResourceMinimumNoticeRuleAdd implements IReservationValidationRule
{
    /**
     * @var UserSession
     */
    protected $userSession;

    public function __construct(UserSession $userSession)
    {
        $this->userSession = $userSession;
    }

    /**
     * @see IReservationValidationRule::Validate()
     *
     * @param ReservationSeries $reservationSeries
     * @param null|ReservationRetryParameter[] $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        $r = Resources::GetInstance();

        $resources = $reservationSeries->AllResources();

        foreach ($resources as $resource) {
            if ($this->EnforceMinimumNotice($resource)) {
                $minStartDate = Date::Now()->ApplyDifference($this->GetMinimumNotice($resource)->Interval());

                /* @var $instance Reservation */
                foreach ($this->GetInstances($reservationSeries) as $instance) {
                    if ($this->ViolatesMinStartRule($instance, $minStartDate)) {
                        return new ReservationRuleResult(false, $r->GetString($this->GetErrorKey(), $minStartDate->ToTimezone($this->userSession->Timezone)->Format($r->GeneralDateTimeFormat())));
                    }
                }
            }
        }

        return new ReservationRuleResult();
    }

    /**
     * @param ReservationSeries $reservationSeries
     * @return Reservation[]
     */
    protected function GetInstances($reservationSeries)
    {
        return $reservationSeries->Instances();
    }

    /**
     * @param BookableResource $resource
     * @return bool
     */
    protected function EnforceMinimumNotice($resource)
    {
        return $resource->HasMinNoticeAdd();
    }

    /**
     * @param BookableResource $resource
     * @return TimeInterval
     */
    protected function GetMinimumNotice($resource)
    {
        return $resource->GetMinNoticeAdd();
    }

    /**
     * @return string
     */
    protected function GetErrorKey()
    {
        return 'MinNoticeError';
    }

    /**
     * @param Reservation $instance
     * @param Date $minStartDate
     * @return bool
     */
    protected function ViolatesMinStartRule($instance, $minStartDate)
    {
        return $instance->StartDate()->LessThan($minStartDate);
    }
}