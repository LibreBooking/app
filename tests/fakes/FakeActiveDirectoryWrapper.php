<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'plugins/Authentication/ActiveDirectory/IActiveDirectory.php');

class FakeActiveDirectoryWrapper implements IActiveDirectory
{
	public $_ExpectedConnect = true;
	public $_ConnectCalled = true;

	public $_ExpectedAuthenticate = true;
	public $_AuthenticateCalled = false;
	public $_LastUsername;
	public $_LastPassword;

	public $_GetLdapUserCalled = false;
	public $_ExpectedLdapUser;

	public function Connect()
	{
		$this->_ConnectCalled = true;
		return $this->_ExpectedConnect;
	}

	public function Authenticate($username, $password)
	{
		$this->_AuthenticateCalled = true;
		$this->_LastUsername = $username;
		$this->_LastPassword = $password;

		return $this->_ExpectedAuthenticate;
	}

	public function GetLdapUser($username)
	{
		$this->_GetLdapUserCalled = true;

		return $this->_ExpectedLdapUser;
	}
}

?>