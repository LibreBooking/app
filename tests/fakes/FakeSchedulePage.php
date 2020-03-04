<?php
/**
 * Copyright 2020 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/Schedule/LoadReservationRequest.php');

class FakeSchedulePage implements ISchedulePage
{
    public $_FilterSubmitted = false;
    public $_ResourceTypeId;
    public $_MaxParticipants;
    public $_ResourceAttributes = array();
    public $_ResourceTypeAttributes = array();
    public $_ResourceIds = array();
    public $_SelectedDates = array();
    public $_ScheduleAvailability;
    public $_ScheduleTooEarly;
    public $_ScheduleTooLate;
    /**
     * @var LoadReservationRequest
     */
    public $_LoadReservationRequest;

    /**
     * @var ReservationListItem[]
     */
    public  $_BoundReservations = [];

    public function TakingAction()
    {
    }

    public function GetAction()
    {
    }

    public function RequestingData()
    {
    }

    public function GetDataRequest()
    {
    }

    public function PageLoad()
    {
    }

    public function Redirect($url)
    {
    }

    public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
    {
    }

    public function IsPostBack()
    {
    }

    public function IsValid()
    {
    }

    public function GetLastPage($defaultPage = '')
    {
    }

    public function RegisterValidator($validatorId, $validator)
    {
    }

    public function EnforceCSRFCheck()
    {
    }

    /**
     * Bind schedules to the page
     *
     * @param array|Schedule[] $schedules
     */
    public function SetSchedules($schedules)
    {
    }

    /**
     * Bind resources to the page
     *
     * @param array|ResourceDto[] $resources
     */
    public function SetResources($resources)
    {
    }

    /**
     * Bind layout to the page for daily time slot layouts
     *
     * @param IDailyLayout $dailyLayout
     */
    public function SetDailyLayout($dailyLayout)
    {
    }

    /**
     * Returns the currently selected scheduleId
     * @return int
     */
    public function GetScheduleId()
    {
    }

    /**
     * @param int $scheduleId
     */
    public function SetScheduleId($scheduleId)
    {
    }

    /**
     * @param string $scheduleName
     */
    public function SetScheduleName($scheduleName)
    {
    }

    /**
     * @param int $firstWeekday
     */
    public function SetFirstWeekday($firstWeekday)
    {
    }

    /**
     * Sets the dates to be displayed for the schedule, adjusted for timezone if necessary
     *
     * @param DateRange $dates
     */
    public function SetDisplayDates($dates)
    {
    }

    /**
     * @param Date $previousDate
     * @param Date $nextDate
     */
    public function SetPreviousNextDates($previousDate, $nextDate)
    {
    }

    /**
     * @return string
     */
    public function GetSelectedDate()
    {
    }

    /**
     */
    public function ShowInaccessibleResources()
    {
    }

    /**
     * @param bool $showShowFullWeekToggle
     */
    public function ShowFullWeekToggle($showShowFullWeekToggle)
    {
    }

    /**
     * @return bool
     */
    public function GetShowFullWeek()
    {
    }

    /**
     * @param ScheduleLayoutSerializable $layoutResponse
     */
    public function SetLayoutResponse($layoutResponse)
    {
    }

    /**
     * @return string
     */
    public function GetLayoutDate()
    {
    }

    /**
     * @param int $scheduleId
     * @return string|ScheduleStyle
     */
    public function GetScheduleStyle($scheduleId)
    {
    }

    /**
     * @param string|ScheduleStyle Direction
     */
    public function SetScheduleStyle($direction)
    {
    }

    /**
     * @return int
     */
    public function GetGroupId()
    {
    }

    /**
     * @return int[]
     */
    public function GetResourceIds()
    {
        return $this->_ResourceIds;
    }

    /**
     * @param ResourceGroupTree $resourceGroupTree
     */
    public function SetResourceGroupTree(ResourceGroupTree $resourceGroupTree)
    {
    }

    /**
     * @param ResourceType[] $resourceTypes
     */
    public function SetResourceTypes($resourceTypes)
    {
    }

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceCustomAttributes($attributes)
    {
    }

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceTypeCustomAttributes($attributes)
    {
    }

    /**
     * @return bool
     */
    public function FilterSubmitted()
    {
        return $this->_FilterSubmitted;
    }

    /**
     * @return int
     */
    public function GetResourceTypeId()
    {
        return $this->_ResourceTypeId;
    }

    /**
     * @return int
     */
    public function GetMinCapacity()
    {
        return $this->_MaxParticipants;
    }

    /**
     * @return AttributeFormElement[]|array
     */
    public function GetResourceAttributes()
    {
        return $this->_ResourceAttributes;
    }

    /**
     * @return AttributeFormElement[]|array
     */
    public function GetResourceTypeAttributes()
    {
        return $this->_ResourceTypeAttributes;
    }

    public function SetFilter($resourceFilter)
    {
    }

    public function SetSubscriptionUrl(CalendarSubscriptionUrl $subscriptionUrl)
    {
    }

    public function ShowPermissionError($shouldShow)
    {
    }

    public function GetDisplayTimezone(UserSession $user, Schedule $schedule)
    {
    }

    public function GetResourceId()
    {
    }

    public function GetSelectedDates()
    {
        return $this->_SelectedDates;
    }

    public function SetSpecificDates($specificDates)
    {
    }

    public function GetSortField()
    {
    }

    public function GetSortDirection()
    {
    }

    public function FilterCleared()
    {
    }

    public function BindScheduleAvailability($availability, $tooEarly)
    {
        $this->_ScheduleAvailability = $availability;
        $this->_ScheduleTooEarly = $tooEarly;
        $this->_ScheduleTooLate = !$tooEarly;
    }

    public function SetAllowConcurrent($allowConcurrentReservations)
    {
    }

    /**
     * @inheritDoc
     */
    public function GetReservationRequest()
    {
        return $this->_LoadReservationRequest;
    }

    /**
     * @inheritDoc
     */
    public function BindReservations(array $items)
    {
        $this->_BoundReservations = $items;
    }
}
