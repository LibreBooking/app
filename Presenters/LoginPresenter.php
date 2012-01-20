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
        /**
         * If authentication is null (NOT LOGIN) or not null (LOGIN)
         */
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

        $loginCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::PERSIST_LOGIN);

        if ($this->IsCookieLogin($loginCookie))
        {
            if ($this->authentication->CookieLogin($loginCookie))
            {
                $this->_Redirect();
            }
        }

        $allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
        $this->_page->setShowRegisterLink($allowRegistration);
    }

    /**
     * Validating the login submission form.
     */
    public function Login()
    {
        /**
         * If authentication is successful Log the user in and redirect to requested page.
         */
        if ($this->authentication->Validate($this->_page->getEmailAddress(), $this->_page->getPassword()))
        {
            $this->authentication->Login($this->_page->getEmailAddress(), $this->_page->getPersistLogin());
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
            ServiceLocator::GetServer()->SetCookie(new Cookie('language', $languageCode));
            $this->_page->SetSelectedLanguage($languageCode);
        }
    }

    public function Logout()
    {
        $this->authentication->Logout(ServiceLocator::GetServer()->GetUserSession());
        $this->_page->Redirect(Pages::LOGIN);
    }

    private function _Redirect()
    {
        $redirect = $this->_page->getResumeUrl();

        if (!empty($redirect))
        {
            $this->_page->Redirect($redirect);
        } else
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

        if (!empty($languageCookie))
        {
            $languageCode = $languageCookie;
        }
        else if (!empty($languageHeader))
        {
            $languageCode = $languageHeader;
        }

        $this->_page->SetSelectedLanguage($languageCode);
        Resources::GetInstance()->SetLanguage($languageCode);
    }

}

?>
