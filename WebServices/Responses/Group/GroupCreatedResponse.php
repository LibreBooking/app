<?php

/**
 * Copyright 2018-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class GroupCreatedResponse extends RestResponse
{
	public $groupId;

	public function __construct(IRestServer $server, $groupId)
	{
		$this->message = 'The group was created';
		$this->groupId = $groupId;
		$this->AddService($server, WebServices::GetGroup, array(WebServiceParams::GroupId => $groupId));
		$this->AddService($server, WebServices::UpdateGroup, array(WebServiceParams::GroupId => $groupId));
		$this->AddService($server, WebServices::DeleteGroup, array(WebServiceParams::GroupId => $groupId));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeCreatedResponse();
	}
}

class GroupUpdatedResponse extends RestResponse
{
	public $groupId;

	public function __construct(IRestServer $server, $groupId)
	{
		$this->message = 'The group was updated';
		$this->groupId = $groupId;
        $this->AddService($server, WebServices::GetGroup, array(WebServiceParams::GroupId => $groupId));
        $this->AddService($server, WebServices::UpdateGroup, array(WebServiceParams::GroupId => $groupId));
        $this->AddService($server, WebServices::DeleteGroup, array(WebServiceParams::GroupId => $groupId));
	}

	public static function Example()
	{
		return new ExampleGroupCreatedResponse();
	}
}

class ExampleGroupCreatedResponse extends GroupCreatedResponse
{
	public function __construct()
	{
		$this->groupId = 1;
		$this->AddLink('http://url/to/group', WebServices::GetGroup);
		$this->AddLink('http://url/to/update/group', WebServices::UpdateGroup);
		$this->AddLink('http://url/to/delete/group', WebServices::DeleteGroup);
	}
}
