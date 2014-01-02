<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class PostRegistration implements IPostRegistration
{
	/**
	 * @var IWebAuthentication
	 */
	protected $authentication;

	/**
	 * @var IAccountActivation
	 */
	protected $activation;

	public function __construct(IWebAuthentication $authentication, IAccountActivation $activation)
	{
		$this->authentication = $authentication;
		$this->activation = $activation;
	}

	public function HandleSelfRegistration(User $user, IRegistrationPage $page, ILoginContext $loginContext)
	{
		if ($user->StatusId() == AccountStatus::ACTIVE)
		{
			Log::Debug('PostRegistration - Handling activate user %s', $user->EmailAddress());
			$this->authentication->Login($user->EmailAddress(), $loginContext);
			$page->Redirect(Pages::UrlFromId($user->Homepage()));
		}
		else
		{
			Log::Debug('PostRegistration - Handling pending user %s', $user->EmailAddress());
			$this->activation->Notify($user);
			$page->Redirect(Pages::ACTIVATION);
		}
	}
}
?>