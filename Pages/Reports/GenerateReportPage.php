<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Reports/IDisplayableReportPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Reports/GenerateReportPresenter.php');
require_once(ROOT_DIR . 'Presenters/Reports/ReportCsvColumnView.php');

interface IGenerateReportPage extends IDisplayableReportPage, IActionPage
{
    /**
     * @return string|Report_Usage
     */
    public function GetUsage();

    /**
     * @return string|Report_ResultSelection
     */
    public function GetResultSelection();

    /**
     * @return string|Report_GroupBy
     */
    public function GetGroupBy();

    /**
     * @return string|Report_Range
     */
    public function GetRange();

    /**
     * @return string
     */
    public function GetStart();

    /**
     * @return string
     */
    public function GetEnd();

    /**
     * @return int[]
     */
    public function GetResourceIds();

    /**
     * @return int[]
     */
    public function GetResourceTypeIds();

    /**
     * @return int[]
     */
    public function GetAccessoryIds();

    /**
     * @return int[]
     */
    public function GetScheduleIds();

    /**
     * @return int
     */
    public function GetUserId();

    /**
     * @return int
     */
    public function GetParticipantId();

    /**
     * @return int[]
     */
    public function GetGroupIds();

    /**
     * @return string
     */
    public function GetReportName();

    /**
     * @param array|BookableResource[] $resources
     */
    public function BindResources($resources);

    /**
     * @param array|AccessoryDto[] $accessories
     */
    public function BindAccessories($accessories);

    /**
     * @param array|Schedule[] $schedules
     */
    public function BindSchedules($schedules);

    /**
     * @param array|GroupItemView[] $groups
     */
    public function BindGroups($groups);

    /**
     * @return bool
     */
    public function GetIncludeDeleted();

    /**
     * @param ResourceType[] $resourceTypes
     */
    public function BindResourceTypes($resourceTypes);

    /**
     * @return string
     */
    public function GetSelectedColumns();
}

class GenerateReportPage extends ActionPage implements IGenerateReportPage
{
    /**
     * @var GenerateReportPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('Reports', 1);
        $this->presenter = new GenerateReportPresenter(
            $this,
            ServiceLocator::GetServer()->GetUserSession(),
            new ReportingService(new ReportingRepository()),
            new ResourceRepository(),
            new ScheduleRepository(),
            new GroupRepository(),
            new UserRepository()
        );
    }

    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    public function ProcessDataRequest($dataRequest)
    {
        // no-op
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad();
        $this->Set('DateAxisFormat', Resources::GetInstance()->GetDateFormat('report_date'));
        $this->Display('Reports/generate-report.tpl');
    }

    public function GetUsage()
    {
        return $this->GetValue(FormKeys::REPORT_USAGE);
    }

    public function GetResultSelection()
    {
        return $this->GetValue(FormKeys::REPORT_RESULTS);
    }

    public function GetGroupBy()
    {
        return $this->GetValue(FormKeys::REPORT_GROUPBY);
    }

    public function GetRange()
    {
        return $this->GetValue(FormKeys::REPORT_RANGE);
    }

    public function GetStart()
    {
        return $this->GetValue(FormKeys::REPORT_START);
    }

    public function GetEnd()
    {
        return $this->GetValue(FormKeys::REPORT_END);
    }

    public function GetResourceIds()
    {
        return $this->GetMultiFormValue(FormKeys::RESOURCE_ID);
    }

    public function GetResourceTypeIds()
    {
        return $this->GetMultiFormValue(FormKeys::RESOURCE_TYPE_ID);
    }

    public function GetScheduleIds()
    {
        return $this->GetMultiFormValue(FormKeys::SCHEDULE_ID);
    }

    public function GetUserId()
    {
        return $this->GetValue(FormKeys::USER_ID);
    }

    public function GetParticipantId()
    {
        return $this->GetValue(FormKeys::PARTICIPANT_ID);
    }

    public function GetGroupIds()
    {
        return $this->GetMultiFormValue(FormKeys::GROUP_ID);
    }

    private function GetMultiFormValue($key)
    {
        $id = $this->GetValue($key);
        if (!is_array($id) && !empty($id)) {
            return [$id];
        }
        return $id;
    }

    public function BindReport(IReport $report, IReportDefinition $definition, $selectedColumns)
    {
        $this->Set('Definition', $definition);
        $this->Set('Report', $report);
        $this->Set('SelectedColumns', $selectedColumns);
    }

    public function BindResources($resources)
    {
        $this->Set('Resources', $resources);
    }

    public function BindResourceTypes($resourceTypes)
    {
        $this->Set('ResourceTypes', $resourceTypes);
    }

    public function BindAccessories($accessories)
    {
        $this->Set('Accessories', $accessories);
    }

    public function BindSchedules($schedules)
    {
        $this->Set('Schedules', $schedules);
    }

    public function GetAccessoryIds()
    {
        return $this->GetValue(FormKeys::ACCESSORY_ID);
    }

    public function GetReportName()
    {
        return $this->GetForm(FormKeys::REPORT_NAME);
    }

    private function GetValue($key)
    {
        $postValue = $this->GetForm($key);

        if (empty($postValue)) {
            return $this->GetQuerystring($key);
        }

        return $postValue;
    }

    public function ShowCsv()
    {
        $this->Set('ReportCsvColumnView', new ReportCsvColumnView($this->GetVar('SelectedColumns')));
        $this->DisplayCsv('Reports/custom-csv.tpl', 'report.csv');
    }

    public function DisplayError()
    {
        $this->Display('Reports/error.tpl');
    }

    public function ShowResults()
    {
        $this->Display('Reports/results-custom.tpl');
    }

    public function PrintReport()
    {
        $this->Set('ReportCsvColumnView', new ReportCsvColumnView($this->GetVar('SelectedColumns')));
        $this->Display('Reports/print-custom-report.tpl');
    }

    public function BindGroups($groups)
    {
        $this->Set('Groups', $groups);
    }

    public function GetIncludeDeleted()
    {
        $include = $this->GetValue(FormKeys::INCLUDE_DELETED);
        return isset($include);
    }

    public function GetSelectedColumns()
    {
        return $this->GetForm(FormKeys::SELECTED_COLUMNS);
    }
}
