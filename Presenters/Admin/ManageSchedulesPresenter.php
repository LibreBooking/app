<?php 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ManageSchedules
{
	const ActionRename = 'rename';
	const ActionChangeLayout = 'changeLayout';
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
		$this->actions[ManageSchedules::ActionChangeLayout] = 'ChangeLayout';
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
	public function Rename()
	{
		$schedule = $this->scheduleRepository->LoadById($this->page->GetScheduleId());
		$schedule->SetName($this->page->GetScheduleName());
		
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