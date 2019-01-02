<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

class AccountDeletedEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $deletedUser;
	/**
	 * @var UserDto
	 */
	private $to;
	/**
	 * @var UserSession
	 */
	private $userSession;

	public function __construct(User $deletedUser, UserDto $to, UserSession $userSession)
	{
		parent::__construct($to->LanguageCode);

		$this->deletedUser = $deletedUser;
		$this->to = $to;
		$this->userSession = $userSession;
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To()
	{
		return new EmailAddress($this->to->EmailAddress(), $this->to->FullName());
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('UserDeleted', array($this->deletedUser->FullName(), new FullName($this->userSession->FirstName, $this->userSession->LastName)));
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$this->Set('UserFullName', $this->deletedUser->FullName());
		$this->Set('AdminFullName', new FullName($this->userSession->FirstName, $this->userSession->LastName));
		return $this->FetchTemplate('AccountDeleted.tpl');
	}
}