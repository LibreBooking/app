<?php
/**
Copyright 2011-2012 Nick Korbel

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

class UserSession
{
	public $UserId = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $Timezone = '';
	public $HomepageId = 1;
	public $SessionToken = '';
	public $IsAdmin = false;
	public $IsGroupAdmin = false;
	public $IsResourceAdmin = false;

	public function __construct($id)
	{
		$this->UserId = $id;
		$this->SessionToken = uniqid();
	}
	
	public function IsLoggedIn()
	{
		return true;
	}
}

class NullUserSession extends UserSession
{
	public function __construct()
	{
		parent::__construct(0);
		$this->SessionToken = '';
		$this->Timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
	}
	
	public function IsLoggedIn()
	{
		return false;
	}
}
?>