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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

interface ISchedulePage extends IActionPage
{
    /**
     * @param array|Schedule[] $schedules
     */
    public function SetSchedules($schedules);

    /**
     * @param array|ResourceDto[] $resources
     */
    public function SetResources($resources);

    /**
     * @param IDailyLayout $dailyLayout
     */
    public function SetDailyLayout($dailyLayout);

    /**
     * @return int
     */
    public function GetScheduleId();

    /**
     * @param int $scheduleId
     */
    public function SetScheduleId($scheduleId);

    /**
     * @param string $scheduleName
     */
    public function SetScheduleName($scheduleName);

    /**
     * @param int $firstWeekday
     */
    public function SetFirstWeekday($firstWeekday);

    /**
     * @param DateRange $dates
     */
    public function SetDisplayDates($dates);

    /**
     * @param Date $previousDate
     * @param Date $nextDate
     */
    public function SetPreviousNextDates($previousDate, $nextDate);

    /**
     * @return string
     */
    public function GetSelectedDate();

    /**
     * @return Date[]
     */
    public function GetSelectedDates();

    public function ShowInaccessibleResources();

    /**
     * @param bool $showShowFullWeekToggle
     */
    public function ShowFullWeekToggle($showShowFullWeekToggle);

    /**
     * @return bool
     */
    public function GetShowFullWeek();

    /**
     * @param ScheduleLayoutSerializable $layoutResponse
     */
    public function SetLayoutResponse($layoutResponse);

    /**
     * @return string
     */
    public function GetLayoutDate();

    /**
     * @param int $scheduleId
     * @return string|ScheduleStyle
     */
    public function GetScheduleStyle($scheduleId);

    /**
     * @param string|ScheduleStyle Direction
     */
    public function SetScheduleStyle($direction);

    /**
     * @return int
     */
    public function GetResourceId();

    /**
     * @return int[]
     */
    public function GetResourceIds();

    /**
     * @param ResourceGroupTree $resourceGroupTree
     */
    public function SetResourceGroupTree(ResourceGroupTree $resourceGroupTree);

    /**
     * @param ResourceType[] $resourceTypes
     */
    public function SetResourceTypes($resourceTypes);

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceCustomAttributes($attributes);

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceTypeCustomAttributes($attributes);

    /**
     * @return bool
     */
    public function FilterSubmitted();

    /**
     * @return int
     */
    public function GetResourceTypeId();

    /**
     * @return int
     */
    public function GetMaxParticipants();

    /**
     * @return AttributeFormElement[]|array
     */
    public function GetResourceAttributes();

    /**
     * @return AttributeFormElement[]|array
     */
    public function GetResourceTypeAttributes();

    /**
     * @param ScheduleResourceFilter $resourceFilter
     */
    public function SetFilter($resourceFilter);

    /**
     * @param CalendarSubscriptionUrl $subscriptionUrl
     */
    public function SetSubscriptionUrl(CalendarSubscriptionUrl $subscriptionUrl);

    /**
     * @param bool $shouldShow
     */
    public function ShowPermissionError($shouldShow);

    /**
     * @param UserSession $user
     * @param Schedule $schedule
     * @return string
     */
    public function GetDisplayTimezone(UserSession $user, Schedule $schedule);

    /**
     * @param Date[] $specificDates
     */
    public function SetSpecificDates($specificDates);

    /**
     * @return bool
     */
    public function FilterCleared();

    /**
     * @param DateRange $availability
     * @param bool $tooEarly
     */
    public function BindScheduleAvailability($availability, $tooEarly);

    /**
     * @param bool $allowConcurrentReservations
     */
    public function SetAllowConcurrent($allowConcurrentReservations);
}

class SchedulePage extends ActionPage implements ISchedulePage
{
    protected $ScheduleStyle = ScheduleStyle::Standard;
    private $resourceCount = 0;

    /**
     * @var SchedulePresenter
     */
    protected $_presenter;

    private $_styles = array(
        ScheduleStyle::Wide => 'Schedule/schedule-days-horizontal.tpl',
        ScheduleStyle::Tall => 'Schedule/schedule-flipped.tpl',
        ScheduleStyle::CondensedWeek => 'Schedule/schedule-week-condensed.tpl',
    );

