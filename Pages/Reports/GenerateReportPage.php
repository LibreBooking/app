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

	public function BindReport(IReport $report);
}

class GenerateReportPage extends Page
{
	public function __construct()
	{
		parent::__construct('Reports', 1);
	}

	public function PageLoad()
	{
		$this->Display('Reports/generate-report.tpl');
	}
}

?>