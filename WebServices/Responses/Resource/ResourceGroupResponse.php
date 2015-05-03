<?php
/**
Copyright 2012-2015 Nick Korbel

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

class ResourceGroupResponse extends RestResponse
{
	public $id;
	public $name;
	public $parent_id;
	
	public function __construct(IRestServer $server, $resourcegroup)
	{
		$this->id = $resourcegroup->id;
		$this->name = $resourcegroup->name;
		$this->parent_id = $resourcegroup->parent_id;
		
		// commented this out for now since it is not implemented yet
//		$this->AddService($server, WebServices::GetResourceGroup, array(WebServiceParams::ResourceGroupId => $this->id));
	}

	public static function Example()
	{
		return new ExampleResourceGroupResponse();
	}
}

class ExampleResourceGroupResponse extends ResourceGroupResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'resource group name';
	}
}
?>