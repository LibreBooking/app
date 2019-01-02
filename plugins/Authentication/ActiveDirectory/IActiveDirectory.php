<?php
/**
Copyright 2011-2019 Nick Korbel

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

interface IActiveDirectory
{
	/**
	 * @return bool If connection was successful
	 */
	public function Connect();

	/**
	 * @return bool If authentication was successful
	 */
	public function Authenticate($username, $password);

	/**
	 * @return ActiveDirectoryUser The details for the user
	 */
	public function GetLdapUser($username);
}
?>