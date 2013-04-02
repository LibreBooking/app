<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationComponentBinder.php');

require_once(ROOT_DIR . 'Pages/ReservationPage.php');

interface IReservationComponentInitializer
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @return Date
	 */
	public function GetStartDate();

	/**
	 * @return Date
	 */
	public function GetEndDate();

	/**
	 * @return Date
	 */
	public function GetReservationDate();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetOwnerId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetTimezone();

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param $startPeriods array|SchedulePeriod[]
	 * @param $endPeriods array|SchedulePeriod[]
	 */
	public function SetDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods);

	/**
	 * @return UserSession
	 */
	public function CurrentUser();

	/**
	 * @param $canChangeUser bool
	 */
	public function SetCanChangeUser($canChangeUser);

	/**
	 * @param $reservationUser UserDto
	 */
	public function SetReservationUser($reservationUser);

	/**
	 * @param $showUserDetails bool
	 */
	public function ShowUserDetails($showUserDetails);

	/**
	 * @abstract
	 * @param $showReservationDetails bool
	 */
	public function ShowReservationDetails($showReservationDetails);

	/**
	 * @param $resources array|ResourceDto[]
	 */
	public function BindAvailableResources($resources);

	/**
	 * @param $accessories array|AccessoryDto[]
	 */
	public function BindAvailableAccessories($accessories);

	/**
	 * @param $shouldShow bool
	 */
	public function ShowAdditionalResources($shouldShow);

	/**
	 * @param $resource ResourceDto
	 */
	public function SetReservationResource($resource);

	/**
	 * @abstract
	 * @param $attribute CustomAttribute
	 * @param $value mixed
	 */
	public function AddAttribute($attribute, $value);

	/**
	 * @abstract
	 * @param ErrorMessages|int $errorMessageId
	 */
	public function RedirectToError($errorMessageId);

	/**
	 * @abstract
	 * @param bool $isHidden
	 */
	public function HideRecurrence($isHidden);
}

abstract class ReservationInitializerBase implements IReservationInitializer, IReservationComponentInitializer
{
	/**
	 * @var IReservationPage
	 */
	protected $basePage;

	/**
	 * @var IReservationComponentBinder
	 */
	protected $userBinder;

	/**
	 * @var IReservationComponentBinder
	 */
	protected $dateBinder;

	/**
	 * @var IReservationComponentBinder
	 */
	protected $resourceBinder;

	/**
	 * @var IReservationComponentBinder
	 */
	protected $attributeBinder;

	/**
	 * @var int
	 */
	protected $currentUserId;

	/**
	 * @var UserSession
	 */
	protected $currentUser;

	/**
	 * @var array|Attribute[]
	 */
	private $customAttributes = array();

	/**
	 * @param $page IReservationPage
	 * @param $userBinder IReservationComponentBinder
	 * @param $dateBinder IReservationComponentBinder
	 * @param $resourceBinder IReservationComponentBinder
	 * @param $attributeBinder IReservationComponentBinder
	 * @param $userSession UserSession
	 */
	public function __construct(
		$page,
		IReservationComponentBinder $userBinder,
		IReservationComponentBinder $dateBinder,
		IReservationComponentBinder $resourceBinder,
		IReservationComponentBinder $attributeBinder,
		UserSession $userSession
	)
	{
		$this->basePage = $page;
		$this->userBinder = $userBinder;
		$this->dateBinder = $dateBinder;
		$this->resourceBinder = $resourceBinder;
		$this->attributeBinder = $attributeBinder;
		$this->currentUser = $userSession;
		$this->currentUserId = $this->currentUser->UserId;
	}

	public function Initialize()
	{
		$requestedScheduleId = $this->GetScheduleId();
		$this->basePage->SetScheduleId($requestedScheduleId);

		$this->BindDates();
		$this->BindResourceAndAccessories();
		$this->BindUser();
		$this->BindAttributes();
	}

	protected function BindUser()
	{
		$this->userBinder->Bind($this);
	}

	protected function BindResourceAndAccessories()
	{
		$this->resourceBinder->Bind($this);
	}

