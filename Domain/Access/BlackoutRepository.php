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
}
