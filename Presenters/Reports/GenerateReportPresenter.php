<?php
/**
Copyright 2012-2015 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class GenerateReportPresenter extends ActionPresenter
{
	/**
	 * @var IGenerateReportPage
	 */
	private $page;

	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var IReportingService
	 */
	private $reportingService;
	/**
	 * @var IResourceRepository
	 */
	private $resourceRepo;
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepo;
	/**
	 * @var IGroupRepository
	 */
	private $groupRepo;

	/**
	 * @param IGenerateReportPage $page
	 * @param UserSession $user
	 * @param IReportingService $reportingService
	 * @param IResourceRepository $resourceRepo
	 * @param IScheduleRepository $scheduleRepo
	 * @param IGroupViewRepository $groupRepo
	 */
	public function __construct(
		IGenerateReportPage $page,
		UserSession $user,
		IReportingService $reportingService,
		IResourceRepository $resourceRepo,
		IScheduleRepository $scheduleRepo,
		IGroupViewRepository $groupRepo)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->user = $user;
		$this->reportingService = $reportingService;
		$this->resourceRepo = $resourceRepo;
		$this->scheduleRepo = $scheduleRepo;
		$this->groupRepo = $groupRepo;

		$this->AddAction(ReportActions::Generate, 'GenerateCustomReport');
		$this->AddAction(ReportActions::PrintReport, 'PrintReport');
		$this->AddAction(ReportActions::Csv, 'ExportToCsv');
		$this->AddAction(ReportActions::Save, 'SaveReport');
	}

	public function PageLoad()
	{
		$this->page->BindResources($this->resourceRepo->GetResourceList());
		$this->page->BindAccessories($this->resourceRepo->GetAccessoryList());
		$this->page->BindSchedules($this->scheduleRepo->GetAll());
		$this->page->BindGroups($this->groupRepo->GetList()->Results());
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

	public function PrintReport()
	{
		$this->BindReport();
		$this->page->PrintReport();
	}

	public function GenerateCustomReport()
	{
		$this->BindReport();
		$this->page->ShowResults();
	}

	public function ExportToCsv()
	{
		$this->BindReport();
		$this->page->ShowCsv();
	}

	public function SaveReport()
	{
		$reportName = $this->page->GetReportName();
		$usage = $this->GetUsage();
		$selection = $this->GetSelection();
		$groupBy = $this->GetGroupBy();
		$range = $this->GetRange();
		$filter = $this->GetFilter();

		$userId = $this->user->UserId;

		$this->reportingService->Save($reportName, $userId, $usage, $selection, $groupBy, $range, $filter);
	}

	private function BindReport()
	{
		$usage = $this->GetUsage();
		$selection = $this->GetSelection();
		$groupBy = $this->GetGroupBy();
		$range = $this->GetRange();
		$filter = $this->GetFilter();

		$report = $this->reportingService->GenerateCustomReport($usage, $selection, $groupBy, $range, $filter);
		$reportDefinition = new ReportDefinition($report, $this->user->Timezone);

		$this->page->BindReport($report, $reportDefinition);
	}

	/**
	 * @return Report_Usage
	 */
	private function GetUsage()
	{
		return new Report_Usage($this->page->GetUsage());
	}

	/**
	 * @return Report_ResultSelection
	 */
	private function GetSelection()
	{
		return new Report_ResultSelection($this->page->GetResultSelection());
	}

	/**
	 * @return Report_GroupBy
	 */
	private function GetGroupBy()
	{
		return new Report_GroupBy($this->page->GetGroupBy());
	}

	/**
	 * @return Report_Range
	 */
	private function GetRange()
	{
		$startString = $this->page->GetStart();
		$endString = $this->page->GetEnd();

		return new Report_Range($this->page->GetRange(), $startString, $endString, $this->user->Timezone);
	}

	/**
	 * @return Report_Filter
	 */
	private function GetFilter()
	{
		return new Report_Filter($this->page->GetResourceId(), $this->page->GetScheduleId(), $this->page->GetUserId(), $this->page->GetGroupId(), $this->page->GetAccessoryId(), $this->page->GetParticipantId());
	}
}