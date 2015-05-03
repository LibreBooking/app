<?php
/**
Copyright 2011-2015 Nick Korbel

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

class UserSession
{
	public $UserId = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $Timezone = '';
	public $HomepageId = 1;
	public $IsAdmin = false;
	public $IsGroupAdmin = false;
	public $IsResourceAdmin = false;
	public $IsScheduleAdmin = false;
	public $LanguageCode = '';
	public $PublicId = '';
	public $LoginTime = '';
	public $ScheduleId = '';
	public $Groups = array();
	public $AdminGroups = array();

	public function __construct($id)
	{
		$this->UserId = $id;
	}

	public function IsLoggedIn()
	{
		return true;
	}

	public function IsAdminForGroup($groupIds = array())
	{
		if (!is_array($groupIds))
		{
			$groupIds = array($groupIds);
		}

		if ($this->IsAdmin)
		{
			return true;
		}

		if (!$this->IsGroupAdmin)
		{
			return false;
		}

		foreach($groupIds as $groupId)
		{
			if (in_array($groupId, $this->AdminGroups))
			{
				return true;
			}
		}

		return false;
	}

	public function __toString()
	{
		return "{$this->FirstName} {$this->LastName} ({$this->Email})";
	}
}

class NullUserSession extends UserSession
{
	public function __construct()
	{
		parent::__construct(0);
		$this->Timezone = Configuration::Instance()->GetDefaultTimezone();
	}

	public function IsLoggedIn()
	{
		return false;
	}
}