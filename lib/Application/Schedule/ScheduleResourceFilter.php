<?php
/**
Copyright 2013 Nick Korbel

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

interface IScheduleResourceFilter
{
	/**
	 * @param BookableResource[] $resources
	 * @return int[] filtered resource ids
	 */
	public function FilterResources($resources);
}

class ScheduleResourceFilter implements IScheduleResourceFilter
{
	public $ScheduleId;
	public $ResourceId;
	public $GroupId;
	public $ResourceTypeId;
	public $MaxParticipants;

	public function __construct($scheduleId = null,
								$resourceTypeId = null,
								$maxParticipants = null,
								$resourceAttributes = null,
								$resourceTypeAttributes = null)
	{
		$this->ScheduleId = $scheduleId;
		$this->ResourceTypeId = $resourceTypeId;
		$this->MaxParticipants = empty($maxParticipants) ? null : $maxParticipants;
	}

	public static function FromCookie($val)
	{
		return new ScheduleResourceFilter($val->ScheduleId, $val->ResourceId, $val->ResourceTypeId, $val->MaxParticipants);
	}

	/**
	 * @param BookableResource[] $resources
	 * @return int[] filtered resource ids
	 */
	public function FilterResources($resources)
	{
		$ids = array();
		foreach($resources as $resource)
		{
			$ids[] = $resource->GetId();
		}

		return $ids;
	}
}

?>