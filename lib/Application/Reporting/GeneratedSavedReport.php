<?php

require_once(ROOT_DIR . 'Domain/SavedReport.php');

interface IGeneratedSavedReport extends IReport, ISavedReport
{
}

class GeneratedSavedReport implements IGeneratedSavedReport
{
    /**
     * @var ISavedReport
     */
    private $savedReport;

    /**
     * @var IReport
     */
    private $report;

    public function __construct(ISavedReport $savedReport, IReport $report)
    {
        $this->savedReport = $savedReport;
        $this->report = $report;
    }

    /**
     * @return IReportColumns
     */
    public function GetColumns()
    {
        return $this->report->GetColumns();
    }

    /**
     * @return IReportData
     */
    public function GetData()
    {
        return $this->report->GetData();
    }

    /**
     * @return int
     */
    public function ResultCount()
    {
        return $this->report->ResultCount();
    }

    /**
     * @return string
     */
    public function ReportName()
    {
        return $this->savedReport->ReportName();
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->savedReport->Id();
    }
}
