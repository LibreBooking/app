<?php
/**
Copyright 2012-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface ICalendarExportValidator
{
    /**
     * @abstract
     * @return bool
     */
    function IsValid();
}

class CalendarSubscriptionValidator implements ICalendarExportValidator
{
    /**
     * @var ICalendarSubscriptionPage
     */
    private $page;

    /**
     * @var ICalendarSubscriptionService
     */
    private $subscriptionService;

    public function __construct(ICalendarSubscriptionPage $page, ICalendarSubscriptionService $subscriptionService)
    {
        $this->page = $page;
        $this->subscriptionService = $subscriptionService;
    }

    public function IsValid()
    {
        $key = Configuration::Instance()->GetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY);
        $providedKey = $this->page->GetSubscriptionKey();

        if (empty($key) || $providedKey != $key)
        {
            Log::Debug('Empty or invalid subscription key. Key provided: %s', $providedKey);

            return false;
        }

        $resourceId = $this->page->GetResourceId();
        $scheduleId = $this->page->GetScheduleId();
        $userId = $this->page->GetUserId();

        if (!empty($resourceId))
        {
            return $this->subscriptionService->GetResource($resourceId)->GetIsCalendarSubscriptionAllowed();
        }

        if (!empty($scheduleId))
        {
            return $this->subscriptionService->GetSchedule($scheduleId)->GetIsCalendarSubscriptionAllowed();
        }

        if (!empty($userId))
        {
            return $this->subscriptionService->GetUser($userId)->GetIsCalendarSubscriptionAllowed();
        }

        return true;
    }
}