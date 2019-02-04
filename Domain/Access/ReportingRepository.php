<?php
/**
 * Copyright 2012-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/ReportCommandBuilder.php');
require_once(ROOT_DIR . 'Domain/SavedReport.php');

interface IReportingRepository
{
	/**
	 * @param ReportCommandBuilder $commandBuilder
	 * @return array
	 */
	public function GetCustomReport(ReportCommandBuilder $commandBuilder);

	/**
	 * @param SavedReport $savedReport
	 */
	public function SaveCustomReport(SavedReport $savedReport);

	/**
	 * @param int $userId
	 * @return array|SavedReport[]
	 */
	public function LoadSavedReportsForUser($userId);

	/**
	 * @param int $reportId
	 * @param int $userId
	 * @return SavedReport
	 */
	public function LoadSavedReportForUser($reportId, $userId);

	/**
	 * @param int $reportId
	 * @param int $userId
	 */
	public function DeleteSavedReport($reportId, $userId);
}

class ReportingRepository implements IReportingRepository
{
	/**
	 * @param ReportCommandBuilder $commandBuilder
	 * @return array
	 */
	public function GetCustomReport(ReportCommandBuilder $commandBuilder)
	{
		$query = $commandBuilder->Build();
		$reader = ServiceLocator::GetDatabase()->Query($query);
		$rows = array();
		while ($row = $reader->GetRow())
		{
			$row[ColumnNames::DURATION_HOURS] = round($row[ColumnNames::DURATION_ALIAS] / 3600, 2);
			$rows[] = $row;
		}
		$reader->Free();

		return $rows;
	}

	public function SaveCustomReport(SavedReport $report)
	{
		$serialized = ReportSerializer::Serialize($report);
		ServiceLocator::GetDatabase()->ExecuteInsert(new AddSavedReportCommand($report->ReportName(), $report->OwnerId(), $report->DateCreated(), $serialized));
	}

	/**
	 * @param $userId
	 * @return array|SavedReport[]
	 */
	public function LoadSavedReportsForUser($userId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAllSavedReportsForUserCommand($userId));
		$reports = array();
		while ($row = $reader->GetRow())
		{
			$reports[] = SavedReport::FromDatabase(
					$row[ColumnNames::REPORT_NAME],
					$row[ColumnNames::USER_ID],
					Date::FromDatabase($row[ColumnNames::DATE_CREATED]),
					$row[ColumnNames::REPORT_DETAILS],
					$row[ColumnNames::REPORT_ID]
			);
		}
		$reader->Free();

		return $reports;
	}

	/**
	 * @param int $reportId
	 * @param int $userId
	 * @return SavedReport
	 */
	public function LoadSavedReportForUser($reportId, $userId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetSavedReportForUserCommand($reportId, $userId));

		if ($row = $reader->GetRow())
		{
			$reader->Free();
			return SavedReport::FromDatabase(
					$row[ColumnNames::REPORT_NAME],
					$row[ColumnNames::USER_ID],
					Date::FromDatabase($row[ColumnNames::DATE_CREATED]),
					$row[ColumnNames::REPORT_DETAILS],
					$row[ColumnNames::REPORT_ID]
			);
		}
		$reader->Free();
		return null;
	}

	public function DeleteSavedReport($reportId, $userId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteSavedReportCommand($reportId, $userId));
	}
}