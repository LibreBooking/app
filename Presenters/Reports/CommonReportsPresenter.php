<?php
/**
Copyright 2012-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Reports/ReportActions.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Reports/CommonReportsPage.php');
require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class CommonReportsPresenter extends ActionPresenter
{
	/**
	 * @var IReportingService
	 */
	private $service;
	/**
	 * @var UserSession
	 */
	private $user;
	/**
	 * @var ICommonReportsPage
	 */
	private $page;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(ICommonReportsPage $page, UserSession $user, IReportingService $service, IUserRepository $userRepository)
	{
		parent::__construct($page);

		$this->service = $service;
		$this->user = $user;
		$this->page = $page;
		$this->userRepository = $userRepository;

		$this->AddAction(ReportActions::Generate, 'GenerateReport');
		$this->AddAction(ReportActions::Email, 'EmailReport');
		$this->AddAction(ReportActions::Csv, 'CreateCsv');
		$this->AddAction(ReportActions::PrintReport, 'PrintReport');
		$this->AddAction(ReportActions::Delete, 'DeleteReport');
		$this->AddAction(ReportActions::SaveColumns, 'SaveColumns');
	}

	public function PageLoad()
	{
		//$this->page->BindReport($report, new ReportDefinition($report, $this->user->Timezone));
	}

	public function ProcessAction()
	{
		try
		{
			parent::ProcessAction();
		}
		catch (Exception $ex)
		{
			Log::Error('Error getting report: %s', $ex);
			$this->page->DisplayError();
		}
	}

	private function GenerateAndDisplay($callback)
	{
		$reportId = $this->page->GetReportId();
		$userId = $this->user->UserId;
		$report = $this->service->GenerateCommonReport(new CannedReport($reportId, $this->user));

		if ($report != null)
		{
			Log::Debug('Loading saved report for userId: %s, reportId %s', $userId, $reportId);
			$user = $this->userRepository->LoadById($userId);
			$this->page->BindReport($report, new ReportDefinition($report, $this->user->Timezone), $user->GetPreference(UserPreferences::REPORT_COLUMNS));
			call_user_func($callback);
		}
		else
		{
			Log::Debug('Report not found for userId: %s, reportId %s', $userId, $reportId);
			$this->page->DisplayError();
		}
	}

	public function GenerateReport()
	{
		$this->GenerateAndDisplay(array($this->page, 'ShowResults'));
	}

	public function CreateCsv()
	{
		$this->GenerateAndDisplay(array($this->page, 'ShowCsv'));
	}

	public function PrintReport()
	{
		$this->GenerateAndDisplay(array($this->page, 'PrintReport'));
	}

	public function EmailReport()
	{
		$reportId = $this->page->GetReportId();
		$userId = $this->user->UserId;
		$report = $this->service->GenerateSavedReport($reportId, $userId, $this->user->Timezone);

		if ($report != null)
		{
			Log::Debug('Loading saved report for userId: %s, reportId %s', $userId, $reportId);

			$user = $this->userRepository->LoadById($userId);
			$this->service->SendReport($report, new ReportDefinition($report, $this->user->Timezone), $this->page->GetEmailAddress(), $this->user, $user->GetPreference(UserPreferences::REPORT_COLUMNS));
		}
	}

	public function DeleteReport()
	{
		$reportId = $this->page->GetReportId();
		$userId = $this->user->UserId;

		Log::Debug('Deleting saved report. reportId: %s, userId: %s', $reportId, $userId);
		$this->service->DeleteSavedReport($reportId, $userId);
	}

	public function SaveColumns()
	{
		$user = $this->userRepository->LoadById($this->user->UserId);
		$user->ChangePreference(UserPreferences::REPORT_COLUMNS, $this->page->GetSelectedColumns());
		$this->userRepository->Update($user);
	}
}

