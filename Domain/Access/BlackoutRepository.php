<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Blackout.php');

interface IBlackoutRepository
{
	/**
	 * @param BlackoutSeries $blackoutSeries
	 * @return int
	 */
	public function Add(BlackoutSeries $blackoutSeries);

    /**
     * @param int $blackoutId
     */
    public function Delete($blackoutId);

	/**
     * @param int $blackoutId
     */
    public function DeleteSeries($blackoutId);

	/**
	 * @param int $blackoutId
	 * @return BlackoutSeries
	 */
	public function LoadByBlackoutId($blackoutId);
}

class BlackoutRepository implements IBlackoutRepository
{
	/**
	 * @param BlackoutSeries $blackoutSeries
	 * @return int
	 */
	public function Add(BlackoutSeries $blackoutSeries)
	{
		$db = ServiceLocator::GetDatabase();
		$seriesId = $db->ExecuteInsert(new AddBlackoutCommand($blackoutSeries->OwnerId(), $blackoutSeries->Title(), $blackoutSeries->RepeatType(), $blackoutSeries->RepeatConfiguration()));

		foreach ($blackoutSeries->ResourceIds() as $resourceId)
		{
			$db->ExecuteInsert(new AddBlackoutResourceCommand($seriesId, $resourceId));
		}
		foreach ($blackoutSeries->AllBlackouts() as $blackout)
		{
			$db->ExecuteInsert(new AddBlackoutInstanceCommand($seriesId, $blackout->StartDate(), $blackout->EndDate()));
		}

		return $seriesId;
	}

    /**
     * @param int $blackoutId
     */
    public function Delete($blackoutId)
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteBlackoutInstanceCommand($blackoutId));
    }

	/**
     * @param int $blackoutId
     */
    public function DeleteSeries($blackoutId)
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteBlackoutSeriesCommand($blackoutId));
    }

	/**
	 * @param int $blackoutId
	 * @return BlackoutSeries
	 */
	public function LoadByBlackoutId($blackoutId)
	{
		$db = ServiceLocator::GetDatabase();
		$result = $db->Query(new GetBlackoutSeriesByBlackoutIdCommand($blackoutId));

		if ($row = $result->GetRow())
		{
			$series = BlackoutSeries::FromRow($row);

			$result = $db->Query(new GetBlackoutInstancesCommand($series->Id()));

			while ($row = $result->GetRow())
			{
				$series->AddBlackout(new Blackout(new DateRange(Date::FromDatabase($row[ColumnNames::BLACKOUT_START]), Date::FromDatabase($row[ColumnNames::BLACKOUT_END]))));
			}

			$result = $db->Query(new GetBlackoutResourcesCommand($series->Id()));

			while ($row = $result->GetRow())
			{
				$series->AddResource(new BlackoutResource(
										 $row[ColumnNames::RESOURCE_ID],
										 $row[ColumnNames::RESOURCE_NAME],
										 $row[ColumnNames::SCHEDULE_ID],
										 $row[ColumnNames::RESOURCE_ADMIN_GROUP_ID],
										 $row[ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS]));
			}

			return $series;
		}
		else
		{
			return null;
		}
	}
}
