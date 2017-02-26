<?php
/**
Copyright 2012-2017 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReportEmailMessage.php');
require_once(ROOT_DIR . 'Domain/Access/ReportingRepository.php');

interface IReportingService
{
	/**
	 * @abstract
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 * @return IReport
	 */
	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

	/**
	 * @abstract
	 * @param string $reportName
	 * @param int $userId
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 */
	public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

	/**
	 * @abstract
	 * @param int $userId
	 * @return array|SavedReport[]
	 */
	public function GetSavedReports($userId);

	/**
	 * @abstract
	 * @param int $reportId
	 * @param int $userId
	 * @return IGeneratedSavedReport
	 */
	public function GenerateSavedReport($reportId, $userId);

	/**
	 * @param IGeneratedSavedReport $report
	 * @param IReportDefinition $definition
	 * @param string $toAddress
	 * @param UserSession $reportUser
	 * @param string $selectedColumns
	 */
	public function SendReport($report, $definition, $toAddress, $reportUser, $selectedColumns);

	/**
	 * @abstract
	 * @param int $reportId
	 * @param int $userId
	 */
	public function DeleteSavedReport($reportId, $userId);

	/**
	 * @abstract
	 * @param ICannedReport $cannedReport
	 * @return IReport
	 */
	public function GenerateCommonReport(ICannedReport $cannedReport);
}


class ReportingService implements IReportingService
{
	/**
	 * @var IReportingRepository
	 */
	private $repository;

	/**
	 * @var IAttributeRepository
	 */
	private $attributeRepository;

	/**
	 * @param IReportingRepository $repository
	 * @param IAttributeRepository|null $attributeRepository
	 */
	public function __construct(IReportingRepository $repository, $attributeRepository = null)
	{
		$this->repository = $repository;

		if ($attributeRepository == null)
		{
			$this->attributeRepository = new AttributeRepository();
		}
		else
		{
			$this->attributeRepository = $attributeRepository;
		}
	}

	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$builder = new ReportCommandBuilder();

		$selection->Add($builder);
		if ($selection->Equals(Report_ResultSelection::FULL_LIST))
		{
			$usage->Add($builder);
		}
		$groupBy->Add($builder);
		$range->Add($builder);
		$filter->Add($builder);

		$data = $this->repository->GetCustomReport($builder);
		return new CustomReport($data, $this->attributeRepository);
	}

	public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$report = new SavedReport($reportName, $userId, $usage, $selection, $groupBy, $range, $filter);
		$this->repository->SaveCustomReport($report);
	}

	public function GetSavedReports($userId)
	{
		return $this->repository->LoadSavedReportsForUser($userId);
	}

	public function GenerateSavedReport($reportId, $userId)
	{
		$savedReport = $this->repository->LoadSavedReportForUser($reportId, $userId);

		if ($savedReport == null)
		{
			return null;
		}

		$report = $this->GenerateCustomReport($savedReport->Usage(), $savedReport->Selection(), $savedReport->GroupBy(), $savedReport->Range(), $savedReport->Filter());

		return new GeneratedSavedReport($savedReport, $report);
	}

	public function SendReport($report, $definition, $toAddress, $reportUser, $selectedColumns)
	{
		$message = new ReportEmailMessage($report, $definition, $toAddress, $reportUser, $selectedColumns);
		ServiceLocator::GetEmailService()->Send($message);
	}

	public function DeleteSavedReport($reportId, $userId)
	{
		$this->repository->DeleteSavedReport($reportId, $userId);
	}

	public function GenerateCommonReport(ICannedReport $cannedReport)
	{
		$data = $this->repository->GetCustomReport($cannedReport->GetBuilder());
		return new CustomReport($data, $this->attributeRepository);
	}
}