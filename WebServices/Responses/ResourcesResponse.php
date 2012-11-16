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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourcesResponse extends RestResponse
{
	/**
	 * @var array|ResourceResponse[]
	 */
	public $resources;

	public function __construct()
	{
	}

	/**
	 * @param IRestServer $server
	 * @param array|BookableResource[] $resources
	 * @param IEntityAttributeList $attributes
	 * @return ResourcesResponse
	 */
	public static function Create($server = null, $resources = null, $attributes = null)
	{
		$r = new ResourcesResponse();
		foreach ($resources as $resource)
		{
			$r->resources[] = ResourceResponse::Create($server, $resource, $attributes);
		}

		return $r;
	}
}

?>