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

class UserUpdatedResponse extends RestResponse
{
	public $userId;

	public function __construct(IRestServer $server, $userId)
	{
		$this->userId = $userId;
		$this->AddService($server, WebServices::GetUser, array(WebServiceParams::UserId => $userId));
		$this->AddService($server, WebServices::UpdateUser, array(WebServiceParams::UserId => $userId));
	}

	public static function Example()
	{
		return new ExampleUserUpdatedResponse();
	}
}

class ExampleUserUpdatedResponse extends UserCreatedResponse
{
	public function __construct()
	{
		$this->AddLink('http://url/to/user', WebServices::GetUser);
		$this->AddLink('http://url/to/update/user', WebServices::UpdateUser);
	}
}