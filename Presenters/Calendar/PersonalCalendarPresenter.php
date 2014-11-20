<?php
/**
 * Copyright 2011-2014 Nick Korbel
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
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarFilters.php');

class PersonalCalendarActions
{
	const ActionEnableSubscription = 'enable';
	const ActionDisableSubscription = 'disable';
}

class PersonalCalendarPresenter extends ActionPresenter
{
	/**
	 * @var \IPersonalCalendarPage
	 */
	private $page;

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationRepository;

	/**
	 * @var \ICalendarFactory
	 */
	private $calendarFactory;

	/**
	 * @var ICalendarSubscriptionService
	 */
	private $subscriptionService;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * @var IResourceService
	 */
	private $resourceService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(
			IPersonalCalendarPage $page,
			IReservationViewRepository $repository,
			ICalendarFactory $calendarFactory,
			ICalendarSubscriptionService $subscriptionService,
			IUserRepository $userRepository,
			IResourceService $resourceService,
			IScheduleRepository $scheduleRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->reservationRepository = $repository;
		$this->calendarFactory = $calendarFactory;
		$this->subscriptionService = $subscriptionService;
		$this->userRepository = $userRepository;
		$this->resourceService = $resourceService;
		$this->scheduleRepository = $scheduleRepository;

		$this->AddAction(PersonalCalendarActions::ActionEnableSubscription, 'EnableSubscription');
		$this->AddAction(PersonalCalendarActions::ActionDisableSubscription, 'DisableSubscription');
	}

	/**
	 * @param UserSession $userSession
	 * @param string $timezone
	 */
	public function PageLoad($userSession, $timezone)
	{
		$type = $this->page->GetCalendarType();

		$year = $this->page->GetYear();
		$month = $this->page->GetMonth();
		$day = $this->page->GetDay();

		$defaultDate = Date::Now()->ToTimezone($timezone);

		if (empty($year))
		{
			$year = $defaultDate->Year();
		}
		if (empty($month))
		{
			$month = $defaultDate->Month();
		}
		if (empty($day))
		{
			$day = $defaultDate->Day();
		}


		$schedules = $this->scheduleRepository->GetAll();
		$showInaccessible = Configuration::Instance()
										 ->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, new BooleanConverter());
		$resources = $this->resourceService->GetAllResources($showInaccessible, $userSession);

		$selectedScheduleId = $this->page->GetScheduleId();
		$selectedSchedule = $this->GetDefaultSchedule($schedules);
		$selectedResourceId = $this->page->GetResourceId();

		$resourceGroups = $this->resourceService->GetResourceGroups($selectedScheduleId, $userSession);

		if (!empty($selectedGroupId))
		{
			$tempResources = array();
			$resourceIds = $resourceGroups->GetResourceIds($selectedGroupId);
			$selectedGroup = $resourceGroups->GetGroup($selectedGroupId);
			$this->page->BindSelectedGroup($selectedGroup);

			foreach ($resources as $resource)
			{
				if (in_array($resource->GetId(), $resourceIds))
				{
					$tempResources[] = $resource;
				}
			}

			$resources = $tempResources;
		}

		$calendar = $this->calendarFactory->Create($type, $year, $month, $day, $timezone, $selectedSchedule->GetWeekdayStart());
		$reservations = $this->reservationRepository->GetReservationList($calendar->FirstDay(), $calendar->LastDay()->AddDays(1), $userSession->UserId,
																		 ReservationUserLevel::ALL, $selectedScheduleId, $selectedResourceId);
		$calendar->AddReservations(CalendarReservation::FromViewList($reservations, $timezone, $userSession));
		$this->page->BindCalendar($calendar);

		$this->page->SetDisplayDate($calendar->FirstDay());

		$this->page->BindFilters(new CalendarFilters($schedules, $resources, $selectedScheduleId, $selectedResourceId, $resourceGroups));

		$this->page->SetScheduleId($selectedScheduleId);
		$this->page->SetResourceId($selectedResourceId);

		$this->page->SetFirstDay($selectedSchedule->GetWeekdayStart());

		$details = $this->subscriptionService->ForUser($userSession->UserId);
		$this->page->BindSubscription($details);
	}

	public function EnableSubscription()
	{
		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
		Log::Debug('Enabling calendar subscription for userId: %s', $userId);

		$user = $this->userRepository->LoadById($userId);
		$user->EnableSubscription();
		$this->userRepository->Update($user);
	}

	public function DisableSubscription()
	{
		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
		Log::Debug('Disabling calendar subscription for userId: %s', $userId);

		$user = $this->userRepository->LoadById($userId);
		$user->DisableSubscription();
		$this->userRepository->Update($user);
	}

	/**
	 * @param array|Schedule[] $schedules
	 * @return Schedule
	 */
	private function GetDefaultSchedule($schedules)
	{
		$default = null;
		$scheduleId = $this->page->GetScheduleId();

		/** @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			if (!empty($scheduleId) && $schedule->GetId() == $scheduleId)
			{
				return $schedule;
			}

			if ($schedule->GetIsDefault())
			{
				$default = $schedule;
			}
		}

		return $default;
	}
}