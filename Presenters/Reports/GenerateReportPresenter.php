<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

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
	 * @param IGenerateReportPage $page
	 * @param UserSession $user
	 * @param IReportingService $reportingService
	 * @param IResourceRepository $resourceRepo
	 * @param IScheduleRepository $scheduleRepo
	 */
	public function __construct(IGenerateReportPage $page, UserSession $user, IReportingService $reportingService, IResourceRepository $resourceRepo, IScheduleRepository $scheduleRepo)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->user = $user;
		$this->reportingService = $reportingService;
		$this->resourceRepo = $resourceRepo;
		$this->scheduleRepo = $scheduleRepo;

		$this->AddAction('customReport', 'GenerateCustomReport');
		$this->AddAction('print', 'PrintReport');
		$this->AddAction('csv', 'ExportToCsv');
		$this->AddAction('save', 'SaveReport');
	}

	public function PageLoad()
	{
		$this->page->BindResources($this->resourceRepo->GetResourceList());
		$this->page->BindAccessories($this->resourceRepo->GetAccessoryList());
		$this->page->BindSchedules($this->scheduleRepo->GetAll());
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
		$start = empty($startString) ? Date::Min() : Date::Parse($startString, $this->user->Timezone);
		$end = empty($endString) ? Date::Max() : Date::Parse($endString, $this->user->Timezone);
		return new Report_Range($this->page->GetRange(), $start, $end);
	}

	/**
	 * @return Report_Filter
	 */
	private function GetFilter()
	{
		return new Report_Filter($this->page->GetResourceId(), $this->page->GetScheduleId(), $this->page->GetUserId(), $this->page->GetGroupId(), $this->page->GetAccessoryId());
	}
}

abstract class ReportColumn
{
	/**
	 * @var string
	 */
	private $titleKey;

	/**
	 * @param $titleKey
	 */
	public function __construct($titleKey)
	{
		$this->titleKey = $titleKey;
	}

	/**
	 * @return string
	 */
	public function TitleKey()
	{
		return $this->titleKey;
	}

	/**
	 * @param $data mixed
	 * @return string
	 */
	public function GetData($data)
	{
		return $data;
	}
}

class ReportStringColumn extends ReportColumn
{
	public function __construct($titleKey)
	{
		parent::__construct($titleKey);
	}
}

class ReportDateColumn extends ReportColumn
{
	private $timezone;
	private $format;

	public function __construct($titleKey, $timezone, $format)
	{
		parent::__construct($titleKey);
		$this->timezone = $timezone;
		$this->format = $format;
	}

	public function GetData($data)
	{
		return Date::FromDatabase($data)->ToTimezone($this->timezone)->Format($this->format);
	}
}

class ReportTimeColumn extends ReportColumn
{
	public function __construct($titleKey)
	{
		parent::__construct($titleKey);
	}

	public function GetData($data)
	{
		return new TimeInterval($data);
	}
}

interface IReportDefinition
{
	/**
	 * @return array|ReportColumn
	 */
	public function GetColumnHeaders();

	/**
	 * @abstract
	 * @param array $row
	 * @return array
	 */
	public function GetRow($row);
}

class ReportDefinition implements IReportDefinition
{
	/**
	 * @var array|ReportColumn[]
	 */
	private $columns = array();

	public function __construct(IReport $report, $timezone)
	{
		$dateFormat = Resources::GetInstance()->GeneralDateTimeFormat();
		$orderedColumns = array(
			ColumnNames::ACCESSORY_NAME => new ReportStringColumn('Accessory'),
			ColumnNames::RESOURCE_NAME_ALIAS => new ReportStringColumn('Resource'),
			ColumnNames::TOTAL => new ReportStringColumn('Total'),
			ColumnNames::TOTAL_TIME => new ReportTimeColumn('Total'),
			ColumnNames::QUANTITY => new ReportStringColumn('QuantityReserved'),
			ColumnNames::RESERVATION_START => new ReportDateColumn('BeginDate', $timezone, $dateFormat),
			ColumnNames::RESERVATION_END => new ReportDateColumn('EndDate', $timezone, $dateFormat),
			ColumnNames::RESERVATION_TITLE => new ReportStringColumn('Title'),
			ColumnNames::RESERVATION_DESCRIPTION => new ReportStringColumn('Description'),
			ColumnNames::REFERENCE_NUMBER => new ReportStringColumn('ReferenceNumber'),
			ColumnNames::OWNER_FIRST_NAME => new ReportStringColumn('FirstName'),
			ColumnNames::OWNER_LAST_NAME => new ReportStringColumn('LastName'),
			ColumnNames::GROUP_NAME_ALIAS => new ReportStringColumn('Group'),
			ColumnNames::SCHEDULE_NAME_ALIAS => new ReportStringColumn('Schedule'),
			ColumnNames::RESERVATION_CREATED => new ReportDateColumn('Created', $timezone, $dateFormat),
			ColumnNames::RESERVATION_MODIFIED => new ReportDateColumn('LastModified', $timezone, $dateFormat),
		);

		$reportColumns = $report->GetColumns();

		foreach ($orderedColumns as $key => $column)
		{
			if ($reportColumns->Exists($key))
			{
				$this->columns[$key] = $column;
			}
		}
	}

	public function GetColumnHeaders()
	{
		return $this->columns;
	}

	public function GetRow($row)
	{
		$formattedRow = array();
		foreach ($this->columns as $key => $column)
		{
			$formattedRow[] = $column->GetData($row[$key]);
		}

		return $formattedRow;
	}
}

?>