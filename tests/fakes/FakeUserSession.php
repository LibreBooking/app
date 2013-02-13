<?php
/**
Copyright 2011-2013 Nick Korbel

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

class FakeUserSession extends UserSession 
{
	public function __construct($isAdmin = false, $timezone = 'America/New_York', $userId = 1)
	{
		parent::__construct($userId);
		
		$this->FirstName = 'first';
		$this->LastName = 'last';
		$this->Email = 'first.last@email.com';
		$this->IsAdmin = $isAdmin;
		$this->Timezone = $timezone;
		$this->HomepageId = 1;
		$this->IsGroupAdmin = false;
		$this->IsResourceAdmin = true;
		$this->IsScheduleAdmin = false;
		$this->LanguageCode = 'en_US';
		$this->PublicId = 'public id';
		$this->ScheduleId = 19;
	}
}

class FakeWebServiceUserSession extends WebServiceUserSession
{
	public $_SessionExtended = false;
	public $_IsExpired = false;

	public function __construct($id)
	{
		parent::__construct($id);
		$this->Timezone = 'America/Chicago';
	}

	public function ExtendSession()
	{
		$this->_SessionExtended = true;
	}

	public function IsExpired()
	{
		return $this->_IsExpired;
	}
}
?>