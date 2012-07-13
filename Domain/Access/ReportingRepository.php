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

require_once(ROOT_DIR . 'Domain/Access/ReportCommandBuilder.php');
require_once(ROOT_DIR . 'Domain/SavedReport.php');

interface IReportingRepository
{
	/**
	 * @abstract
	 * @param ReportCommandBuilder $commandBuilder
	 * @return array
	 */
	public function GetCustomReport(ReportCommandBuilder $commandBuilder);

	/**
	 * @abstract
	 * @param ReportCommandBuilder $commandBuilder
	 */
	public function SaveCustomReport(SavedReport $commandBuilder);
}

class ReportingRepository implements IReportingRepository
{
	/**
	 * @param ReportCommandBuilder $commandBuilder
	 * @return array
	 */
	public function GetCustomReport(ReportCommandBuilder $commandBuilder)
	{
		$reader = ServiceLocator::GetDatabase()->Query($commandBuilder->Build());
		$rows = array();
		while ($row = $reader->GetRow())
		{
			$rows[] = $row;
		}
		$reader->Free();

		return $rows;
	}

	public function SaveCustomReport(SavedReport $report)
	{
		$template = 'usage=%s;selection=%s;groupby=%s;range=%s;range_start=%s;range_end=%s;resourceid=%s;scheduleid=%s;userid=%s;groupid=%s;accessoryid=%s';

		$serialized = sprintf($template,
							  $report->Usage(),
							  $report->Selection(),
							  $report->GroupBy(),
							  $report->Range(),
							  $report->RangeStart()->ToDatabase(),
							  $report->RangeEnd()->ToDatabase(),
							  $report->ResourceId(),
							  $report->ScheduleId(),
							  $report->UserId(),
							  $report->GroupId(),
							  $report->AccessoryId());


		ServiceLocator::GetDatabase()->ExecuteInsert(new AddSavedReportCommand($report->ReportName(), $report->OwnerId(), $report->DateCreated(), $serialized));
	}
}

?>