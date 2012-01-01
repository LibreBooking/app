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
}

class ManageSchedulesPresenter extends ActionPresenter
{
	/**
	 * @var IManageSchedulesPage
	 */
	private $page;
	
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IManageSchedulesPage $page, IScheduleRepository $scheduleRepository)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->scheduleRepository = $scheduleRepository;

		$this->AddAction(ManageSchedules::ActionAdd, 'Add');
		$this->AddAction(ManageSchedules::ActionChangeLayout, 'ChangeLayout');
		$this->AddAction(ManageSchedules::ActionChangeSettings, 'ChangeSettings');
		$this->AddAction(ManageSchedules::ActionMakeDefault, 'MakeDefault');
		$this->AddAction(ManageSchedules::ActionRename, 'Rename');
	}
	
	public function PageLoad()
	{
		$schedules = $this->scheduleRepository->GetAll();
		
		/* @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			$layout = $this->scheduleRepository->GetLayout($schedule->GetId(), new ScheduleLayoutFactory($schedule->GetTimezone()));
			$layouts[$schedule->GetId()] = $layout->GetLayout(Date::Now());
		}
		
		$this->page->BindSchedules($schedules, $layouts);
		$this->PopulateTimezones();
		
	}
	
	private function PopulateTimezones()
	{
		$timezoneValues = array();
		$timezoneOutput = array();
		
		foreach($GLOBALS['APP_TIMEZONES'] as $timezone)
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
		
		$schedule = new Schedule(null, $name, false, $weekdayStart, $daysVisible);

		Log::Debug('Adding schedule with name $%s', $name);

		$this->scheduleRepository->Add($schedule, $copyLayoutFromScheduleId);
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function Rename()
	{
		$schedule = $this->scheduleRepository->LoadById($this->page->GetScheduleId());
		$schedule->SetName($this->page->GetScheduleName());
		
		$this->scheduleRepository->Update($schedule);
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function ChangeSettings()
	{
		$schedule = $this->scheduleRepository->LoadById($this->page->GetScheduleId());
		$schedule->SetWeekdayStart($this->page->GetStartDay());
		$schedule->SetDaysVisible($this->page->GetDaysVisible());
		
		$this->scheduleRepository->Update($schedule);
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function ChangeLayout()
	{
		$scheduleId = $this->page->GetScheduleId();
		$reservableSlots = $this->page->GetReservableSlots();
		$blockedSlots =  $this->page->GetBlockedSlots();
		$timezone =  $this->page->GetLayoutTimezone();
		
		$layout = ScheduleLayout::Parse($timezone, $reservableSlots, $blockedSlots);
	
		$this->scheduleRepository->AddScheduleLayout($scheduleId, $layout);
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function MakeDefault()
	{
		$schedule = $this->scheduleRepository->LoadById($this->page->GetScheduleId());
		$schedule->SetIsDefault(true);
		
		$this->scheduleRepository->Update($schedule);
	}


	protected function LoadValidators($action)
    {
        if ($action == ManageSchedules::ActionChangeLayout)
		{
			$reservableSlots = $this->page->GetReservableSlots();
			$blockedSlots =  $this->page->GetBlockedSlots();
			$this->page->RegisterValidator('layoutValidator', new LayoutValidator($reservableSlots, $blockedSlots));
		}
	}
}
?>