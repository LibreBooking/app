<?php

/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ResourceDisplayPresenter extends ActionPresenter
{
	/**
	 * @var IResourceDisplayPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationService;
	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;
	/**
	 * @var IWebAuthentication
	 */
	private $authentication;
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;
	/**
	 * @var IDailyLayoutFactory
	 */
	private $dailyLayoutFactory;

	public function __construct(IResourceDisplayPage $page,
								IResourceRepository $resourceRepository,
								IReservationService $reservationService,
								IAuthorizationService $authorizationService,
								IWebAuthentication $authentication,
								IScheduleRepository $scheduleRepository,
								IDailyLayoutFactory $dailyLayoutFactory)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->reservationService = $reservationService;
		$this->authorizationService = $authorizationService;
		$this->authentication = $authentication;
		$this->scheduleRepository = $scheduleRepository;
		$this->dailyLayoutFactory = $dailyLayoutFactory;

		parent::AddAction('login', 'Login');
		parent::AddAction('activate', 'Activate');

	}

	public function PageLoad()
	{
		$resourceId = $this->page->GetPublicResourceId();
		$loggedIn = ServiceLocator::GetServer()->GetUserSession()->IsLoggedIn();

		if (empty($resourceId) || !$loggedIn)
		{
			$this->page->DisplayLogin();
		}
		if (!empty($resourceId))
		{
			$this->DisplayResource($resourceId);
		}
	}

	public function Login()
	{
		$username = $this->page->GetEmail();
		$password = $this->page->GetPassword();

		$isValid = $this->authentication->Validate($username, $password);

		if ($isValid)
		{
			$this->authentication->Login($username, new WebLoginContext(new LoginData()));
			$user = ServiceLocator::GetServer()->GetUserSession();
			$resourceList = array();
			$resources = $this->resourceRepository->GetResourceList();
			foreach ($resources as $resource)
			{
				if ($this->authorizationService->CanEditForResource($user, $resource))
				{
					$resourceList[] = $resource;
				}
			}

			$this->page->BindResourceList($resourceList);
		}
		else
		{
			$this->page->BindInvalidLogin();
		}
	}

	public function Activate()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
		if ($this->authorizationService->CanEditForResource(ServiceLocator::GetServer()->GetUserSession(), $resource))
		{
			$resource->EnableDisplay();
			$this->resourceRepository->Update($resource);
			$this->page->SetActivatedResourceId($resource->GetPublicId());
		}
	}

	public function DisplayResource($resourcePublicId)
	{
		$resource = $this->resourceRepository->LoadByPublicId($resourcePublicId);

		if (!$resource->GetIsDisplayEnabled())
		{
			$this->page->DisplayNotEnabled();
			return;
		}
		$scheduleId = $resource->GetScheduleId();

		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$timezone = $schedule->GetTimezone();

		$now = Date::Now();
		$today = new DateRange($now->GetDate()->ToUtc(), $now->AddDays(1)->GetDate()->ToUtc());

		$layout = $this->scheduleRepository->GetLayout($scheduleId, new ScheduleLayoutFactory($timezone));
		$reservations = $this->reservationService->GetReservations($today, null, $timezone, $resource->GetResourceId());

		$allReservations = $reservations->Reservations();

		$this->page->SetIsAvailableNow(true);
		foreach ($allReservations as $reservation)
		{
			if ($reservation->CollidesWith($now))
			{
				$this->page->SetIsAvailableNow(false);
				break;
			}
		}
		$this->page->BindResource($resource);
		$dailyLayout = $this->dailyLayoutFactory->Create($reservations, $layout);

		$this->page->DisplayAvailability($dailyLayout, $now->ToTimezone($timezone));
	}
}