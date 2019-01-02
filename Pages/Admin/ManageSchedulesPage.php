<?php
/**
 * Copyright 2011-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

interface IUpdateSchedulePage
{
    /**
     * @return int
     */
    function GetScheduleId();

    /**
     * @return string
     */
    function GetScheduleName();

    /**
     * @return string
     */
    function GetStartDay();

    /**
     * @return string
     */
    function GetDaysVisible();

    /**
     * @return string
     */
    function GetReservableSlots();

    /**
     * @return string
     */
    function GetBlockedSlots();

    /**
     * @return string[]
     */
    function GetDailyReservableSlots();

    /**
     * @return string[]
     */
    function GetDailyBlockedSlots();

    /**
     * @return string
     */
    function GetLayoutTimezone();

    /**
     * @return bool
     */
    function GetUsingSingleLayout();

    /**
     * @return int
     */
    function GetSourceScheduleId();

    /**
     * @return int
     */
    function GetTargetScheduleId();

    /**
     * @return string
     */
    function GetValue();
}

interface IManageSchedulesPage extends IUpdateSchedulePage, IActionPage, IPageable
{
    /**
     * @param Schedule[] $schedules
     * @param array|IScheduleLayout[] $layouts
     * @param Schedule[] $sourceSchedules
     */
    public function BindSchedules($schedules, $layouts, $sourceSchedules);

    /**
     * @param GroupItemView[] $groups
     */
    public function BindGroups($groups);

    public function SetTimezones($timezoneValues, $timezoneOutput);

    /**
     * @return int
     */
    public function GetAdminGroupId();

    /**
     * @return int[]
     */
    public function GetPeakWeekdays();

    /**
     * @return bool
     */
    public function GetPeakAllDay();

    /**
     * @return bool
     */
    public function GetPeakEveryDay();

    /**
     * @return bool
     */
    public function GetPeakAllYear();

    /**
     * @return string
     */
    public function GetPeakBeginTime();

    /**
     * @return string
     */
    public function GetPeakEndTime();

    /**
     * @return int
     */
    public function GetPeakBeginDay();

    /**
     * @return int
     */
    public function GetPeakBeginMonth();

    /**
     * @return int
     */
    public function GetPeakEndDay();

    /**
     * @return int
     */
    public function GetPeakEndDMonth();

    public function DisplayPeakTimes(IScheduleLayout $layout);

    /**
     * @return bool
     */
    public function GetDeletePeakTimes();

    /**
     * @param BookableResource[] $resources
     */
    public function BindResources($resources);

    /**
     * @return bool
     */
    public function GetAvailableAllYear();

    /**
     * @return string
     */
    public function GetAvailabilityBegin();

    /**
     * @return string
     */
    public function GetAvailabilityEnd();

    /**
     * @param Schedule $schedule
     * @param string $timezone
     */
    public function DisplayAvailability($schedule, $timezone);

    /**
     * @return int
     */
    public function GetLayoutType();

    /**
     * @return string
     */
    public function GetLayoutStart();

    /**
     * @return string
     */
    public function GetLayoutEnd();

    /**
     * @param array $events
     */
    public function BindEvents($events);

    /**
     * @return string
     */
    public function GetSlotStart();

    /**
     * @return string
     */
    public function GetSlotEnd();

    /**
     * @return string
     */
    public function GetCustomLayoutStartRange();

    /**
     * @return string
     */
    public function GetCustomLayoutEndRange();

    /**
     * @return string
     */
    public function GetSlotId();

    /**
     * @return int
     */
    public function GetDefaultStyle();
}

class ManageSchedulesPage extends ActionPage implements IManageSchedulesPage
{
    /**
     * @var ManageSchedulesPresenter
     */
    protected $_presenter;
    protected $pageablePage;

