<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/namespace.php');

class Registration implements IRegistration
{
    private $_passwordEncryption;

    public function __construct($passwordEncryption = null)
    {
        $this->_passwordEncryption = $passwordEncryption;

        if ($passwordEncryption == null)
        {
            $this->_passwordEncryption = new PasswordEncryption();
        }
    }

    public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language,
                             $homepageId,
                             $additionalFields = array())
    {
        $encryptedPassword = $this->_passwordEncryption->EncryptPassword($password);

        $attributes = new UserAttribute($additionalFields);

        $registerCommand = new RegisterUserCommand($username, $email, $firstName, $lastName,
            $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $timezone, $language, $homepageId,
            $attributes->Get(UserAttribute::Phone), $attributes->Get(UserAttribute::Organization), $attributes->Get(UserAttribute::Position),
            AccountStatus::ACTIVE);

        $userId = ServiceLocator::GetDatabase()->ExecuteInsert($registerCommand);
        $this->AutoAssignPermissions($userId);
    }

    public function UserExists($loginName, $emailAddress)
    {
        $exists = false;
        $reader = ServiceLocator::GetDatabase()->Query(new CheckUserExistanceCommand($loginName, $emailAddress));

        if ($row = $reader->GetRow())
        {
            $exists = true;
        }

        return $exists;
    }

    public function Synchronize(AuthenticatedUser $user)
    {
        if ($this->UserExists($user->UserName(), $user->Email()))
        {
            $encryptedPassword = $this->_passwordEncryption->EncryptPassword($user->Password());
            $command = new UpdateUserFromLdapCommand($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $user->Phone(), $user->Organization(), $user->Title());

            ServiceLocator::GetDatabase()->Execute($command);
        }
        else
        {
            $additionalFields = array('phone' => $user->Phone(), 'organization' => $user->Organization(), 'position' => $user->Title());
            $this->Register($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $user->Password(),
                            $user->TimezoneName(),
                            $user->LanguageCode(),
                            Pages::DEFAULT_HOMEPAGE_ID,
                            $additionalFields);
        }
    }

    private function AutoAssignPermissions($userId)
    {
        $autoAssignCommand = new AutoAssignPermissionsCommand($userId);
        ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
    }
}

?>