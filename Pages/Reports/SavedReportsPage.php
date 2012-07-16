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

require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'Presenters/Reports/SavedReportsPresenter.php');

interface ISavedReportsPage extends IActionPage
{
	/**
	 * @abstract
	 * @param SavedReport[] $reportList
	 */
	public function BindReportList($reportList);
}

class SavedReportsPage extends ActionPage implements ISavedReportsPage
{
	public function __construct()
	{
		parent::__construct('MySavedReports', 1);

		$this->presenter = new SavedReportsPresenter($this, ServiceLocator::GetServer()->GetUserSession(), new ReportingService(new ReportingRepository()));
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		// TODO: Implement ProcessAction() method.
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
		$this->Set('untitled', Resources::GetInstance()->GetString('NoTitleLabel'));
		$this->presenter->PageLoad();
		$this->Display('Reports/saved-reports.tpl');
	}

	/**
	 * @param SavedReport[] $reportList
	 */
	public function BindReportList($reportList)
	{
		$this->Set('ReportList', $reportList);
	}
}

?>