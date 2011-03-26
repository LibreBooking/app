<?php 
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
	
	public function __construct(IManageSchedulesPage $page, IScheduleRepository $scheduleRepository)
	{
		$this->page = $page;
		$this->scheduleRepository = $scheduleRepository;
	}
	
	public function PageLoad()
	{
		$schedules = $this->scheduleRepository->GetAll();
		
		$this->page->BindSchedules($schedules);
	}
}
?>