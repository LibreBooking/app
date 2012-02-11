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
	 */
	public function __construct(
		$page, 
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization
		)
	{
		$this->basePage = $page;
		$this->scheduleRepository = $scheduleRepository;
		$this->userRepository = $userRepository;
		$this->resourceService = $resourceService;
		$this->reservationAuthorization = $reservationAuthorization;
	}
	
	public function Initialize()
	{
		$this->currentUser = ServiceLocator::GetServer()->GetUserSession();
		$this->currentUserId = $this->currentUser->UserId;
				
		$requestedResourceId = $this->GetResourceId();
		$requestedScheduleId = $this->GetScheduleId();
		$reservationDate = $this->GetReservationDate();
		$requestedStartDate = $this->GetStartDate();
		$requestedEndDate = $this->GetEndDate();
		
		$userId = $this->GetOwnerId();
		$timezone = $this->GetTimezone();
		
		$requestedDate = ($reservationDate == null) ? Date::Now()->ToTimezone($timezone) : $reservationDate->ToTimezone($timezone);
		
		$startDate = ($requestedStartDate == null) ? $requestedDate : $requestedStartDate->ToTimezone($timezone);
		$endDate = ($requestedEndDate == null) ? $requestedDate : $requestedEndDate->ToTimezone($timezone);
		
		$layout = $this->scheduleRepository->GetLayout($requestedScheduleId, new ReservationLayoutFactory($timezone));
		$schedulePeriods = $layout->GetLayout($requestedDate);
		$this->basePage->BindPeriods($schedulePeriods);

		$resources = $this->resourceService->GetScheduleResources($requestedScheduleId, false, $this->currentUser);

		$this->basePage->SetCanChangeUser($this->reservationAuthorization->CanChangeUsers($this->currentUser));

		$bindableResourceData = $this->GetBindableResourceData($resources, $requestedResourceId);
		$reservationUser = $this->userRepository->GetById($userId);
		$this->basePage->SetReservationUser($reservationUser);
		
		$this->basePage->BindAvailableResources($bindableResourceData->AvailableResources);
		$accessories = $this->resourceService->GetAccessories();
		$this->basePage->BindAvailableAccessories($accessories);
		
		$this->SetSelectedDates($startDate, $endDate, $schedulePeriods);
		
		$this->basePage->SetReservationResource($bindableResourceData->ReservationResource);
		$this->basePage->SetScheduleId($requestedScheduleId);
	}

	/**
	 * @abstract
	 * @return int
	 */
	protected abstract function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	protected abstract function GetScheduleId();
	
	/**
	 * @return Date
	 */
	protected abstract function GetStartDate();
	
	/**
	 * @return Date
	 */
	protected abstract function GetEndDate();
	
	/**
	 * @return Date
	 */
	protected abstract function GetReservationDate();

	/**
	 * @abstract
	 * @return int
	 */
	protected abstract function GetOwnerId();

	/**
	 * @abstract
	 * @return string
	 */
	protected abstract function GetTimezone();
	
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
		for ($i = 0; $i < count($periods); $i++)
		{
			$currentPeriod = $periods[$i];
			$periodEnd = $currentPeriod->EndDate();

			if ($currentPeriod->IsReservable() && $periodEnd->CompareTime($date) >= 0)
			{
				return $currentPeriod;
			}
		}

		$lastIndex = count($periods) - 1;
		return $periods[$lastIndex];
	}

	/**
	 * @param $resources array|ResourceDto[]
	 * @param $requestedResourceId int
	 * @return BindableResourceData
	 */
	private function GetBindableResourceData($resources, $requestedResourceId)
	{
		//$resources = $scheduleUser->GetAllResources();
		
		$bindableResourceData = new BindableResourceData();

		/** @var $resource ResourceDto */
		foreach ($resources as $resource)
		{
			if ($resource->Id != $requestedResourceId)
			{
				$bindableResourceData->AddAvailableResource($resource);
			}
			else
			{
				$bindableResourceData->SetReservationResource($resource);
			}
		}
		
		return $bindableResourceData;
	}


}
?>