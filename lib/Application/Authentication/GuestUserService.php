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

interface IGuestUserService
{
    /**
     * @param string $email
     * @return UserSession
     */
    public function CreateOrLoad($email);

    /**
     * @param $email
     * @return bool
     */
    public function EmailExists($email);
}

class GuestUserService implements IGuestUserService
{
    /**
     * @var IAuthentication
     */
    private $authentication;

    /**
     * @var IRegistration
     */
    private $registration;

    public function __construct(IAuthentication $authentication, IRegistration $registration)
    {
        $this->authentication = $authentication;
        $this->registration = $registration;
    }

    public function CreateOrLoad($email)
    {
        $user = $this->authentication->Login($email, new WebLoginContext(new LoginData()));
        if ($user->IsLoggedIn()) {
            Log::Debug('User already has account, skipping guest creation %s', $email);

            return $user;
        }

        Log::Debug('Email address was not found, creating guest account %s', $email);

        $currentLanguage = Resources::GetInstance()->CurrentLanguage;
        $this->registration->Register($email, $email, 'Guest', 'Guest', Password::GenerateRandom(), null, $currentLanguage, null);
        return $this->authentication->Login($email, new WebLoginContext(new LoginData(false, $currentLanguage)));
    }

    public function EmailExists($email)
    {
        $user = $this->authentication->Login($email, new WebLoginContext(new LoginData()));
        return $user->IsLoggedIn();
    }
}
