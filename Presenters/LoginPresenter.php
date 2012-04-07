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
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginPresenter
{
    /**
     * @var ILoginPage
     */
    private $_page = null;

    /**
     * @var IAuthentication
     */
    private $authentication = null;

    /**
     * Construct page type and authentication method
     * @param ILoginPage $page passed by reference
     * @param IAuthentication $authentication default to null
     */
    public function __construct(ILoginPage &$page, $authentication = null)
    {
        $this->_page = & $page;
        $this->SetAuthentication($authentication);
    }

    /**
     * @param IAuthentication $authentication
     */
    private function SetAuthentication($authentication)
    {
        if (is_null($authentication))
        {
            $this->authentication = PluginManager::Instance()->LoadAuthentication();
        } else
        {
            $this->authentication = $authentication;
        }
    }

    /**
     * User validation, assigning cookie, check cookie, and whether to show registration link
     */
    public function PageLoad()
    {
        $this->SetSelectedLanguage();

        if ($this->authentication->AreCredentialsKnown())
        {
            $this->Login();
        }

		$server = ServiceLocator::GetServer();
		$loginCookie = $server->GetCookie(CookieKeys::PERSIST_LOGIN);

        if ($this->IsCookieLogin($loginCookie))
        {
            if ($this->authentication->CookieLogin($loginCookie, new WebLoginContext($server, new LoginData(true))))
            {
                $this->_Redirect();
            }
        }

        $allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
        $this->_page->SetShowRegisterLink($allowRegistration);
    }

    /**
     * Validating the login submission form.
     */
    public function Login()
    {
        /**
         * If authentication is successful Log the user in and redirect to requested page.
         */
        if ($this->authentication->Validate($this->_page->GetEmailAddress(), $this->_page->GetPassword()))
        {
			$context = new WebLoginContext(ServiceLocator::GetServer(), new LoginData($this->_page->GetPersistLogin(), $this->_page->GetSelectedLanguage()));
            $this->authentication->Login($this->_page->GetEmailAddress(), $context);
            $this->_Redirect();
        }
        else
        {
            $this->authentication->HandleLoginFailure($this->_page);
            $this->_page->SetShowLoginError();
        }
    }

    public function ChangeLanguage()
    {
        $resources = Resources::GetInstance();

        $languageCode = $this->_page->GetRequestedLanguage();
        if ($resources->SetLanguage($languageCode))
        {
            ServiceLocator::GetServer()->SetCookie(new Cookie(CookieKeys::LANGUAGE, $languageCode));
            $this->_page->SetSelectedLanguage($languageCode);
        }
    }

    public function Logout()
    {
        $url =  htmlspecialchars_decode($this->_page->GetResumeUrl());

		$url = sprintf('%s?%s=%s', Pages::LOGIN, QueryStringKeys::REDIRECT, urlencode($url));
        $this->authentication->Logout(ServiceLocator::GetServer()->GetUserSession());
        $this->_page->Redirect($url);
    }

    private function _Redirect()
    {
        $redirect = $this->_page->GetResumeUrl();

        if (!empty($redirect))
        {
            $this->_page->Redirect($redirect);
        }
        else
        {
            $defaultId = ServiceLocator::GetServer()->GetUserSession()->HomepageId;
            $this->_page->Redirect(Pages::UrlFromId($defaultId));
        }
    }

    private function IsCookieLogin($loginCookie)
    {
        return !is_null($loginCookie);
    }

    private function SetSelectedLanguage()
    {
        $requestedLanguage = $this->_page->GetRequestedLanguage();
        if (!empty($requestedLanguage))
        {
            // this is handled by ChangeLanguage()
            return;
        }

        $languageCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::LANGUAGE);
        $languageHeader = ServiceLocator::GetServer()->GetLanguage();
        $languageCode = Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);

		$resources = Resources::GetInstance($languageCookie);

        if ($resources->IsLanguageSupported($languageCookie))
        {
            $languageCode = $languageCookie;
        }
        else if ($resources->IsLanguageSupported($languageHeader))
        {
            $languageCode = $languageHeader;
        }

		$this->_page->SetSelectedLanguage(strtolower($languageCode));
		$resources->SetLanguage($languageCode);
    }
}

?>