	protected function BindDates()
	{
		$this->dateBinder->Bind($this);
	}

	protected function BindAttributes()
	{
		$this->attributeBinder->Bind($this);
		$this->basePage->SetCustomAttributes($this->customAttributes);
	}

	protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
	{
		$startPeriod = $this->GetStartSlotClosestTo($startPeriods, $startDate);
		$endPeriod = $this->GetEndSlotClosestTo($endPeriods, $endDate);

		//die($startPeriod . $startDate);
		$this->basePage->SetSelectedStart($startPeriod, $startDate);
		$this->basePage->SetSelectedEnd($endPeriod, $endDate);
	}

	/**
	 * @param SchedulePeriod[] $periods
	 * @param Date $date
	 * @return SchedulePeriod
	 */
	private function GetStartSlotClosestTo($periods, $date)
	{
		for ($i = 0; $i < count($periods); $i++)
		{
			$currentPeriod = $periods[$i];
			$periodBegin = $currentPeriod->BeginDate();

			if ($currentPeriod->IsReservable() && $periodBegin->CompareTime($date) >= 0)
			{
				return $currentPeriod;
			}
		}

		$lastIndex = count($periods) - 1;
		return $periods[$lastIndex];
	}

	/**
	 * @param SchedulePeriod[] $periods
	 * @param Date $date
	 * @return SchedulePeriod
	 */
	private function GetEndSlotClosestTo($periods, $date)
	{
		$lastIndex = count($periods) - 1;

		if ($periods[$lastIndex]->EndDate()->CompareTime($date) == 0)
		{
			return $periods[$lastIndex];
		}

		for ($i = 0; $i < count($periods); $i++)
		{
			$currentPeriod = $periods[$i];
			$periodEnd = $currentPeriod->EndDate();

			if ($currentPeriod->IsReservable() && $periodEnd->CompareTime($date) >= 0)
			{
				return $currentPeriod;
			}
		}

		return $periods[$lastIndex];
	}

	public function SetDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
	{
		$this->basePage->BindPeriods($startPeriods, $endPeriods);
		$this->SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
	}

	/**
	 * @return UserSession
	 */
	public function CurrentUser()
	{
		return $this->currentUser;
	}

	/**
	 * @param $canChangeUser bool
	 */
	public function SetCanChangeUser($canChangeUser)
	{
		$this->basePage->SetCanChangeUser($canChangeUser);
	}

	/**
	 * @param $reservationUser UserDto
	 */
	public function SetReservationUser($reservationUser)
	{
		$this->basePage->SetReservationUser($reservationUser);
	}

	/**
	 * @param $showUserDetails bool
	 */
	public function ShowUserDetails($showUserDetails)
	{
		$this->basePage->ShowUserDetails($showUserDetails);
	}

	/**
	 * @param $showReservationDetails bool
	 */
	public function ShowReservationDetails($showReservationDetails)
	{
		$this->basePage->ShowReservationDetails($showReservationDetails);
	}

	/**
	 * @param $resources array|ResourceDto[]
	 */
	public function BindAvailableResources($resources)
	{
		$this->basePage->BindAvailableResources($resources);
	}

	/**
	 * @param $accessories array|AccessoryDto[]
	 */
	public function BindAvailableAccessories($accessories)
	{
		$this->basePage->BindAvailableAccessories($accessories);
	}

	/**
	 * @param $shouldShow bool
	 */
	public function ShowAdditionalResources($shouldShow)
	{
		$this->basePage->ShowAdditionalResources($shouldShow);
	}

	/**
	 * @param $resource ResourceDto
	 */
	public function SetReservationResource($resource)
	{
		$this->basePage->SetReservationResource($resource);
	}

	/**
	 * @param $attribute CustomAttribute
	 * @param $value mixed
	 */
	public function AddAttribute($attribute, $value)
	{
		$this->customAttributes[] = new Attribute($attribute, $value);
	}

	public function RedirectToError($errorMessageId)
	{
		$this->basePage->RedirectToError($errorMessageId);
	}

	public function HideRecurrence($isHidden)
	{
		$this->basePage->HideRecurrence($isHidden);
	}
}

?>