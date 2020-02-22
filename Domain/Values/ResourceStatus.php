<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ResourceStatus
{
	const HIDDEN = 0;
	const AVAILABLE = 1;
	const UNAVAILABLE = 2;
}

class ResourceStatusReason
{
	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var int|null
	 */
	private $id;

	/**
	 * @var int|ResourceStatus
	 */
	private $statusId;

	/**
	 * @param int|null $id
	 * @param int|ResourceStatus $statusId
	 * @param string|null $description
	 */
	public function __construct($id, $statusId, $description = null)
	{
		$this->description = $description;
		$this->id = $id;
		$this->statusId = $statusId;
	}

	/**
	 * @return int|null
	 */
	public function Id()
	{
		return $this->id;
	}

	/**
	 * @return int|ResourceStatus
	 */
	public function StatusId()
	{
		return $this->statusId;
	}

	/**
	 * @return string
	 */
	public function Description()
	{
		return $this->description;
	}
}