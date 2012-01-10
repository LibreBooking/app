<?php
/**
Copyright 2011-2012 Nick Korbel

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
	 * @abstract
	 * @param Blackout $blackout
	 * @return int
	 */
	public function Add(Blackout $blackout);

    /**
     * @abstract
     * @param int $blackoutId
     */
    public function Delete($blackoutId);
}

class BlackoutRepository implements IBlackoutRepository
{
	/**
	 * @param Blackout $blackout
	 * @return int
	 */
	public function Add(Blackout $blackout)
	{
		$db = ServiceLocator::GetDatabase();
		$seriesId = $db->ExecuteInsert(new AddBlackoutCommand($blackout->OwnerId(), $blackout->ResourceId(), $blackout->Title()));
		return $db->ExecuteInsert(new AddBlackoutInstanceCommand($seriesId, $blackout->StartDate(), $blackout->EndDate()));
	}

    /**
     * @param int $blackoutId
     */
    public function Delete($blackoutId)
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteBlackoutCommand($blackoutId));
    }
}
