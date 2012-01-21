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

interface IAuthentication
{
	/**
	 * @abstract
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);
	
	/**
	 * @abstract
	 * @param string $username
	 * @param ILoginContext $loginContext
	 * @return void
	 */
	public function Login($username, $loginContext);
	
	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user);
	
	/**
	 * @param string $cookieValue phpScheduleIt authentication cookie value
	 * @param ILoginContext $loginContext
	 * @return void
	 */
	public function CookieLogin($cookieValue, $loginContext);
	
	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();
	
	/**
	 * @param ILoginPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(ILoginPage $loginPage);
}
?>