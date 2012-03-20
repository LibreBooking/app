<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarExportPage.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class CalendarSubscriptionPresenter
{
    /**
     * @var \ICalendarExportPage
     */
    private $page;

    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;

    /**
     * @var ICalendarExportValidator
     */
    private $validator;

    /**
     * @var ICalendarSubscriptionService
     */
    private $subscriptionService;

    public function __construct(ICalendarSubscriptionPage $page,
                                IReservationViewRepository $reservationViewRepository,
                                ICalendarExportValidator $validator,
                                ICalendarSubscriptionService $subscriptionService)
    {
        $this->page = $page;
        $this->reservationViewRepository = $reservationViewRepository;
        $this->validator = $validator;
        $this->subscriptionService = $subscriptionService;
    }

    public function PageLoad()
    {
        if (!$this->validator->IsValid())
        {
            return;
        }

        $userId = $this->page->GetUserId();
        $scheduleId = $this->page->GetScheduleId();
        $resourceId = $this->page->GetResourceId();

        $weekAgo = Date::Now()->AddDays(-7);
        $nextYear = Date::Now()->AddDays(365);

        $sid = null;
        $rid = null;
        $uid = null;

        $reservations = array();
        if (!empty($scheduleId))
        {
            $schedule = $this->subscriptionService->GetSchedule($scheduleId);
            $sid = $schedule->GetId();
        }
        if (!empty($resourceId))
        {
            $resource = $this->subscriptionService->GetResource($resourceId);
            $rid = $resource->GetId();
        }
        if (!empty($userId))
        {
            $user = $this->subscriptionService->GetUser($userId);
            $uid = $user->Id();
        }

        $res = $this->reservationViewRepository->GetReservationList($weekAgo, $nextYear, $uid, null, $sid, $rid);

        Log::Debug('Loading calendar subscription for userId %s, scheduleId %s, resourceId %s. Found %s reservations.', $userId, $scheduleId, $resourceId, count($res));

        foreach ($res as $r)
        {
            $reservations[] = new iCalendarReservationView($r);
        }

        $this->page->SetReservations($reservations);
    }
}

?>