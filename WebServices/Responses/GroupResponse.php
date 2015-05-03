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

class GroupResponse extends RestResponse
{
	public $id;
	public $name;
	public $adminGroup;
	public $permissions = array();
	public $users = array();
	public $roles = array();

	public function __construct(IRestServer $server, Group $group)
	{
		$this->id = $group->Id();
		$this->name = $group->Name();
		$this->adminGroup = $server->GetServiceUrl(WebServices::GetGroup, array(WebServiceParams::GroupId => $group->AdminGroupId()));

		foreach ($group->AllowedResourceIds() as $resourceId)
		{
			$this->permissions[] = $server->GetServiceUrl(WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
		}

		foreach ($group->UserIds() as $userId)
		{
			$this->users[] = $server->GetServiceUrl(WebServices::GetUser, array(WebServiceParams::UserId => $userId));
		}

		foreach ($group->RoleIds() as $roleId)
		{
			$this->roles[] = $roleId;
		}
	}

	public static function Example()
	{
		return new ExampleGroupResponse();
	}
}

class ExampleGroupResponse extends GroupResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'group name';
		$this->adminGroup = 'http://url/to/group';
		$this->permissions = array('http://url/to/resource');
		$this->users = array('http://url/to/user');
		$this->roles = array(1,2);
	}
}

?>