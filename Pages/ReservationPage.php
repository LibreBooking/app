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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');

interface IReservationPage extends IPage
{
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param $periods array|ISchedulePeriod[]
	 */
	function BindPeriods($periods);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param $resources array|ResourceDto[]
	 */
	function BindAvailableResources($resources);

	/**
	 * @abstract
	 * @param $accessories array|AccessoryDto[]
	 * @return void
	 */
	function BindAvailableAccessories($accessories);

	/**
	 * @param SchedulePeriod $selectedStart
	 * @param Date $startDate
	 */
	function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate);
	
	/**
	 * @param SchedulePeriod $selectedEnd
	 * @param Date $endDate
	 */
	function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate);
	
	/**
	 * @param $repeatTerminationDate Date
	 */
	function SetRepeatTerminationDate($repeatTerminationDate);
	
	/**
	 * @param UserDto $user
	 */
	function SetReservationUser(UserDto $user);
	
	/**
	 * @param ResourceDto $resource
	 */
	function SetReservationResource($resource);

	/**
	 * @param int $scheduleId
	 */
	function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param ReservationUserView[] $participants
	 * @return void
	 */
	function SetParticipants($participants);

	/**
	 * @abstract
	 * @param ReservationUserView[] $invitees
	 * @return void
	 */
	function SetInvitees($invitees);

	/**
	 * @abstract
	 * @param $accessories ReservationAccessory[]|array
	 * @return void
	 */
	function SetAccessories($accessories);

	/**
	 * @abstract
	 * @param $canChangeUser
	 * @return void
	 */
	function SetCanChangeUser($canChangeUser);

    /**
     * @abstract
     * @param bool $canShowAdditionalResources
     */
	function ShowAdditionalResources($canShowAdditionalResources);

    /**
     * @abstract
     * @param bool $canShowUserDetails
     */
    function ShowUserDetails($canShowUserDetails);
}

abstract class ReservationPage extends Page implements IReservationPage
{
	protected $presenter;
	/**
	 * @var PermissionServiceFactory
	 */
	protected $permissionServiceFactory;

	/**
	 * @var ReservationInitializerFactory
	 */
	protected $initializationFactory;
	
	public function __construct($title = null)
	{
		parent::__construct($title);
		
		$this->permissionServiceFactory = new PermissionServiceFactory();

		$this->initializationFactory = new ReservationInitializerFactory(
			new ScheduleUserRepository(),
			new ScheduleRepository(),
			new UserRepository(),
			new ResourceService(new ResourceRepository(), $this->permissionServiceFactory->GetPermissionService()),
			new ReservationAuthorization(AuthorizationServiceFactory::GetAuthorizationService()),
			ServiceLocator::GetServer()->GetUserSession()
			);

		$this->presenter = $this->GetPresenter();
	}
	
	/**
	 * @return IReservationPresenter
	 */
	protected abstract function GetPresenter();
	
	/**
	 * @return string
	 */
	protected abstract function GetTemplateName();
	
	/**
	 * @return string
	 */
	protected abstract function GetReservationAction();
		
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Set('ReturnUrl', $this->GetLastPage(Pages::SCHEDULE));
		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array (
						'none' => array('key' => 'DoesNotRepeat', 'everyKey' => ''),
						'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
						'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
						'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
						'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								)
		);
		$this->Set('DayNames', array(
								0 => 'DaySundayAbbr',
								1 => 'DayMondayAbbr',
								2 => 'DayTuesdayAbbr',
								3 => 'DayWednesdayAbbr',
								4 => 'DayThursdayAbbr',
								5 => 'DayFridayAbbr',
								6 => 'DaySaturdayAbbr',
								)
		);
		$this->Set('ReservationAction', $this->GetReservationAction());
		
		$this->Display($this->GetTemplateName());
	}
	
	public function BindPeriods($periods)
	{
		$this->Set('Periods', $periods);
	}
	
	public function BindAvailableResources($resources)
	{
		$this->Set('AvailableResources', $resources);
	}

	public function ShowAdditionalResources($shouldShow)
	{
		$this->Set('ShowAdditionalResources', $shouldShow);
	}

	public function BindAvailableAccessories($accessories)
	{
		$this->Set('AvailableAccessories', $accessories);
	}
	
	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate)
	{
		$this->Set('SelectedStart', $selectedStart);
		$this->Set('StartDate', $startDate);
	}
	
	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate)
	{
		$this->Set('SelectedEnd', $selectedEnd);
		$this->Set('EndDate', $endDate);
	}

	/**
	 * @param UserDto $user
	 * @return void
	 */
	public function SetReservationUser(UserDto $user)
	{
		$this->Set('ReservationUserName', $user->FullName());
		$this->Set('UserId', $user->Id());
	}
	
	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->Set('ResourceName', $resource->Name);
		$this->Set('ResourceId', $resource->Id);
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}
	
	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
		$this->Set('RepeatTerminationDate', $repeatTerminationDate);
	}

	public function SetParticipants($participants)
	{
		$this->Set('Participants', $participants);
	}

	public function SetInvitees($invitees)
	{
		$this->Set('Invitees', $invitees);
	}

	public function SetAccessories($accessories)
	{
		$this->Set('Accessories', $accessories);
	}

	public function SetCanChangeUser($canChangeUser)
	{
		$this->Set('CanChangeUser', $canChangeUser);
	}

    public function ShowUserDetails($canShowUserDetails)
    {
        $this->Set('ShowUserDetails', $canShowUserDetails);
    }
}
?>