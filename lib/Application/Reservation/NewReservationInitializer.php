<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class NewReservationInitializer extends ReservationInitializerBase
{
	/**
	 * @var INewReservationPage
	 */
	private $page;

	public function __construct(
		INewReservationPage $page,
		IReservationComponentBinder $userBinder,
		IReservationComponentBinder $dateBinder,
		IReservationComponentBinder $resourceBinder,
		UserSession $userSession
		)
	{
		$this->page = $page;

		parent::__construct(
						$page,
						$userBinder,
						$dateBinder,
						$resourceBinder,
						$userSession);
	}

	public function Initialize()
	{
		parent::Initialize();
	}

	protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
	{
		parent::SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
		$this->basePage->SetRepeatTerminationDate($endDate);
	}

	public function GetOwnerId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}

	public function GetResourceId()
	{
		return $this->page->GetRequestedResourceId();
	}

	public function GetScheduleId()
	{
		return $this->page->GetRequestedScheduleId();
	}

	public function GetReservationDate()
	{
		return $this->page->GetReservationDate();
	}

	public function GetStartDate()
	{
		return $this->page->GetStartDate();
	}

	public function GetEndDate()
	{
		return $this->page->GetEndDate();
	}

	public function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}

	public function IsNew()
	{
		return true;
	}
}

class BindableResourceData
{
	/**
	 * @var BookableResource
	 */
	public $ReservationResource;

	/**
	 * @var array|BookableResource[]
	 */
	public $AvailableResources;

	/**
	 * @var int
	 */
	public $NumberAccessible = 0;

	public function __construct()
	{
		$this->ReservationResource = new NullScheduleResource();
		$this->AvailableResources = array();
	}

	/**
	 * @param $resource BookableResource
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->ReservationResource = $resource;
	}

	/**
	 * @param $resource BookableResource
	 * @return void
	 */
	public function AddAvailableResource($resource)
	{
		$this->NumberAccessible++;
		$this->AvailableResources[] = $resource;
	}
}