<?php 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');

class ManageResourcesActions
{
	const ActionAdd = 'add';
	const ActionChangeDescription = 'description';
	const ActionChangeLocation = 'location';
	const ActionChangeNotes = 'notes';
	const ActionChangeSchedule = 'schedule';
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
		$this->actions[ManageResourcesActions::ActionChangeDescription] = 'ChangeDescription';
		$this->actions[ManageResourcesActions::ActionChangeLocation] = 'ChangeLocation';
		$this->actions[ManageResourcesActions::ActionChangeNotes] = 'ChangeNotes';
		$this->actions[ManageResourcesActions::ActionChangeSchedule] = 'ChangeSchedule';
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
			try 
			{
				$this->$method();
			}
			catch(Exception $ex)
			{
				Log::Error("Error managing resources. Action %s, Error %s", $action, $ex);
			}
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
		
	}
	
	/**
	 * @internal should only be used for testing
	 */
	public function Rename()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
		
		$resource->SetName($this->page->GetResourceName());
		
		$this->resourceRepository->Update($resource);
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