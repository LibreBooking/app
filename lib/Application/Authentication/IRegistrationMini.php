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

interface IRegistrationMini
{
	/**
	 * @param string $login
	 * @param string $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $password unencrypted password
     * @param string $timezone name of timezone
     * @param string $language preferred language code
	 */
  public function RegisterMini($login, $email, $firstName, $lastName, $password, $timezone, $language);
	
	/**
	 * @param string $loginName
	 * @param string $emailAddress
	 * @return bool if the user exists or not
	 */
	public function UserExists($loginName, $emailAddress);
}
?>