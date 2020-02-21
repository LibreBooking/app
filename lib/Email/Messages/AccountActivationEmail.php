<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class AccountActivationEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $activationCode;

	public function __construct(User $user, $activationCode)
	{
		$this->user = $user;
		$this->activationCode = $activationCode;
		parent::__construct($user->Language());
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
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
		return $this->Translate('ActivateYourAccount');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$activationUrl
				->Add(Pages::ACTIVATION)
				->AddQueryString(QueryStringKeys::ACCOUNT_ACTIVATION_CODE, $this->activationCode);

		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('ActivationUrl', $activationUrl);
		return $this->FetchTemplate('AccountActivation.tpl');
	}
}