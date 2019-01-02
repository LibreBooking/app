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
require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'Pages/Reports/IDisplayableReportPage.php');
require_once(ROOT_DIR . 'Presenters/Reports/SavedReportsPresenter.php');
require_once(ROOT_DIR . 'Presenters/Reports/ReportCsvColumnView.php');

interface ISavedReportsPage extends IDisplayableReportPage, IActionPage
{
	/**
	 * @param SavedReport[] $reportList
	 */
	public function BindReportList($reportList);

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

class SavedReportsPage extends ActionPage implements ISavedReportsPage
{
	private $presenter;

	public function __construct()
	{
		parent::__construct('MySavedReports', 1);

		$this->presenter = new SavedReportsPresenter($this,
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
		$this->Set('untitled', Resources::GetInstance()->GetString('NoTitleLabel'));

		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array(
										  'none' => array('key' => 'Never', 'everyKey' => ''),
										  'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
										  'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
										  'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
										  'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								  )
		);
		$this->Set('DayNames', array(
									 0 => 'DaySundayAbbr',
									 1 => 'DayMondayAbbr',
									 2 => 'DayTuesdayAbbr',
									 3 => 'DayWednesdayAbbr',
									 4 => 'DayThursdayAbbr',
									 5 => 'DayFridayAbbr',
									 6 => 'DaySaturdayAbbr',
							 )
		);

        $this->Set('DateAxisFormat', Resources::GetInstance()->GetDateFormat('report_date'));
        $this->presenter->PageLoad();
		$this->Display('Reports/saved-reports.tpl');
	}

	public function BindReportList($reportList)
	{
		$this->Set('ReportList', $reportList);
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

	public function GetReportId()
	{
		return $this->GetQuerystring(QueryStringKeys::REPORT_ID);
	}

	public function SetEmailAddress($emailAddress)
	{
		$this->Set('UserEmail', $emailAddress);
	}

	public function GetEmailAddress()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function GetSelectedColumns()
	{
		return $this->GetForm(FormKeys::SELECTED_COLUMNS);
	}
}

