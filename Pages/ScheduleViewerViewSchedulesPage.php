<?php

require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/ViewSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');

class ScheduleViewerViewSchedulesPage extends Page implements IPageable
{
    /**
     * @var ViewSchedulesPresenter
     */
    protected $presenter;

    protected $pageablePage;

    public function __construct()
    {
    //  parent::__construct('ManageSchedules', 1);
        parent::__construct('CheckResources');
        $this->presenter = new ViewSchedulesPresenter($this);

    //     $this->pageablePage = new PageablePage($this);
    //     $this->_presenter = new ManageSchedulesPresenter(
    //         $this,
    //         new ViewSchedulesPresenter(new ScheduleRepository(), new ResourceRepository()),
    //         new GroupRepository()
    //     );

    //     $this->Set('CreditsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter()));
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();
        $this->Display(ROOT_DIR.'tpl/Admin/Schedules/view_schedules.tpl');

        // $resources = Resources::GetInstance();
        // $this->Set('DayNames', $resources->GetDays('full'));
        // $this->Set('Today', Resources::GetInstance()->GetString('Today'));
        // $this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('timepicker_js'));
        // $this->Set('DefaultDate', Date::Now()->SetTimeString('08:00'));
        // $this->Set('Months', Resources::GetInstance()->GetMonths('full'));
        // $this->Set('DayList', range(1, 31));
        // $this->Set('StyleNames', [
        //         ScheduleStyle::Standard => $resources->GetString('Standard'),
        //         ScheduleStyle::Wide => $resources->GetString('Wide'),
        //         ScheduleStyle::Tall => $resources->GetString('Tall'),
        //         ScheduleStyle::CondensedWeek => $resources->GetString('Week'),
        // ]);
    }

    /**
     * @return int
     */
    public function GetPageNumber()
    {
        return $this->pageablePage->GetPageNumber();
    }

    /**
     * @return int
     */
    public function GetPageSize()
    {
        $pageSize = $this->pageablePage->GetPageSize();

        if ($pageSize > 10) {
            return 10;
        }
        return $pageSize;
    }

    /**
     * @param PageInfo $pageInfo
     * @return void
     */
    public function BindPageInfo(PageInfo $pageInfo)
    {
        $this->pageablePage->BindPageInfo($pageInfo);
    }
}