    public function __construct()
    {
        parent::__construct('ManageSchedules', 1);

        $this->pageablePage = new PageablePage($this);
        $this->_presenter = new ManageSchedulesPresenter($this, new ManageScheduleService(new ScheduleRepository(), new ResourceRepository()),
            new GroupRepository());

        $this->Set('CreditsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter()));
    }

    public function ProcessPageLoad()
    {
        $this->_presenter->PageLoad();

        $resources = Resources::GetInstance();
        $this->Set('DayNames', $resources->GetDays('full'));
        $this->Set('Today', Resources::GetInstance()->GetString('Today'));
        $this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('timepicker_js'));
        $this->Set('DefaultDate', Date::Now()->SetTimeString('08:00'));
        $this->Set('Months', Resources::GetInstance()->GetMonths('full'));
        $this->Set('DayList', range(1, 31));
        $this->Set('StyleNames', array(
            ScheduleStyle::Standard => $resources->GetString('Standard'),
            ScheduleStyle::Wide => $resources->GetString('Wide'),
            ScheduleStyle::Tall => $resources->GetString('Tall'),
            ScheduleStyle::CondensedWeek => $resources->GetString('Week'),
            ));
        $this->Display('Admin/Schedules/manage_schedules.tpl');
    }

    public function DisplayPeakTimes(IScheduleLayout $layout)
    {
        $this->Set('Layout', $layout);
        $this->Set('Months', Resources::GetInstance()->GetMonths('full'));
        $this->Set('DayNames', Resources::GetInstance()->GetDays('full'));
        $this->Display('Admin/Schedules/manage_peak_times.tpl');
    }

    public function ProcessAction()
    {
        $this->_presenter->ProcessAction();
    }

    public function SetTimezones($timezoneValues, $timezoneOutput)
    {
        $this->Set('TimezoneValues', $timezoneValues);
        $this->Set('TimezoneOutput', $timezoneOutput);
    }

    public function BindSchedules($schedules, $layouts, $sourceSchedules)
    {
        $this->Set('Schedules', $schedules);
        $this->Set('Layouts', $layouts);
        $this->Set('SourceSchedules', $sourceSchedules);
    }

    public function GetScheduleId()
    {
        $id = $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
        if (empty($id)) {
            $id = $this->GetForm(FormKeys::PK);
        }

        return $id;
    }