    /**
     * @var bool
     */
    private $_isFiltered = true;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct()
    {
        parent::__construct('Schedule');

        $permissionServiceFactory = new PermissionServiceFactory();
        $scheduleRepository = new ScheduleRepository();
        $userRepository = new UserRepository();
        $this->userRepository = $userRepository;
        $schedulePermissionService = new SchedulePermissionService($permissionServiceFactory->GetPermissionService());
        $resourceService = new ResourceService(
            new ResourceRepository(),
            $schedulePermissionService,
            new AttributeService(new AttributeRepository()),
            $userRepository,
            new AccessoryRepository());
        $pageBuilder = new SchedulePageBuilder();
        $reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
        $dailyLayoutFactory = new DailyLayoutFactory();
        $scheduleService = new ScheduleService($scheduleRepository, $resourceService, $dailyLayoutFactory);
        $this->_presenter = new SchedulePresenter($this, $scheduleService, $resourceService, $pageBuilder, $reservationService);
    }

    public function ProcessPageLoad()
    {
        $start = microtime(true);

        $user = ServiceLocator::GetServer()->GetUserSession();

        $this->_presenter->PageLoad($user);

        $endLoad = microtime(true);

        if ($user->IsAdmin && $this->resourceCount == 0 && !$this->_isFiltered) {
            $this->Set('ShowResourceWarning', true);
        }

        $authorizationService = new AuthorizationService($this->userRepository);

        $this->Set('SlotLabelFactory', new SlotLabelFactory($user, $authorizationService));
        $this->Set('DisplaySlotFactory', new DisplaySlotFactory());
        $this->Set('PopupMonths', $this->IsMobile ? 1 : 3);
        $this->Set('CreateReservationPage', Pages::RESERVATION);
        $this->Set('LockTableHead', (int)($this->ScheduleStyle == ScheduleStyle::Tall || (count($this->GetVar('Resources')) > 7)));
        $this->Set('LoadViewOnly', false);
        $this->Set('ShowSubscription', true);

        if ($this->IsMobile && !$this->IsTablet) {
            if ($this->ScheduleStyle == ScheduleStyle::Tall) {
                $this->Display('Schedule/schedule-flipped.tpl');
            }
            else {
                $this->Display('Schedule/schedule-mobile.tpl');
            }
        }
        else {
            if (array_key_exists($this->ScheduleStyle, $this->_styles)) {
                $this->Display($this->_styles[$this->ScheduleStyle]);
            }
            else {
                $this->Display('Schedule/schedule.tpl');
            }
        }

        $endDisplay = microtime(true);

        $load = $endLoad - $start;
        $display = $endDisplay - $endLoad;
        $total = $endDisplay - $start;
        Log::Debug('Schedule took %s sec to load, %s sec to render. Total %s sec', $load, $display, $total);
    }

    public function ProcessDataRequest($dataRequest)
    {
        $this->_presenter->GetLayout(ServiceLocator::GetServer()->GetUserSession());
    }

    public function GetScheduleId()
    {
        return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
    }

    public function SetScheduleId($scheduleId)
    {
        $this->Set('ScheduleId', intval($scheduleId));
    }

    public function SetScheduleName($scheduleName)
    {
        $this->Set('ScheduleName', $scheduleName);
    }

    public function SetSchedules($schedules)
    {
        $this->Set('Schedules', $schedules);
    }

    public function SetFirstWeekday($firstWeekday)
    {
        $this->Set('FirstWeekday', $firstWeekday);
    }

    public function SetResources($resources)
    {
        $this->resourceCount = count($resources);
        $this->Set('Resources', $resources);
    }

    public function SetDailyLayout($dailyLayout)
    {
        $this->Set('DailyLayout', $dailyLayout);
    }

    public function SetDisplayDates($dateRange)
    {
        $this->Set('DisplayDates', $dateRange);
        $this->Set('BoundDates', $dateRange->Dates());
    }

    public function SetSpecificDates($specificDates)
    {
        if (!empty($specificDates)) {
            $this->Set('BoundDates', $specificDates);
        }
        $this->Set('SpecificDates', $specificDates);
    }

    public function SetPreviousNextDates($previousDate, $nextDate)
    {
        $this->Set('PreviousDate', $previousDate);
        $this->Set('NextDate', $nextDate);
    }

    public function GetSelectedDate()
    {
        return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
    }

    public function GetSelectedDates()
    {
        $dates = $this->server->GetQuerystring(QueryStringKeys::START_DATES);
        if (empty($dates)) {
            return array();
        }
        $parseDates = array();
        foreach (explode(',', $dates) as $date) {
            $parseDates[] = Date::Parse($date, ServiceLocator::GetServer()->GetUserSession()->Timezone);
        }

        usort($parseDates, function ($d1, $d2) {
            return $d1->Compare($d2);
        });

        return $parseDates;
    }

    public function ShowInaccessibleResources()
    {
        return Configuration::Instance()
            ->GetSectionKey(ConfigSection::SCHEDULE,
                ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES,
                new BooleanConverter());
    }

