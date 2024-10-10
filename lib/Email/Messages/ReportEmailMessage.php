<?php

require_once(ROOT_DIR . 'Presenters/Reports/ReportCsvColumnView.php');

class ReportEmailMessage extends EmailMessage
{
    /**
     * @var string
     */
    private $to;
    /**
     * @var UserSession
     */
    private $reportUser;

    private $name = 'untitled-report';

    /**
     * @param IGeneratedSavedReport $report
     * @param IReportDefinition $definition
     * @param string $toAddress
     * @param UserSession $reportUser
     * @param string $selectedColumns
     */
    public function __construct($report, $definition, $toAddress, $reportUser, $selectedColumns)
    {
        parent::__construct($reportUser->LanguageCode);

        $this->to = $toAddress;
        $this->reportUser = $reportUser;

        $this->Set('Definition', $definition);
        $this->Set('Report', $report);
        $this->Set('ReportCsvColumnView', new ReportCsvColumnView($selectedColumns));
        $contents = $this->email->FetchLocalized('Reports/custom-csv.tpl', false);

        $name = $report->ReportName();
        if (!empty($name)) {
            $this->name = $name;
        }
        $this->AddStringAttachment($contents, "{$this->name}.csv");
    }

    public function From()
    {
        return new EmailAddress($this->reportUser->Email);
    }

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function To()
    {
        return new EmailAddress($this->to);
    }

    /**
     * @return string
     */
    public function Subject()
    {
        return $this->Translate('ReportSubject', $this->name);
    }

    /**
     * @return string
     */
    public function Body()
    {
        return $this->FetchTemplate('ReportEmail.tpl');
    }
}