    public function GetScheduleName()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_NAME);
    }

    function GetStartDay()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_WEEKDAY_START);
    }

    function GetDaysVisible()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_DAYS_VISIBLE);
    }

    public function GetReservableSlots()
    {
        return $this->server->GetForm(FormKeys::SLOTS_RESERVABLE);
    }

    public function GetBlockedSlots()
    {
        return $this->server->GetForm(FormKeys::SLOTS_BLOCKED);
    }

    public function GetDailyReservableSlots()
    {
        $slots = array();
        foreach (DayOfWeek::Days() as $day) {
            $slots[$day] = $this->server->GetForm(FormKeys::SLOTS_RESERVABLE . "_$day");
        }
        return $slots;
    }

    public function GetDailyBlockedSlots()
    {
        $slots = array();
        foreach (DayOfWeek::Days() as $day) {
            $slots[$day] = $this->server->GetForm(FormKeys::SLOTS_BLOCKED . "_$day");
        }
        return $slots;
    }

    public function GetUsingSingleLayout()
    {
        $singleLayout = $this->server->GetForm(FormKeys::USING_SINGLE_LAYOUT);

        return !empty($singleLayout);
    }

    public function GetLayoutTimezone()
    {
        return $this->server->GetForm(FormKeys::TIMEZONE);
    }

    public function GetSourceScheduleId()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_ID);
    }

    public function GetTargetScheduleId()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_ID);
    }

    public function ProcessDataRequest($dataRequest)
    {
        $this->_presenter->ProcessDataRequest($dataRequest);
    }

    /**
     * @param GroupItemView[] $groups
     */
    public function BindGroups($groups)
    {
        $this->Set('AdminGroups', $groups);
        $groupLookup = array();
        foreach ($groups as $group) {
            $groupLookup[$group->Id] = $group;
        }
        $this->Set('GroupLookup', $groupLookup);
    }

    /**
     * @return int
     */
    public function GetAdminGroupId()
    {
        return $this->server->GetForm(FormKeys::SCHEDULE_ADMIN_GROUP_ID);
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
        $pageSize = $this->pageablePage->GetPageSize();

        if ($pageSize > 10) {
            return 10;
        }
        return $pageSize;
    }

    /**
     * @param PageInfo $pageInfo
     * @return void
     */
    function BindPageInfo(PageInfo $pageInfo)
    {
        $this->pageablePage->BindPageInfo($pageInfo);
    }

    public function GetValue()
    {
        return $this->GetForm(FormKeys::VALUE);
    }

    public function GetPeakWeekdays()
    {
        $days = array();

        $sun = $this->GetForm(FormKeys::REPEAT_SUNDAY);
        if (!empty($sun)) {
            $days[] = 0;
        }

        $mon = $this->GetForm(FormKeys::REPEAT_MONDAY);
        if (!empty($mon)) {
            $days[] = 1;
        }

        $tue = $this->GetForm(FormKeys::REPEAT_TUESDAY);
        if (!empty($tue)) {
            $days[] = 2;
        }

        $wed = $this->GetForm(FormKeys::REPEAT_WEDNESDAY);
        if (!empty($wed)) {
            $days[] = 3;
        }

        $thu = $this->GetForm(FormKeys::REPEAT_THURSDAY);
        if (!empty($thu)) {
            $days[] = 4;
        }

        $fri = $this->GetForm(FormKeys::REPEAT_FRIDAY);
        if (!empty($fri)) {
            $days[] = 5;
        }

        $sat = $this->GetForm(FormKeys::REPEAT_SATURDAY);
        if (!empty($sat)) {
            $days[] = 6;
        }

        return $days;
    }

    public function GetPeakAllDay()
    {
        $allDay = $this->GetForm(FormKeys::PEAK_ALL_DAY);
        return !empty($allDay);
    }

    public function GetPeakEveryDay()
    {
        $everyDay = $this->GetForm(FormKeys::PEAK_EVERY_DAY);
        return !empty($everyDay);
    }

    public function GetPeakAllYear()
    {
        $allYear = $this->GetForm(FormKeys::PEAK_ALL_YEAR);
        return !empty($allYear);
    }

    public function GetPeakBeginTime()
    {
        return $this->GetForm(FormKeys::PEAK_BEGIN_TIME);
    }

    public function GetPeakEndTime()
    {
        return $this->GetForm(FormKeys::PEAK_END_TIME);
    }

    public function GetPeakBeginDay()
    {
        return $this->GetForm(FormKeys::PEAK_BEGIN_DAY);
    }

    public function GetPeakBeginMonth()
    {
        return $this->GetForm(FormKeys::PEAK_BEGIN_MONTH);
    }

    public function GetPeakEndDay()
    {
        return $this->GetForm(FormKeys::PEAK_END_DAY);
    }

    public function GetPeakEndDMonth()
    {
        return $this->GetForm(FormKeys::PEAK_END_MONTH);
    }

    public function GetDeletePeakTimes()
    {
        $delete = $this->GetForm(FormKeys::PEAK_DELETE);
        return $delete == '1';
    }

    public function BindResources($resources)
    {
        $this->Set('Resources', $resources);
    }

    public function GetAvailableAllYear()
    {
        return $this->GetCheckbox(FormKeys::AVAILABLE_ALL_YEAR);
    }

    public function GetAvailabilityBegin()
    {
        return $this->GetForm(FormKeys::AVAILABLE_BEGIN_DATE);
    }

    public function GetAvailabilityEnd()
    {
        return $this->GetForm(FormKeys::AVAILABLE_END_DATE);
    }

    public function DisplayAvailability($schedule, $timezone)
    {
        $this->Set('schedule', $schedule);
        $this->Set('timezone', $timezone);
        $this->Display('Admin/Schedules/manage_availability.tpl');
    }

    public function GetLayoutType()
    {
        return $this->GetForm(FormKeys::LAYOUT_TYPE);
    }

    public function GetLayoutStart()
    {
        return $this->GetQuerystring(QueryStringKeys::START_DATE);
    }

    public function GetLayoutEnd()
    {
        return $this->GetQuerystring(QueryStringKeys::END_DATE);
    }

    public function GetSlotStart()
    {
        return $this->GetForm(FormKeys::BEGIN_DATE);
    }

    public function GetSlotEnd()
    {
        return $this->GetForm(FormKeys::END_DATE);
    }

    public function BindEvents($events)
    {
        $this->SetJson($events);
    }

    public function GetCustomLayoutStartRange()
    {
        return $this->GetQuerystring(QueryStringKeys::START);
    }

    public function GetCustomLayoutEndRange()
    {
        return $this->GetQuerystring(QueryStringKeys::END);
    }

    public function GetSlotId()
    {
        return $this->GetForm(FormKeys::LAYOUT_PERIOD_ID);
    }

    public function GetDefaultStyle()
    {
       return $this->GetForm(FormKeys::SCHEDULE_DEFAULT_STYLE);
    }
}