    public function ShowFullWeekToggle($showShowFullWeekToggle)
    {
        $this->Set('ShowFullWeekLink', $showShowFullWeekToggle);
    }

    public function GetShowFullWeek()
    {
        $showFullWeek = $this->GetQuerystring(QueryStringKeys::SHOW_FULL_WEEK);

        return !empty($showFullWeek);
    }

    public function ProcessAction()
    {
        // no-op
    }

    public function SetLayoutResponse($layoutResponse)
    {
        $this->SetJson($layoutResponse);
    }

    public function GetLayoutDate()
    {
        return $this->GetQuerystring(QueryStringKeys::LAYOUT_DATE);
    }

    public function GetScheduleStyle($scheduleId)
    {
        $cookie = $this->server->GetCookie("schedule-style-$scheduleId");
        if ($cookie != null) {
            return $cookie;
        }

        return null;
    }

    public function SetScheduleStyle($direction)
    {
        $this->ScheduleStyle = $direction;
        $this->Set('CookieName', 'schedule-style-' . $this->GetVar('ScheduleId'));
    }

    /**
     * @return int
     */
    public function GetResourceId()
    {
        return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }

    /**
     * @return int[]
     */
    public function GetResourceIds()
    {
        $resourceIds = $this->GetQuerystring(FormKeys::RESOURCE_ID);
        if (empty($resourceIds)) {
            return array();
        }

        if (!is_array($resourceIds)) {
            return array(intval($resourceIds));
        }

        return array_filter($resourceIds, 'intval');
    }

    public function SetResourceGroupTree(ResourceGroupTree $resourceGroupTree)
    {
        $this->Set('ResourceGroupsAsJson', json_encode($resourceGroupTree->GetGroups()));
    }

    public function SetResourceTypes($resourceTypes)
    {
        $this->Set('ResourceTypes', $resourceTypes);
    }

    public function SetResourceCustomAttributes($attributes)
    {
        $this->Set('ResourceAttributes', $attributes);
    }

    public function SetResourceTypeCustomAttributes($attributes)
    {
        $this->Set('ResourceTypeAttributes', $attributes);
    }

    public function FilterSubmitted()
    {
        $k = $this->GetQuerystring(FormKeys::SUBMIT);

        return !empty($k);
    }

    public function GetResourceTypeId()
    {
        return $this->GetQuerystring(FormKeys::RESOURCE_TYPE_ID);
    }

    public function GetMaxParticipants()
    {
        $max = $this->GetQuerystring(FormKeys::MAX_PARTICIPANTS);
        return intval($max);
    }

    public function GetResourceAttributes()
    {
        return AttributeFormParser::GetAttributes($this->GetQuerystring('r' . FormKeys::ATTRIBUTE_PREFIX));
    }

    public function GetResourceTypeAttributes()
    {
        return AttributeFormParser::GetAttributes($this->GetQuerystring('rt' . FormKeys::ATTRIBUTE_PREFIX));
    }

    public function SetFilter($resourceFilter)
    {
        $this->Set('ResourceIdFilter', $this->GetResourceId());
        $this->Set('ResourceTypeIdFilter', $resourceFilter->ResourceTypeId);
        $this->Set('MaxParticipantsFilter', $resourceFilter->MinCapacity);
        $this->Set('ResourceIds', $resourceFilter->ResourceIds);
        $this->_isFiltered = $resourceFilter->HasFilter();
    }

    public function SetSubscriptionUrl(CalendarSubscriptionUrl $subscriptionUrl)
    {
        $this->Set('SubscriptionUrl', $subscriptionUrl);
    }

    public function ShowPermissionError($shouldShow)
    {
        $this->Set('IsAccessible', !$shouldShow);
    }

    public function GetDisplayTimezone(UserSession $user, Schedule $schedule)
    {
        return $user->Timezone;
    }

    public function FilterCleared()
    {
        return $this->GetQuerystring('clearFilter') == '1';
    }

    public function BindScheduleAvailability($availability, $tooEarly)
    {
        $this->Set('ScheduleAvailabilityEarly', $tooEarly);
        $this->Set('ScheduleAvailabilityLate', !$tooEarly);
        $this->Set('ScheduleAvailabilityStart', $availability->GetBegin());
        $this->Set('ScheduleAvailabilityEnd', $availability->GetEnd());
        $this->Set('HideSchedule', true);
    }

    public function SetAllowConcurrent($allowConcurrentReservations)
    {
        $this->Set('AllowConcurrentReservations', $allowConcurrentReservations);
        $hide = $this->GetVar('HideSchedule');
        $this->Set('HideSchedule', $hide || $allowConcurrentReservations);
    }
}

