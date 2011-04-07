<?php 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');

class ManageSchedules
{
	const ActionRename = 'rename';
	const ActionChangeSettings = 'settings';
	const ActionChangeLayout = 'changeLayout';
	const ActionAdd = 'add';
}

class ManageSchedulesPresenter
{
	/**
	 * @var IManageSchedulesPage
	 */
	private $page;
	
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;
	
	private $actions = array();
	
	public function __construct(IManageSchedulesPage $page, IScheduleRepository $scheduleRepository)
	{
		$this->page = $page;
		$this->scheduleRepository = $scheduleRepository;
		
		$this->actions[ManageSchedules::ActionRename] = 'Rename';
		$this->actions[ManageSchedules::ActionChangeSettings] = 'ChangeSettings';
		$this->actions[ManageSchedules::ActionChangeLayout] = 'ChangeLayout';
		$this->actions[ManageSchedules::ActionAdd] = 'Add';
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
	
	public function ProcessAction()
	{
		$action = $this->page->GetAction();
		
		if ($this->ActionIsKnown($action))
		{
			$method = $this->actions[$action];
			$this->$method();
		}
		else 
		{
			Log::Error("Unknown manage schedule action %s", $action);
		}
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
	
	private function ActionIsKnown($action)
	{
		return isset($this->actions[$action]);
	}
}
?>