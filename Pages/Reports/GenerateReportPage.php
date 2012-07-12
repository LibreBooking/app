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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Reports/GenerateReportPresenter.php');

interface IGenerateReportPage
{
	/**
	 * @abstract
	 * @return string|Report_Usage
	 */
	public function GetUsage();

	/**
	 * @abstract
	 * @return string|Report_ResultSelection
	 */
	public function GetResultSelection();

	/**
	 * @abstract
	 * @return string|Report_GroupBy
	 */
	public function GetGroupBy();

	/**
	 * @abstract
	 * @return string|Report_Range
	 */
	public function GetRange();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetStart();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetEnd();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetAccessoryId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetGroupId();

	public function BindReport(IReport $report, IReportDefinition $definition);

	/**
	 * @abstract
	 * @param array|BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param array|AccessoryDto[] $accessories
	 */
	public function BindAccessories($accessories);

	/**
	 * @abstract
	 * @param array|Schedule[] $schedules
	 */
	public function BindSchedules($schedules);

	public function DisplayError();
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
			new ScheduleRepository());
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
		// TODO: Implement ProcessDataRequest() method.
	}

	/**
	 * @return void
	 */
	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('Reports/generate-report.tpl');
	}

	/**
	 * @return string|Report_Usage
	 */
	public function GetUsage()
	{
		return $this->GetForm(FormKeys::REPORT_USAGE);
	}

	/**
	 * @return string|Report_ResultSelection
	 */
	public function GetResultSelection()
	{
		return $this->GetForm(FormKeys::REPORT_RESULTS);
	}

	/**
	 * @return string|Report_GroupBy
	 */
	public function GetGroupBy()
	{
		return $this->GetForm(FormKeys::REPORT_GROUPBY);
	}

	/**
	 * @return string|Report_Range
	 */
	public function GetRange()
	{
		return $this->GetForm(FormKeys::REPORT_RANGE);
	}

	/**
	 * @return string
	 */
	public function GetStart()
	{
		return $this->GetForm(FormKeys::REPORT_START);
	}

	/**
	 * @return string
	 */
	public function GetEnd()
	{
		return $this->GetForm(FormKeys::REPORT_END);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}

	/**
	 * @return int
	 */
	public function GetUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->GetForm(FormKeys::GROUP_ID);
	}

	public function BindReport(IReport $report, IReportDefinition $definition)
	{
		$this->Set('Definition', $definition);
		$this->Set('Report', $report);
		$this->Display('Reports/results-custom.tpl');
	}

	/**
	 * @param array|BookableResource[] $resources
	 */
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @param array|AccessoryDto[] $accessories
	 */
	public function BindAccessories($accessories)
	{
		$this->Set('Accessories', $accessories);
	}

	/**
	 * @param array|Schedule[] $schedules
	 */
	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	/**
	 * @return int
	 */
	public function GetAccessoryId()
	{
		return $this->GetForm(FormKeys::ACCESSORY_ID);

	}

	public function DisplayError()
	{
		$this->Display('Reports/error.tpl');
	}
}

?>