<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');


interface IReservationPopupPage
{
	/**
	 * @return string
	 */
	function GetReservationId();

	/**
	 * @param $first string
	 * @param $last string
	 */
	function SetName($first, $last);

	/**
	 * @param $resources ScheduleResource[]
	 */
	function SetResources($resources);

	/**
	 * @param $users ReservationUser[]
	 */
	function SetParticipants($users);

	/**
	 * @param $summary string
	 */
	function SetSummary($summary);

	/**
	 * @param $title string
	 */
	function SetTitle($title);

	/**
	 * @param $startDate Date
	 * @param $endDate Date
	 */
	function SetDates($startDate, $endDate);

	/**
	 * @abstract
	 * @param $accessories ReservationAccessory[]
	 * @return mixed
	 */
	public function SetAccessories($accessories);

	/**
	 * @abstract
	 * @param bool $hideReservationDetails
	 * @return void
	 */
	public function SetHideDetails($hideReservationDetails);

	/**
	 * @abstract
	 * @param bool $hideUserInfo
	 * @return void
	 */
	public function SetHideUser($hideUserInfo);

	/**
	 * @param Attribute[] $attributes
	 */
	public function BindAttributes($attributes);
}

class ReservationPopupPage extends Page implements IReservationPopupPage
{
	/**
	 * @var ReservationPopupPresenter
	 */
	private $_presenter;

	public function __construct()
	{
		parent::__construct();

		$this->_presenter = new ReservationPopupPresenter($this,
														  new ReservationViewRepository(),
														  new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization()),
														  new AttributeRepository());
	}

	public function IsAuthenticated()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS,
														new BooleanConverter()) ||
				parent::IsAuthenticated();
	}

	public function PageLoad()
	{
		if (!$this->IsAuthenticated())
		{
			$this->Set('authorized', false);
		}
		else
		{
			$this->Set('authorized', true);
			$this->_presenter->PageLoad();
		}

		$this->Set('ReservationId', $this->GetReservationId());

		$this->Display('Ajax/respopup.tpl');
	}

	/**
	 * @return string
	 */
	function GetReservationId()
	{
		return $this->GetQuerystring('id');
	}

	function SetName($first, $last)
	{
		$this->Set('fullName', new FullName($first, $last));
	}

	function SetResources($resources)
	{
		$this->Set('resources', $resources);
	}

	function SetParticipants($users)
	{
		$this->Set('participants', $users);
	}

	function SetSummary($summary)
	{
		$this->Set('summary', $summary);
	}

	function SetTitle($title)
	{
		$this->Set('title', $title);
	}

	function SetDates($startDate, $endDate)
	{
		$this->Set('startDate', $startDate);
		$this->Set('endDate', $endDate);
	}

	/**
	 * @param $accessories ReservationAccessory[]
	 * @return mixed
	 */
	public function SetAccessories($accessories)
	{
		$this->Set('accessories', $accessories);
	}

	/**
	 * @param bool $hideReservationDetails
	 * @return void
	 */
	public function SetHideDetails($hideReservationDetails)
	{
		$this->Set('hideDetails', $hideReservationDetails);
	}

	/**
	 * @param bool $hideUserInfo
	 * @return void
	 */
	public function SetHideUser($hideUserInfo)
	{
		$this->Set('hideUserInfo', $hideUserInfo);
	}

	/**
	 * @param Attribute[] $attributes
	 */
	public function BindAttributes($attributes)
	{
		$this->Set('attributes', $attributes);
	}
}


class ReservationPopupPresenter
{
	/**
	 * @var IReservationPopupPage
	 */
	private $_page;

	/*
	 * @var IReservationViewRepository
	 */
	private $_reservationRepository;

	/**
	 * @var IReservationAuthorization
	 */
	private $_reservationAuthorization;

	/**
	 * @var IAttributeRepository
	 */
	private $_attributeRepository;

	public function __construct(IReservationPopupPage $page,
								IReservationViewRepository $reservationRepository,
								IReservationAuthorization $reservationAuthorization,
								IAttributeRepository $attributeRepository)
	{
		$this->_page = $page;
		$this->_reservationRepository = $reservationRepository;
		$this->_reservationAuthorization = $reservationAuthorization;
		$this->_attributeRepository = $attributeRepository;
	}

	public function PageLoad()
	{
		$hideUserInfo = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
																 ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
																 new BooleanConverter());
		$hideReservationDetails = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
																		   ConfigKeys::PRIVACY_HIDE_RESERVATION_DETAILS,
																		   new BooleanConverter());

		$tz = ServiceLocator::GetServer()->GetUserSession()->Timezone;

		$reservation = $this->_reservationRepository->GetReservationForEditing($this->_page->GetReservationId());

		if (!$reservation->IsDisplayable())
		{
			return;
		}

		if ($hideReservationDetails || $hideUserInfo)
		{
			$canViewDetails = $this->_reservationAuthorization->CanViewDetails($reservation,
																			   ServiceLocator::GetServer()->GetUserSession());

			$hideReservationDetails = !$canViewDetails && $hideReservationDetails;
			$hideUserInfo = !$canViewDetails && $hideUserInfo;
		}
		$this->_page->SetHideDetails($hideReservationDetails);
		$this->_page->SetHideUser($hideUserInfo);

		$startDate = $reservation->StartDate->ToTimezone($tz);
		$endDate = $reservation->EndDate->ToTimezone($tz);

		$this->_page->SetName($reservation->OwnerFirstName, $reservation->OwnerLastName);
		$this->_page->SetResources($reservation->Resources);
		$this->_page->SetParticipants($reservation->Participants);
		$this->_page->SetSummary($reservation->Description);
		$this->_page->SetTitle($reservation->Title);
		$this->_page->SetAccessories($reservation->Accessories);

		$this->_page->SetDates($startDate, $endDate);

		$attributes = $this->_attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
		$attributeValues = array();
		foreach ($attributes as $attribute)
		{
			$attributeValues[] = new Attribute($attribute, $reservation->GetAttributeValue($attribute->Id()));
		}

		$this->_page->BindAttributes($attributeValues);
	}
}

?>