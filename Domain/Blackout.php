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


class Blackout
{
	/**
	 * @var int
	 */
	protected $ownerId;

	/**
	 * @var int
	 */
	protected $resourceId;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var DateRange
	 */
	protected $date;

	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param DateRange $blackoutDate
	 */
	protected function __construct($userId, $resourceId, $title, $blackoutDate)
	{
		$this->ownerId = $userId;
		$this->resourceId = $resourceId;
		$this->title = $title;
		$this->date = $blackoutDate;
	}

	/**
	 * @static
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param DateRange $blackoutDate
	 * @return Blackout
	 */
	public static function Create($userId, $resourceId, $title, $blackoutDate)
	{
		return new Blackout($userId, $resourceId, $title, $blackoutDate);
	}

	/**
	 * @return DateRange
	 */
	public function Date()
	{
		return $this->date;
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->date->GetBegin();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->date->GetEnd();
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->resourceId;
	}

	/**
	 * @return int
	 */
	public function OwnerId()
	{
		return $this->ownerId;
	}

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->title;
	}
}
?>