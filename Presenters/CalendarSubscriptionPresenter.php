<?php
/**
 * Copyright 2012-2015 Nick Korbel
 * Copyright 2012-2014 Alois Schloegl
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
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class CalendarSubscriptionPresenter
{
	/**
	 * @var ICalendarExportPage
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

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	public function __construct(ICalendarSubscriptionPage $page,
								IReservationViewRepository $reservationViewRepository,
								ICalendarExportValidator $validator,
								ICalendarSubscriptionService $subscriptionService,
								IPrivacyFilter $filter)
	{
		$this->page = $page;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->validator = $validator;
		$this->subscriptionService = $subscriptionService;
		$this->privacyFilter = $filter;
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
		$accessoryIds = $this->page->GetAccessoryIds();
		$resourceGroupId = $this->page->GetResourceGroupId();

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$sid = null;
		$rid = null;
		$uid = null;
		$aid = null;
		$resourceIds = array();

		$reservations = array();
		$res = array();

		$summaryFormat = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_LABELS, ConfigKeys::RESERVATION_LABELS_ICS_SUMMARY);

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
		if (!empty($accessoryIds))
		{
			## No transformation is implemented. It is assumed the accessoryIds is provided as AccessoryName
			## filter is defined by LIKE "PATTERN%"
			$aid = $accessoryIds;
		}
		if (!empty($userId))
		{
			$user = $this->subscriptionService->GetUser($userId);
			$uid = $user->Id();
			$summaryFormat = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_LABELS, ConfigKeys::RESERVATION_LABELS_MY_ICS_SUMMARY);
		}
		if (!empty($resourceGroupId))
		{
			$resourceIds = $this->subscriptionService->GetResourcesInGroup($resourceGroupId);
		}

		if (!empty($uid) || !empty($sid) || !empty($rid) || !empty($resourceIds))
		{
			$res = $this->reservationViewRepository->GetReservationList($weekAgo, $nextYear, $uid, null, $sid, $rid);
		}
		elseif (!empty($aid))
		{
			throw new Exception('need to give an accessory a public id, allow subscriptions');
			$res = $this->reservationViewRepository->GetAccessoryReservationList($weekAgo, $nextYear, $accessoryIds);
		}

		Log::Debug('Loading calendar subscription for userId %s, scheduleId %s, resourceId %s. Found %s reservations.',
				   $userId, $scheduleId, $resourceId, count($res));

		$session = ServiceLocator::GetServer()->GetUserSession();

		foreach ($res as $r)
		{
			if (empty($resourceIds) || in_array($r->ResourceId, $resourceIds))
			{
				$reservations[] = new iCalendarReservationView($r,
															   $session,
															   $this->privacyFilter,
															   $summaryFormat);
			}
		}

		$this->page->SetReservations($reservations);
	}
}