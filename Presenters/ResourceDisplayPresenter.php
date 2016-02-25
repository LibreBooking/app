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
	private $reservationRepository;
	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	public function __construct(IResourceDisplayPage $page,
								IResourceRepository $resourceRepository,
								IReservationViewRepository $reservationRepository,
								IAuthorizationService $authorizationService)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->reservationRepository = $reservationRepository;
		$this->authorizationService = $authorizationService;
	}

	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$resourceId = $this->page->GetResourceId();

		if (!$user->IsLoggedIn() && empty($resourceId))
		{
			$this->page->DisplayLogin();
		}
	}
}