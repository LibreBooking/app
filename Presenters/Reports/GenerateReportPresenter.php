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
	 * @param IGenerateReportPage $page
	 * @param UserSession $user
	 * @param IReportingService $reportingService
	 */
	public function __construct(IGenerateReportPage $page, UserSession $user, IReportingService $reportingService)
	{
		$this->page = $page;
		$this->user = $user;
		$this->reportingService = $reportingService;
	}

	public function ProcessAction()
	{
		$this->GenerateCustomReport();
	}

	public function GenerateCustomReport()
	{
		$usage = new Report_Usage($this->page->GetUsage());
		$selection = new Report_ResultSelection($this->page->GetResultSelection());
		$groupBy = new Report_GroupBy($this->page->GetGroupBy());
		$start = Date::Parse($this->page->GetStart(), $this->user->Timezone);
		$end = Date::Parse($this->page->GetEnd(), $this->user->Timezone);
		$range = new Report_Range($this->page->GetRange(), $start, $end);
		$filter = new Report_Filter($this->page->GetResourceId(), $this->page->GetScheduleId(), $this->page->GetUserId(), $this->page->GetGroupId());


		$report = $this->reportingService->GenerateCustomReport($usage, $selection, $groupBy, $range, $filter);
		$reportDefinition = new ReportDefinition($report, $this->user->Timezone);
		$this->page->BindReport($report, $reportDefinition);
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