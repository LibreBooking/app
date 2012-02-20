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
 
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class NewReservationInitializer extends ReservationInitializerBase
{	
	/**
	 * @var INewReservationPage
	 */
	private $_page;
	
	public function __construct(
		INewReservationPage $page, 
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		UserSession $userSession
		)
	{
		$this->_page = $page;
		
		parent::__construct(
						$page, 
						$scheduleRepository, 
						$userRepository,
						$resourceService,
						$reservationAuthorization,
						$userSession);
	}
	
	public function Initialize()
	{
		parent::Initialize();
	}
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		parent::SetSelectedDates($startDate, $endDate, $schedulePeriods);
		$this->basePage->SetRepeatTerminationDate($endDate);
	}
	
	protected function GetOwnerId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}
	
	protected function GetResourceId()
	{
		return $this->_page->GetRequestedResourceId();
	}
	
	protected function GetScheduleId()
	{
		return $this->_page->GetRequestedScheduleId();
	}
	
	protected function GetReservationDate()
	{
		return $this->_page->GetReservationDate();
	}
	
	protected function GetStartDate()
	{
		return $this->_page->GetStartDate();
	}
	
	protected function GetEndDate()
	{
		return $this->_page->GetEndDate();
	}
	
	protected function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
}

class BindableResourceData
{
	/**
	 * @var ResourceDto
	 */
	public $ReservationResource;

	/**
	 * @var array|ResourceDto[]
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
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->ReservationResource = $resource;
	}

	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function AddAvailableResource($resource)
	{
		if ($resource->CanAccess)
		{
			$this->NumberAccessible++;
		}
		$this->AvailableResources[] = $resource;	
	}
}

?>