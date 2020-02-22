<?php
/**
 * Copyright 2020 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/BlackoutRepository.php');

class FakeBlackoutRepository implements IBlackoutRepository
{
	/**
	 * @var BlackoutSeries
	 */
	public $_Added;
	/**
	 * @var BlackoutSeries
	 */
	public $_Updated;
	/**
	 * @var int
	 */
	public $_DeletedId;
	/**
	 * @var int
	 */
	public $_DeletedSeriesId;
	/**
	 * @var BlackoutSeries
	 */
	public $_Series;
	/**
	 * @var int
	 */
	public $_LoadedBlackoutId;

	/**
	 * @inheritDoc
	 */
	public function Add(BlackoutSeries $blackoutSeries)
	{
		$this->_Added = $blackoutSeries;
	}

	/**
	 * @inheritDoc
	 */
	public function Update(BlackoutSeries $blackoutSeries)
	{
		$this->_Updated = $blackoutSeries;
	}

	/**
	 * @inheritDoc
	 */
	public function Delete($blackoutId)
	{
		$this->_DeletedId = $blackoutId;
	}

	/**
	 * @inheritDoc
	 */
	public function DeleteSeries($blackoutId)
	{
		$this->_DeletedSeriesId = $blackoutId;
	}

	/**
	 * @inheritDoc
	 */
	public function LoadByBlackoutId($blackoutId)
	{
		$this->_LoadedBlackoutId = $blackoutId;
		return $this->_Series;
	}
}
