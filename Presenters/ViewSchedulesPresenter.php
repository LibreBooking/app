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
     * @var ManageScheduleService
     */
    private $manageSchedulesService;

    /**
     * @var IGroupViewRepository
     */
    private $groupViewRepository;

    /**
     * @var ResourceViewerViewResourcesPage;
     */
    private $page;

    public function __construct(
        ScheduleViewerViewSchedulesPage $page,
        // IManageSchedulesPage $page,
        // ManageScheduleService $manageSchedulesService,
        // IGroupViewRepository $groupViewRepository
    ) {
        $this->page = $page;
        //parent::__construct($page);
        // $this->page = $page;
        // $this->manageSchedulesService = $manageSchedulesService;
        // $this->groupViewRepository = $groupViewRepository;

        $this->page->PageLoad;
    }

    public function PageLoad()
    {

    }
}
