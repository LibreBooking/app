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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceStatusReasonsResponse extends RestResponse
{
	public $reasons = array();

	/**
	 * @param IRestServer $server
	 * @param ResourceStatusReason[] $reasons
	 */
	public function __construct(IRestServer $server, $reasons)
	{
		foreach($reasons as $reason)
		{
			$this->AddReason($reason->Id(), $reason->Description(), $reason->StatusId());
		}
	}

	protected function AddReason($id, $description, $statusId)
	{
		$this->reasons[] = array('id' => $id, 'description' => $description, 'statusId' => $statusId);
	}

	public static function Example()
	{
		return new ExampleResourceStatusReasonsResponse();
	}
}

class ExampleResourceStatusReasonsResponse extends ResourceStatusReasonsResponse
{
	public function __construct()
	{
		$this->AddReason(1, 'reason description', ResourceStatus::UNAVAILABLE);
	}
}