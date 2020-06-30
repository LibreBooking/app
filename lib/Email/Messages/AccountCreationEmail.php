<?php
/**
 * Copyright 2012-2014-13 Nick Korbel, Paul Menchini
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class AccountCreationEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var null|UserSession
	 */
	private $userSession;

	public function __construct(User $user, $userSession = null)
	{
		$this->user = $user;
		$this->userSession = $userSession;
		parent::__construct(Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE));
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To()
	{
		$userRepo = new UserRepository();
		$admins = $userRepo->GetApplicationAdmins();
		$emails = [];
		foreach ($admins as $admin) {
			$emails[] = new EmailAddress($admin->EmailAddress, $admin->FullName);
		}
		return $emails;
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('UserAdded');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$this->Set('To', Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) ? Configuration::Instance()
																										->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) : 'Administrator');
		$this->Set('FullName', $this->user->FullName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('Phone', $this->user->GetAttribute(UserAttribute::Phone));
		$this->Set('Organization', $this->user->GetAttribute(UserAttribute::Organization));
		$this->Set('Position', $this->user->GetAttribute(UserAttribute::Position));

		$this->Set('CreatedBy', '');
		if ($this->userSession != null && $this->userSession->UserId != $this->user->Id())
		{
			$this->Set('CreatedBy', new FullName($this->userSession->FirstName, $this->userSession->LastName));
		}

		return $this->FetchTemplate('AccountCreation.tpl');
	}
}