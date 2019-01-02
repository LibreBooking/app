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

class InviteUserEmail extends EmailMessage
{
	/**
	 * @var string
	 */
	private $emailAddress;
	/**
	 * @var UserSession
	 */
	private $currentUser;
	/**
	 * @var FullName
	 */
	private $fullName;

	public function __construct($emailAddress, UserSession $currentUser)
	{
		$this->emailAddress = $emailAddress;
		$this->currentUser = $currentUser;
		$this->fullName = new FullName($this->currentUser->FirstName, $this->currentUser->LastName);
		parent::__construct();
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To()
	{
		return new EmailAddress($this->emailAddress);
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('InviteUserSubject', array($this->fullName->__toString(), Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE)));
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$registerUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$registerUrl->Add(Pages::REGISTRATION);

		$this->Set('FullName', $this->fullName->__toString());
		$this->Set('AppTitle', Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE));
		$this->Set('RegisterUrl', $registerUrl->ToString());
		return $this->FetchTemplate('InviteUser.tpl');
	}
}
