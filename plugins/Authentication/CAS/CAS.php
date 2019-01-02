<?php
/**
 * Copyright 2011-2019 Nick Korbel
 * Copyright 2013-2014 Bart Verheyde
 * Copyright 2013-2014 Bryan Green
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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'plugins/Authentication/CAS/namespace.php');

class CAS extends Authentication implements IAuthentication
{
    private $authToDecorate;
    private $registration;

    /**
     * @var CASOptions
     */
    private $options;

    /**
     * @return Registration
     */
    private function GetRegistration()
    {
        if ($this->registration == null) {
            $this->registration = new Registration();
        }

        return $this->registration;
    }

    public function __construct(Authentication $authentication)
    {
        $this->options = new CASOptions();
        $this->setCASSettings();
        $this->authToDecorate = $authentication;
    }

    private function setCASSettings()
    {
        if ($this->options->IsCasDebugOn()) {
            phpCAS::setDebug($this->options->DebugFile());
        }
        phpCAS::client($this->options->CasVersion(), $this->options->HostName(), $this->options->Port(),
            $this->options->ServerUri(), $this->options->ChangeSessionId());
        if ($this->options->CasHandlesLogouts()) {
            phpCAS::handleLogoutRequests(true, $this->options->LogoutServers());
        }

        if ($this->options->HasCertificate()) {
            phpCAS::setCasServerCACert($this->options->Certificate());
        }
        phpCAS::setNoCasServerValidation();
    }

    public function Validate($username, $password)
    {
        try {
            phpCAS::forceAuthentication();

        } catch (Exception $ex) {
            Log::Error('CAS exception: %s', $ex);
            return false;
        }
        return true;
    }

    public function Login($username, $loginContext)
    {
        Log::Debug('Attempting CAS login for username: %s', $username);

        $isAuth = phpCAS::isAuthenticated();
        Log::Debug('CAS is auth ok: %s', $isAuth);
        $username = phpCAS::getUser();
        $attributes = phpCAS::getAttributes();
        $this->Synchronize($username, $attributes);

        return $this->authToDecorate->Login($username, $loginContext);
    }

    public function Logout(UserSession $user)
    {
        Log::Debug('Attempting CAS logout for email: %s', $user->Email);
        $this->authToDecorate->Logout($user);

        if ($this->options->CasHandlesLogouts()) {
            phpCAS::logout();
        }
    }

    public function AreCredentialsKnown()
    {
        return true;
    }

    public function HandleLoginFailure(IAuthenticationPage $loginPage)
    {
        $this->authToDecorate->HandleLoginFailure($loginPage);
    }

    public function ShowUsernamePrompt()
    {
        return false;
    }

    public function ShowPasswordPrompt()
    {
        return false;
    }

    public function ShowPersistLoginPrompt()
    {
        return false;
    }

    public function ShowForgotPasswordPrompt()
    {
        return false;
    }

    public function AllowUsernameChange()
    {
        return false;
    }

    public function AllowEmailAddressChange()
    {
        return false;
    }

    public function AllowPasswordChange()
    {
        return false;
    }

    public function AllowNameChange()
    {
        return false;
    }

    public function AllowPhoneChange()
    {
        return false;
    }

    public function AllowOrganizationChange()
    {
        return false;
    }

    public function AllowPositionChange()
    {
        return false;
    }

    private function Synchronize($username, $attributes)
    {
        $registration = $this->GetRegistration();

        $registration->Synchronize(
            new AuthenticatedUser(
                $username,
                $this->getAttribute($username, $attributes, 'email'),
                $this->getAttribute($username, $attributes, 'givenName'),
                $this->getAttribute($username, $attributes, 'surName'),
                BookedStringHelper::Random(12),
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
                Configuration::Instance()->GetDefaultTimezone(),
                null,
                null,
                null,
                $this->getGroups($attributes))
        );
    }

    private function getAttribute($username, $attributes, $key)
    {
        $attributeMapping = $this->options->AttributeMapping();
        if (array_key_exists($key, $attributeMapping))
        {
            $mappedName = $attributeMapping[$key];
            if (array_key_exists($mappedName, $attributes))
            {
                return $attributes[$mappedName];
            }
        }

        return $username;
    }

    private function getGroups($attributes)
    {
        $attributeMapping = $this->options->AttributeMapping();
        if (array_key_exists('groups', $attributeMapping))
        {
            $mappedName = $attributeMapping['groups'];
            if (array_key_exists($mappedName, $attributes))
            {
                $userGroups = $attributes[$mappedName];
                if (!is_array($userGroups))
                {
                    return array($userGroups);
                }
                return $userGroups;
            }
        }

        return null;
    }
}