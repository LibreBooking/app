<?php
/**
Copyright 2011-2020 Nick Korbel

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

class PasswordValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var User
	 */
	private $user;
    private $currentPasswordPlainText;

    /**
	 * @param string $currentPasswordPlainText
	 * @param User $user
	 */
	public function __construct($currentPasswordPlainText, User $user)
	{
		$this->currentPasswordPlainText = $currentPasswordPlainText;
		$this->user = $user;
	}

	public function Validate()
	{
		$pw = new Password($this->currentPasswordPlainText, $this->user->encryptedPassword);
		$this->isValid = $pw->Validate($this->user->passwordSalt);

        if (!$this->isValid)
        {
            $this->AddMessage(Resources::GetInstance()->GetString('PwMustMatch'));
        }
	}
}