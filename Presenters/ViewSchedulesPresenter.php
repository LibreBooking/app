<?php

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class ViewSchedulesPresenter
{
    // /**
    //  * @var IManageSchedulesPage
    //  */
    // private $page;

    /**
     * @var ResourceViewerViewResourcesPage;
     */
    private $page;

    /**
     * @var IScheduleRepository;
     */
    private $scheduleRepo;

    public function __construct(
        ScheduleViewerViewSchedulesPage $page,
        ScheduleRepository $scheduleRepo
    ) {
        $this->page = $page;
        $this->scheduleRepo = $scheduleRepo;
        //parent::__construct($page);
        // $this->page = $page;
        // $this->manageSchedulesService = $manageSchedulesService;
        // $this->groupViewRepository = $groupViewRepository;

        $this->page->PageLoad;
    }

    public function PageLoad()
    {
        $this->page->BindSchedules($this->scheduleRepo->GetAll());
    }
}
