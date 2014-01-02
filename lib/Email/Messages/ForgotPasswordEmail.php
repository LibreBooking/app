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

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');


class ForgotPasswordEmail extends EmailMessage
{
	/**
	 * @var \User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $temporaryPassword;

	public function __construct(User $user, $temporaryPassword)
	{
		parent::__construct($user->Language());

		$this->user = $user;
		$this->temporaryPassword = $temporaryPassword;
	}

	/**
	 * @return EmailAddress[]
	 */
	function To()
	{
		return new EmailAddress($this->user->EmailAddress(), $this->user->FullName());
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('ResetPassword');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$this->Set('TemporaryPassword', $this->temporaryPassword);
		return $this->FetchTemplate('ResetPassword.tpl');
	}
}

?>