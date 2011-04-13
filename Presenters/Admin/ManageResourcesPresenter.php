<?php 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');

class ManageResourcesActions
{
	const ActionAdd = 'add';
	const ActionChangeDescription = 'description';
	const ActionRename = 'rename';
}

class ManageResourcesPresenter
{
	/**
	 * @var IManageResourcesPage
	 */
	private $page;
	
	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;
	
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;
	
	private $actions = array();
	
	public function __construct(IManageResourcesPage $page, IResourceRepository $resourceRepository, IScheduleRepository $scheduleRepository)
	{
		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->scheduleRepository = $scheduleRepository;
		
		$this->actions[ManageResourcesActions::ActionAdd] = 'Add';

		$this->actions[ManageResourcesActions::ActionRename] = 'Rename';
	}
	
	public function PageLoad()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$schedules = $this->scheduleRepository->GetAll();
		
		$this->page->BindResources($resources);
		
		$scheduleList = array();
		
		/* @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			$scheduleList[$schedule->GetId()] = $schedule->GetName();
		}
		$this->page->BindSchedules($scheduleList);
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
			Log::Error("Unknown manage resource action %s", $action);
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
		
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function ChangeSettings()
	{
		
	}
	
	private function ActionIsKnown($action)
	{
		return isset($this->actions[$action]);
	}
}
?>