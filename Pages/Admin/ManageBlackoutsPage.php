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

require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

interface IManageBlackoutsPage extends IPageable, IActionPage
{
	/**
	 * @abstract
	 * @param array|BlackoutItemView[] $blackouts
	 * @return void
	 */
	public function BindBlackouts($blackouts);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetStartDate();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetEndDate();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetStartDate($date);

	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetEndDate($date);

	/**
	 * @abstract
	 * @param int $scheduleId
	 * @return void
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param int $resourceId
	 * @return void
	 */
	public function SetResourceId($resourceId);

	/**
	 * @abstract
	 * @param array|Schedule[] $schedules
	 * @return void
	 */
	public function BindSchedules($schedules);

	/**
	 * @abstract
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetDeleteBlackoutId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetDeleteScope();

	/**
	 * @abstract
	 * @return void
	 */
	public function ShowPage();

	/**
	 * @abstract
	 * @return bool
	 */
	public function GetApplyBlackoutToAllResources();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetBlackoutScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetBlackoutResourceId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetBlackoutStartDate();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetBlackoutStartTime();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetBlackoutEndDate();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetBlackoutEndTime();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetBlackoutTitle();

	/**
	 * @abstract
	 * @return string|ReservationConflictResolution
	 */
	public function GetBlackoutConflictAction();

    /**
     * @abstract
     * @return int
     */
    public function GetBlackoutId();

	/**
	 * @abstract
	 * @param bool $wasAddedSuccessfully
	 * @param string $displayMessage
	 * @param array|ReservationItemView[] $conflictingReservations
	 * @param array|BlackoutItemView[] $conflictingBlackouts
	 * @param string $timezone
	 * @return void
	 */
	public function ShowAddResult($wasAddedSuccessfully, $displayMessage, $conflictingReservations, $conflictingBlackouts, $timezone);
}

class ManageBlackoutsPage extends AdminPage implements IManageBlackoutsPage
{
	/**
	 * @var \ManageBlackoutsPresenter
	 */
	private $presenter;

	/**
	 * @var \PageablePage
	 */
	private $pageablePage;

	public function __construct()
	{
	    parent::__construct('ManageBlackouts');

		$this->presenter = new ManageBlackoutsPresenter($this,
			new ManageBlackoutsService(new ReservationViewRepository(), new BlackoutRepository()),
			new ScheduleRepository(),
			new ResourceRepository());

		$this->pageablePage = new PageablePage($this);
	}
	
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function PageLoad()
	{
		$userTimezone = $this->server->GetUserSession()->Timezone;

		$this->Set('Timezone', $userTimezone);
		$this->Set('AddStartDate', Date::Now()->ToTimezone($userTimezone));
		$this->Set('AddEndDate', Date::Now()->ToTimezone($userTimezone));
		$this->presenter->PageLoad($userTimezone);
	}

	public function ShowPage()
	{
		$this->Display('manage_blackouts.tpl');
	}

	public function ShowAddResult($wasAddedSuccessfully, $displayMessage, $conflictingReservations, $conflictingBlackouts, $timezone)
	{
		$this->Set('Successful', $wasAddedSuccessfully);
		$this->Set('Message', $displayMessage);
		$this->Set('Reservations', $conflictingReservations);
		$this->Set('Blackouts', $conflictingBlackouts);
		$this->Set('Timezone', $timezone);
		$this->Display('manage_blackouts_response.tpl');
	}
	
	public function BindBlackouts($blackouts)
	{
		$this->Set('blackouts', $blackouts);
	}

	/**
	 * @return string
	 */
	public function GetStartDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}

	/**
	 * @return string
	 */
	public function GetEndDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::END_DATE);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetStartDate($date)
	{
		$this->Set('StartDate', $date);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetEndDate($date)
	{
		$this->Set('EndDate', $date);
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	/**
	 * @param int $scheduleId
	 * @return void
	 */
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}

	/**
	 * @param int $resourceId
	 * @return void
	 */
	public function SetResourceId($resourceId)
	{
		$this->Set('ResourceId', $resourceId);
	}

	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @return int
	 */
	function GetPageNumber()
	{
		return $this->pageablePage->GetPageNumber();
	}

	/**
	 * @return int
	 */
	function GetPageSize()
	{
		return $this->pageablePage->GetPageSize();
	}

	/**
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	function BindPageInfo(PageInfo $pageInfo)
	{
		$this->pageablePage->BindPageInfo($pageInfo);
	}

	/**
	 * @return string
	 */
	public function GetDeleteBlackoutId()
	{
		return $this->GetQuerystring(QueryStringKeys::BLACKOUT_ID);
	}

	/**
	 * @return string
	 */
	public function GetDeleteScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}

	/**
	 * @return bool
	 */
	public function GetApplyBlackoutToAllResources()
	{
		$applyToSchedule = $this->GetForm(FormKeys::BLACKOUT_APPLY_TO_SCHEDULE);
		return isset($applyToSchedule);
	}

	/**
	 * @return int
	 */
	public function GetBlackoutScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}

	/**
	 * @return int
	 */
	public function GetBlackoutResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	/**
	 * @return string
	 */
	public function GetBlackoutStartDate()
	{
		return $this->GetForm(FormKeys::BEGIN_DATE);
	}

	/**
	 * @return string
	 */
	public function GetBlackoutStartTime()
	{
		return $this->GetForm(FormKeys::BEGIN_TIME);
	}

	/**
	 * @return string
	 */
	public function GetBlackoutEndDate()
	{
		return $this->GetForm(FormKeys::END_DATE);
	}

	/**
	 * @return string
	 */
	public function GetBlackoutEndTime()
	{
		return $this->GetForm(FormKeys::END_TIME);
	}

	/**
	 * @return string
	 */
	public function GetBlackoutTitle()
	{
		return $this->GetForm(FormKeys::SUMMARY);
	}

	/**
	 * @return string|ReservationConflictResolution
	 */
	public function GetBlackoutConflictAction()
	{
		return $this->GetForm(FormKeys::CONFLICT_ACTION);
	}


    /**
     * @return int
     */
    public function GetBlackoutId()
    {
        return $this->GetQuerystring(QueryStringKeys::BLACKOUT_ID);
    }
}
?>