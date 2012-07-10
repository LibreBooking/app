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

		$this->page->BindReport($report);
	}
}

?>