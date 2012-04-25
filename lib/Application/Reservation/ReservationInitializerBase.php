<?php
/**
Copyright 2011-2012 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationComponentBinder.php');

require_once(ROOT_DIR . 'Pages/ReservationPage.php');

abstract class ReservationInitializerBase implements IReservationInitializer
{
	/**
	 * @var IReservationPage
	 */
	protected $basePage;
	
	/**
	 * @var IScheduleRepository
	 */
	protected $scheduleRepository;

	/**
	 * @var IUserRepository
	 */
	protected $userRepository;

	/**
	 * @var IResourceService
	 */
	protected $resourceService;

	/**
	 * @var IReservationAuthorization
	 */
	protected $reservationAuthorization;

	/**
	 * @var int
	 */
	protected $currentUserId;

	/**
	 * @var UserSession
	 */
	protected $currentUser;

	/**
	 * @param $page IReservationPage
	 * @param $scheduleRepository IScheduleRepository
	 * @param $userRepository IUserRepository
	 * @param $resourceService IResourceService
	 * @param $reservationAuthorization IReservationAuthorization
	 * @param $userSession UserSession
	 */
	public function __construct(
		$page, 
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		UserSession $userSession
		)
	{
		$this->basePage = $page;
		$this->scheduleRepository = $scheduleRepository;
		$this->userRepository = $userRepository;
		$this->resourceService = $resourceService;
		$this->reservationAuthorization = $reservationAuthorization;
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
	}

	protected function BindUser()
	{
		$userBinder = new ReservationUserBinder($this->userRepository, $this->reservationAuthorization);
		$userBinder->Bind($this);
	}

	protected function BindResourceAndAccessories()
	{
		$resourceBinder = new ReservationResourceBinder($this->resourceService);
		$resourceBinder->Bind($this);
	}

	protected function BindDates()
	{
		$dateBinder = new ReservationDateBinder($this->scheduleRepository);
		$dateBinder->Bind($this);
	}

	/**
	 * @abstract
	 * @return int
	 */
	public abstract function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	public abstract function GetScheduleId();
	
	/**
	 * @return Date
	 */
	public abstract function GetStartDate();
	
	/**
	 * @return Date
	 */
	public abstract function GetEndDate();
	
	/**
	 * @return Date
	 */
	public abstract function GetReservationDate();

	/**
	 * @abstract
	 * @return int
	 */
	public abstract function GetOwnerId();

	/**
	 * @abstract
	 * @return string
	 */
	public abstract function GetTimezone();
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		$startPeriod = $this->GetStartSlotClosestTo($schedulePeriods, $startDate);
		$endPeriod = $this->GetEndSlotClosestTo($schedulePeriods, $endDate);

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

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param $schedulePeriods array|SchedulePeriod[]
	 */
	public function SetDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		$this->basePage->BindPeriods($schedulePeriods);
		$this->SetSelectedDates($startDate, $endDate, $schedulePeriods);
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
	 * @param $reservationUser bool
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
}
?>