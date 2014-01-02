<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IAuthenticationPage
{
	/**
	 * @return string
	 */
	public function GetEmailAddress();

	/**
	 * @return string
	 */
	public function GetPassword();

	/**
	 * @return void
	 */
	public function SetShowLoginError();
}

interface IAuthentication extends IAuthenticationPromptOptions
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
	 * @return UserSession
	 */
	public function Login($username, $loginContext);

	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user);

	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();

	/**
	 * @param IAuthenticationPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(IAuthenticationPage $loginPage);
}

interface IAuthenticationPromptOptions
{
	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowUsernamePrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPasswordPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPersistLoginPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowForgotPasswordPrompt();
}

?>