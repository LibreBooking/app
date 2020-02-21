<?php
/**
 * Copyright 2014-2020 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Ajax/ReservationAttributesPage.php');

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationAttributesPresenter
{
	/**
	 * @var IReservationAttributesPage
	 */
	private $page;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IReservationAttributesPage $page,
								IAttributeService $attributeService,
								IAuthorizationService $authorizationService,
								IPrivacyFilter $privacyFilter,
								IReservationViewRepository $reservationViewRepository)
	{
		$this->page = $page;
		$this->attributeService = $attributeService;
		$this->authorizationService = $authorizationService;
		$this->privacyFilter = $privacyFilter;
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function PageLoad(UserSession $userSession)
	{
		$hideReservations = !Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter());
		$hideDetails = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_RESERVATION_DETAILS, new BooleanConverter());
		if (($hideReservations || $hideDetails) && !$userSession->IsLoggedIn())
		{
			return;
		}
		$requestedUserId = $this->page->GetRequestedUserId();
		$requestedReferenceNumber = $this->page->GetRequestedReferenceNumber();
		$resourceIds = $this->page->GetRequestedResourceIds();

		$reservationView = new ReservationView();
		$canViewDetails = true;

		if (!empty($requestedReferenceNumber))
		{
			$reservationView = $this->reservationViewRepository->GetReservationForEditing($requestedReferenceNumber);
			$canViewDetails = $this->privacyFilter->CanViewDetails($userSession, $reservationView, $requestedUserId);
		}

		$attributes = array();

		if ($canViewDetails)
		{
			$attributes = $this->attributeService->GetReservationAttributes($userSession, $reservationView, $requestedUserId, $resourceIds);
		}

		$this->page->SetAttributes($attributes);
	}

	/**
	 * @param UserSession $userSession
	 * @param $requestedUserId
	 * @return bool
	 */
	private function CanReserveFor(UserSession $userSession, $requestedUserId)
	{
		return $userSession->UserId == $requestedUserId || $this->authorizationService->CanReserveFor($userSession, $requestedUserId);
	}
}
