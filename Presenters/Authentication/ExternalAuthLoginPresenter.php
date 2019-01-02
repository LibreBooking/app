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

require_once(ROOT_DIR . 'Presenters/Authentication/LoginRedirector.php');

class ExternalAuthLoginPresenter
{
    /**
     * @var ExternalAuthLoginPage
     */
    private $page;
    /**
     * @var IWebAuthentication
     */
    private $authentication;
    /**
     * @var IRegistration
     */
    private $registration;

    public function __construct(ExternalAuthLoginPage $page, IWebAuthentication $authentication, IRegistration $registration)
    {
        $this->page = $page;
        $this->authentication = $authentication;
        $this->registration = $registration;
    }

    public function PageLoad()
    {
        if ($this->page->GetType() == 'google') {
            $this->ProcessSocialSingleSignOn('googleprofile.php');
        }
        if ($this->page->GetType() == 'fb') {
            $this->ProcessSocialSingleSignOn('fbprofile.php');
        }
    }

    private function ProcessSocialSingleSignOn($page)
    {
        $code = $_GET['code'];
        Log::Debug('Logging in with social. Code=%s', $code);
        $result = file_get_contents("http://www.social.twinkletoessoftware.com/$page?code=$code");
        $profile = json_decode($result);

        $requiredDomainValidator = new RequiredEmailDomainValidator($profile->email);
        $requiredDomainValidator->Validate();
        if (!$requiredDomainValidator->IsValid()) {
            Log::Debug('Social login with invalid domain. %s', $profile->email);
            $this->page->ShowError(array(Resources::GetInstance()->GetString('InvalidEmailDomain')));
            return;
        }

        Log::Debug('Social login successful. Email=%s', $profile->email);
        $this->registration->Synchronize(new AuthenticatedUser($profile->email,
            $profile->email,
            $profile->first_name,
            $profile->last_name,
            Password::GenerateRandom(),
            Resources::GetInstance()->CurrentLanguage,
            Configuration::Instance()->GetDefaultTimezone(),
            null,
            null,
            null),
            false,
            false);

        $this->authentication->Login($profile->email, new WebLoginContext(new LoginData()));
        LoginRedirector::Redirect($this->page);
    }
}
