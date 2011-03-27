<?php 
class ManageSchedules
{
	const ActionRename = 'rename';
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
	}
	
	public function PageLoad()
	{
		$schedules = $this->scheduleRepository->GetAll();
		
		/* @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			//$layout = $this->scheduleRepository->GetLayout($schedule->GetId(), new ScheduleLayoutFactory($targetTimezone));
			//$periods = $layout->GetLayout($layoutDate);
		}
		
		$this->page->BindSchedules($schedules);
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
	
	private function Rename()
	{
		$schedule = $this->scheduleRepository->LoadById($this->page->GetScheduleId());
		$schedule->SetName($this->page->GetScheduleName());
		
		$this->scheduleRepository->Update($schedule);
	}
	
	private function ActionIsKnown($action)
	{
		return isset($this->actions[$action]);
	}
}
?>