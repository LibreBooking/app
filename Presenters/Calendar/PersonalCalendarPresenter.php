<?php
/**
 * Copyright 2011-2016 Nick Korbel
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
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarCommon.php');

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

    /**
     * @var CalendarCommon
     */
    private $common;

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
		$this->subscriptionService = $subscriptionService;
		$this->userRepository = $userRepository;
		$this->resourceService = $resourceService;
		$this->scheduleRepository = $scheduleRepository;
        $this->common = new CalendarCommon($page, $repository, $scheduleRepository, $resourceService, $calendarFactory);

        $this->AddAction(PersonalCalendarActions::ActionEnableSubscription, 'EnableSubscription');
		$this->AddAction(PersonalCalendarActions::ActionDisableSubscription, 'DisableSubscription');
	}

	/**
	 * @param UserSession $userSession
	 */
	public function PageLoad($userSession)
	{
		$schedules = $this->scheduleRepository->GetAll();
		$showInaccessible = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, new BooleanConverter());
		$resources = $this->resourceService->GetAllResources($showInaccessible, $userSession);

		$selectedScheduleId = $this->page->GetScheduleId();
		$selectedSchedule = $this->common->GetSelectedSchedule($schedules);
		$selectedResourceId = $this->page->GetResourceId();
        $selectedGroupId = $this->page->GetGroupId();

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

		$this->page->SetDisplayDate($this->common->GetStartDate());

		$this->page->BindFilters(new CalendarFilters($schedules, $resources, $selectedScheduleId, $selectedResourceId, $resourceGroups));

		$this->page->SetScheduleId($selectedScheduleId);
		$this->page->SetResourceId($selectedResourceId);

		$this->page->SetFirstDay($selectedSchedule->GetWeekdayStart());

        $this->BindSubscriptionDetails($userSession);
        $this->page->BindCalendarType($this->page->GetCalendarType());
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

    private function BindCalendarEvents()
    {
        $userSession = ServiceLocator::GetServer()->GetUserSession();

        $selectedResourceId = $this->page->GetResourceId();
        $selectedScheduleId = $this->page->GetScheduleId();

        $reservations = $this->reservationRepository->GetReservations($this->common->GetStartDate(), $this->common->GetEndDate()->AddDays(1), $userSession->UserId,
            ReservationUserLevel::ALL, $selectedScheduleId, $selectedResourceId);

        $this->page->BindEvents(CalendarReservation::FromViewList($reservations, $userSession->Timezone, $userSession));
    }

    public function ProcessDataRequest($dataRequest)
    {
        if ($dataRequest == 'events') {
            $this->BindCalendarEvents();
        }
        else
        {
            $this->BindSubscriptionDetails(ServiceLocator::GetServer()->GetUserSession());
            $this->page->RenderSubscriptionDetails();
        }
    }

    /**
     * @param $userSession
     */
    private function BindSubscriptionDetails($userSession)
    {
        $resourceId = $this->page->GetResourceId();
        $scheduleId = $this->page->GetScheduleId();
        $details = $this->subscriptionService->ForUser($userSession->UserId, $resourceId, $scheduleId);
        $this->page->BindSubscription($details);
    }
}