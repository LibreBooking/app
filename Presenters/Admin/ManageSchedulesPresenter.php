<?php
/**
 * Copyright 2011-2015 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class ManageSchedules
{
	const ActionAdd = 'add';
	const ActionChangeLayout = 'changeLayout';
	const ActionChangeSettings = 'settings';
	const ActionMakeDefault = 'makeDefault';
	const ActionRename = 'rename';
	const ActionDelete = 'delete';
	const ActionEnableSubscription = 'enableSubscription';
	const ActionDisableSubscription = 'disableSubscription';
	const ChangeAdminGroup = 'changeAdminGroup';
}

class ManageScheduleService
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var array|Schedule[]
	 */
	private $_all;

	public function __construct(IScheduleRepository $scheduleRepository, IResourceRepository $resourceRepository)
	{
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
	}

	/**
	 * @return array|Schedule[]
	 */
	public function GetAll()
	{
		if (is_null($this->_all))
		{
			$this->_all = $this->scheduleRepository->GetAll();
		}
		return $this->_all;
	}

	/**
	 * @return array|Schedule[]
	 */
	public function GetSourceSchedules()
	{
		return $this->GetAll();
	}

	/**
	 * @param Schedule $schedule
	 * @return IScheduleLayout
	 */
	public function GetLayout($schedule)
	{
		return $this->scheduleRepository->GetLayout($schedule->GetId(),
													new ScheduleLayoutFactory($schedule->GetTimezone()));
	}

	/**
	 * @param string $name
	 * @param int $daysVisible
	 * @param int $startDay
	 * @param int $copyLayoutFromScheduleId
	 */
	public function Add($name, $daysVisible, $startDay, $copyLayoutFromScheduleId)
	{
		$schedule = new Schedule(null, $name, false, $startDay, $daysVisible);
		$this->scheduleRepository->Add($schedule, $copyLayoutFromScheduleId);
	}

	/**
	 * @param int $scheduleId
	 * @param string $name
	 */
	public function Rename($scheduleId, $name)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->SetName($name);
		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $scheduleId
	 * @param int $startDay
	 * @param int $daysVisible
	 */
	public function ChangeSettings($scheduleId, $startDay, $daysVisible)
	{
		Log::Debug('Changing scheduleId %s, WeekdayStart: %s, DaysVisible %s', $scheduleId, $startDay, $daysVisible);
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->SetWeekdayStart($startDay);
		$schedule->SetDaysVisible($daysVisible);

		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $scheduleId
	 * @param string $timezone
	 * @param string $reservableSlots
	 * @param string $blockedSlots
	 */
	public function ChangeLayout($scheduleId, $timezone, $reservableSlots, $blockedSlots)
	{
		$layout = ScheduleLayout::Parse($timezone, $reservableSlots, $blockedSlots);
		$this->scheduleRepository->AddScheduleLayout($scheduleId, $layout);
	}

	/**
	 * @param int $scheduleId
	 * @param string $timezone
	 * @param string[] $reservableSlots
	 * @param string[] $blockedSlots
	 */
	public function ChangeDailyLayout($scheduleId, $timezone, $reservableSlots, $blockedSlots)
	{
		$layout = ScheduleLayout::ParseDaily($timezone, $reservableSlots, $blockedSlots);
		$this->scheduleRepository->AddScheduleLayout($scheduleId, $layout);
	}

	/**
	 * @param int $scheduleId
	 */
	public function MakeDefault($scheduleId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->SetIsDefault(true);

		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $scheduleId
	 * @param int $moveResourcesToThisScheduleId
	 */
	public function Delete($scheduleId, $moveResourcesToThisScheduleId)
	{
		$resources = $this->resourceRepository->GetScheduleResources($scheduleId);
		foreach ($resources as $resource)
		{
			$resource->SetScheduleId($moveResourcesToThisScheduleId);
			$this->resourceRepository->Update($resource);
		}

		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$this->scheduleRepository->Delete($schedule);
	}

	/**
	 * @param int $scheduleId
	 */
	public function EnableSubscription($scheduleId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->EnableSubscription();
		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $scheduleId
	 */
	public function DisableSubscription($scheduleId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->DisableSubscription();
		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $scheduleId
	 * @param int $adminGroupId
	 */
	public function ChangeAdminGroup($scheduleId, $adminGroupId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);
		$schedule->SetAdminGroupId($adminGroupId);
		$this->scheduleRepository->Update($schedule);
	}

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @return PageableData|BookableResource[]
	 */
	public function GetList($pageNumber, $pageSize)
	{
		return $this->scheduleRepository->GetList($pageNumber, $pageSize);
	}
}

class ManageSchedulesPresenter extends ActionPresenter
{
	/**
	 * @var IManageSchedulesPage
	 */
	private $page;

	/**
	 * @var ManageScheduleService
	 */
	private $manageSchedulesService;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupViewRepository;

	public function __construct(IManageSchedulesPage $page, ManageScheduleService $manageSchedulesService,
								IGroupViewRepository $groupViewRepository)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->manageSchedulesService = $manageSchedulesService;
		$this->groupViewRepository = $groupViewRepository;

		$this->AddAction(ManageSchedules::ActionAdd, 'Add');
		$this->AddAction(ManageSchedules::ActionChangeLayout, 'ChangeLayout');
		$this->AddAction(ManageSchedules::ActionChangeSettings, 'ChangeSettings');
		$this->AddAction(ManageSchedules::ActionMakeDefault, 'MakeDefault');
		$this->AddAction(ManageSchedules::ActionRename, 'Rename');
		$this->AddAction(ManageSchedules::ActionDelete, 'Delete');
		$this->AddAction(ManageSchedules::ActionEnableSubscription, 'EnableSubscription');
		$this->AddAction(ManageSchedules::ActionDisableSubscription, 'DisableSubscription');
		$this->AddAction(ManageSchedules::ChangeAdminGroup, 'ChangeAdminGroup');
	}

	public function PageLoad()
	{
		$results = $this->manageSchedulesService->GetList($this->page->GetPageNumber(), $this->page->GetPageSize());
		$schedules = $results->Results();

		$sourceSchedules = $this->manageSchedulesService->GetSourceSchedules();

		$layouts = array();
		/* @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			$layout = $this->manageSchedulesService->GetLayout($schedule);
			$layouts[$schedule->GetId()] = $layout;
		}

		$this->page->BindGroups($this->groupViewRepository->GetGroupsByRole(RoleLevel::SCHEDULE_ADMIN));

		$this->page->BindSchedules($schedules, $layouts, $sourceSchedules);
		$this->page->BindPageInfo($results->PageInfo());
		$this->PopulateTimezones();

	}

	private function PopulateTimezones()
	{
		$timezoneValues = array();
		$timezoneOutput = array();

		foreach ($GLOBALS['APP_TIMEZONES'] as $timezone)
		{
			$timezoneValues[] = $timezone;
			$timezoneOutput[] = $timezone;
		}

		$this->page->SetTimezones($timezoneValues, $timezoneOutput);
	}

	/**
	 * @internal should only be used for testing
	 */
	public function Add()
	{
		$copyLayoutFromScheduleId = $this->page->GetSourceScheduleId();
		$name = $this->page->GetScheduleName();
		$weekdayStart = $this->page->GetStartDay();
		$daysVisible = $this->page->GetDaysVisible();

		Log::Debug('Adding schedule with name %s', $name);

		$this->manageSchedulesService->Add($name, $daysVisible, $weekdayStart, $copyLayoutFromScheduleId);
	}

	/**
	 * @internal should only be used for testing
	 */
	public function Rename()
	{
		$this->manageSchedulesService->Rename($this->page->GetScheduleId(), $this->page->GetScheduleName());
	}

	/**
	 * @internal should only be used for testing
	 */
	public function ChangeSettings()
	{
		$this->manageSchedulesService->ChangeSettings($this->page->GetScheduleId(), $this->page->GetStartDay(),
													  $this->page->GetDaysVisible());
	}

	/**
	 * @internal should only be used for testing
	 */
	public function ChangeLayout()
	{
		$scheduleId = $this->page->GetScheduleId();
		$timezone = $this->page->GetLayoutTimezone();
		$usingSingleLayout = $this->page->GetUsingSingleLayout();

		Log::Debug('Changing layout for scheduleId=%s. timezone=%s, usingSingleLayout=%s', $scheduleId, $timezone,
				   $usingSingleLayout);
		if ($usingSingleLayout)
		{
			$reservableSlots = $this->page->GetReservableSlots();
			$blockedSlots = $this->page->GetBlockedSlots();
			$this->manageSchedulesService->ChangeLayout($scheduleId, $timezone, $reservableSlots, $blockedSlots);
		}
		else
		{
			$reservableSlots = $this->page->GetDailyReservableSlots();
			$blockedSlots = $this->page->GetDailyBlockedSlots();
			$this->manageSchedulesService->ChangeDailyLayout($scheduleId, $timezone, $reservableSlots, $blockedSlots);
		}
	}

	/**
	 * @internal should only be used for testing
	 */
	public function ChangeAdminGroup()
	{
		$this->manageSchedulesService->ChangeAdminGroup($this->page->GetScheduleId(), $this->page->GetAdminGroupId());
	}

	/**
	 * @internal should only be used for testing
	 */
	public function MakeDefault()
	{
		$this->manageSchedulesService->MakeDefault($this->page->GetScheduleId());
	}

	/**
	 * @internal should only be used for testing
	 */
	public function Delete()
	{
		$this->manageSchedulesService->Delete($this->page->GetScheduleId(), $this->page->GetTargetScheduleId());
	}

	public function EnableSubscription()
	{
		$this->manageSchedulesService->EnableSubscription($this->page->GetScheduleId());
	}

	public function DisableSubscription()
	{
		$this->manageSchedulesService->DisableSubscription($this->page->GetScheduleId());
	}

	protected function LoadValidators($action)
	{
		if ($action == ManageSchedules::ActionChangeLayout)
		{
			$validateSingle = $this->page->GetUsingSingleLayout();
			if ($validateSingle)
			{
				$reservableSlots = $this->page->GetReservableSlots();
				$blockedSlots = $this->page->GetBlockedSlots();
			}
			else
			{
				$reservableSlots = $this->page->GetDailyReservableSlots();
				$blockedSlots = $this->page->GetDailyBlockedSlots();
			}
			$this->page->RegisterValidator('layoutValidator',
										   new LayoutValidator($reservableSlots, $blockedSlots, $validateSingle));
		}
	}
}