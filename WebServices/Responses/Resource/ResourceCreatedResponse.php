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

class ResourceCreatedResponse extends RestResponse
{
	public $resourceId;

	public function __construct(IRestServer $server, $resourceId)
	{
		$this->resourceId = $resourceId;
		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
		$this->AddService($server, WebServices::UpdateResource, array(WebServiceParams::ResourceId => $resourceId));
	}

	public static function Example()
	{
		return new ExampleResourceCreatedResponse();
	}
}

class ExampleResourceCreatedResponse extends ResourceCreatedResponse
{
	public function __construct()
	{
		$this->resourceId = 1;
		$this->AddLink('http://url/to/resource', WebServices::GetResource);
		$this->AddLink('http://url/to/update/resource', WebServices::UpdateResource);
	}
}

