<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Reports/ReportCsvColumnView.php');

class ReportEmailMessage extends EmailMessage
{
	/**
	 * @var string
	 */
	private $to;
	/**
	 * @var UserSession
	 */
	private $reportUser;

	private $name = 'untitled-report';

	/**
	 * @param IGeneratedSavedReport $report
	 * @param IReportDefinition $definition
	 * @param string $toAddress
	 * @param UserSession $reportUser
	 * @param string $selectedColumns
	 */
	public function __construct($report, $definition, $toAddress, $reportUser, $selectedColumns)
	{
		parent::__construct($reportUser->LanguageCode);

		$this->to = $toAddress;
		$this->reportUser = $reportUser;

		$this->Set('Definition', $definition);
		$this->Set('Report', $report);
		$this->Set('ReportCsvColumnView', new ReportCsvColumnView($selectedColumns));
		$contents = $this->FetchTemplate('Reports/custom-csv.tpl', false);

		$name = $report->ReportName();
		if (!empty($name))
		{
			$this->name = $name;
		}
		$this->AddStringAttachment($contents, "{$this->name}.csv");

	}

	public function From()
	{
		return new EmailAddress($this->reportUser->Email);
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	public function To()
	{
		return new EmailAddress($this->to);
	}

	/**
	 * @return string
	 */
	public function Subject()
	{
		return $this->Translate('ReportSubject', $this->name);
	}

	/**
	 * @return string
	 */
	public function Body()
	{
		return $this->FetchTemplate('ReportEmail.tpl');
	}
}