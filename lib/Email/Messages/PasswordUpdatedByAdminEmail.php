<?php
/**
 * Copyright 2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class PasswordUpdatedByAdminEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var string
	 */
	private $password;

	public function __construct(User $user, string $password)
	{
		$this->user = $user;
		$this->password = $password;
		parent::__construct($user->Language());
	}

	public function To()
	{
		return new EmailAddress($this->user->EmailAddress(), $this->user->FullName());
	}

	public function Subject()
	{
		$this->Translate('PasswordUpdatedByAdminSubject', array(Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE)));
	}

	public function Body()
	{
		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('NewPassword', $this->password);
		$this->Set('AppTitle',Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE));
		return $this->FetchTemplate('PasswordUpdatedByAdminEmail.tpl');
	}
}
