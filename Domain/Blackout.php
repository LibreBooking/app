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

class BlackoutSeries
{
	/**
	 * @var int
	 */
	protected $ownerId;

	/**
	 * @var int[]
	 */
	protected $resourceIds;

	/**
	 * @var Blackout[]
	 */
	protected $blackouts;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @param int $userId
	 * @param string $title
	 */
	public function __construct($userId, $title)
	{
		$this->ownerId = $userId;
		$this->title = $title;
	}

	/**
	 * @return int
	 */
	public function ResourceIds()
	{
		return $this->resourceIds;
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

	/**
	 * @param $resourceId int
	 */
	public function AddResource($resourceId)
	{
		$this->resourceIds[] = $resourceId;
	}

	public function AddBlackout(Blackout $blackout)
	{
		$this->blackouts[] = $blackout;
	}

	/**
	 * @return Blackout[]
	 */
	public function AllBlackouts()
	{
		return $this->blackouts;
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->resourceIds[0];
	}

	/**
	 * @param int $resourceId
	 * @return bool
	 */
	public function ContainsResource($resourceId)
	{
		return in_array($resourceId, $this->resourceIds);
	}
}

class Blackout
{

	/**
	 * @var DateRange
	 */
	protected $date;

	/**
	 * @param DateRange $blackoutDate
	 */
	public function __construct($blackoutDate)
	{
		$this->date = $blackoutDate;
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


}

?>