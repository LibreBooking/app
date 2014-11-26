<?php
/**
Copyright 2012-2014-13 Nick Korbel, Paul Menchini

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

class AccountCreationEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
		parent::__construct(Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE));
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To()
	{
		return new EmailAddress(Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL),
								Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE));
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
		$this->Set('To',			Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) ? Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) : 'Administrator');
		$this->Set('FullName',		$this->user->FullName());
		$this->Set('EmailAddress',	$this->user->EmailAddress());
		$this->Set('Phone',			$this->user->GetAttribute('Phone'));
		$this->Set('Organization',	$this->user->GetAttribute('Organization'));
		$this->Set('Position',		$this->user->GetAttribute('Position'));

		return $this->FetchTemplate('AccountCreation.tpl');
	}
}
?>