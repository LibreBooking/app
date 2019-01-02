<?php
/**
 * Copyright 2012-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Reports/IDisplayableReportPage.php');
require_once(ROOT_DIR . 'Presenters/Reports/CommonReportsPresenter.php');
require_once(ROOT_DIR . 'Presenters/Reports/ReportCsvColumnView.php');

interface ICommonReportsPage extends IDisplayableReportPage, IActionPage
{
	/**
	 * @return int
	 */
	public function GetReportId();

	/**
	 * @param string $emailAddress
	 */
	public function SetEmailAddress($emailAddress);

	/**
	 * @return string
	 */
	public function GetEmailAddress();

	/**
	 * @return string
	 */
	public function GetSelectedColumns();
}

class CommonReportsPage extends ActionPage implements ICommonReportsPage
{
	/**
	 * @var CommonReportsPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('CommonReports', 1);

		$this->presenter = new CommonReportsPresenter($this,
													  ServiceLocator::GetServer()->GetUserSession(),
													  new ReportingService(new ReportingRepository()),
													  new UserRepository());
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @return void
	 */
	public function ProcessPageLoad()
	{
        $this->Set('DateAxisFormat', Resources::GetInstance()->GetDateFormat('report_date'));
        $this->Display('Reports/common-reports.tpl');
	}

	public function BindReport(IReport $report, IReportDefinition $definition, $selectedColumns)
	{
		$this->Set('HideSave', true);
		$this->Set('Definition', $definition);
		$this->Set('Report', $report);
		$this->Set('SelectedColumns', $selectedColumns);
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

	/**
	 * @return int
	 */
	public function GetReportId()
	{
		return $this->GetQuerystring(QueryStringKeys::REPORT_ID);
	}

	/**
	 * @param string $emailAddress
	 */
	public function SetEmailAddress($emailAddress)
	{
		$this->Set('UserEmail', $emailAddress);
	}

	/**
	 * @return string
	 */
	public function GetEmailAddress()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function GetSelectedColumns()
	{
		return $this->GetForm(FormKeys::SELECTED_COLUMNS);
	}

}

