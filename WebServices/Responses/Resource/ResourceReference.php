<?php
/**
Copyright 2014-2020 Nick Korbel

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

class ResourceReference extends RestResponse
{
	/**
	 * @var int
	 */
	public $resourceId;
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var int
	 */
	public $scheduleId;
	/**
	 * @var int
	 */
	public $statusId;
	/**
	 * @var int
	 */
	public $statusReasonId;

	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 */
	public function __construct(IRestServer $server, $resource)
	{
		$this->resourceId = $resource->GetId();
		$this->name = $resource->GetName();
		$this->scheduleId = $resource->GetScheduleId();
		$this->statusId = $resource->GetStatusId();
		$this->statusReasonId = $resource->GetStatusReasonId();

		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $this->resourceId));
		$this->AddService($server, WebServices::GetSchedule, array(WebServiceParams::ScheduleId => $this->scheduleId));
	}

	public static function Example()
{
	return new ExampleResourceReference();
}
}

class ExampleResourceReference extends ResourceReference
{
	public function __construct(){
		$this->resourceId = 1;
		$this->name = 'resource name';
		$this->scheduleId = 2;
		$this->statusId = ResourceStatus::AVAILABLE;
		$this->statusReasonId = 123;

		$this->AddServiceLink(new RestServiceLink('http://get-resource-url', WebServices::GetResource));
		$this->AddServiceLink(new RestServiceLink('http://get-schedule-url', WebServices::GetSchedule));
	}
}