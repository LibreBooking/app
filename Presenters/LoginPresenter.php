<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Presenters/Authentication/LoginRedirector.php');

class LoginPresenter
{
	/**
	 * @var ILoginPage
	 */
	private $_page = null;

	/**
	 * @var IWebAuthentication
	 */
	private $authentication = null;

    /**
     * @var ICaptchaService
     */
    private $captchaService;

    /**
     * @var IAnnouncementRepository
     */
    private $announcementRepository;

    /**
     * @param ILoginPage $page
     * @param IWebAuthentication $authentication
     * @param ICaptchaService $captchaService
     * @param IAnnouncementRepository $announcementRepository
     */
	public function __construct(ILoginPage &$page, $authentication = null, $captchaService = null, $announcementRepository = null)
	{
		$this->_page = & $page;
		$this->SetAuthentication($authentication);
        $this->SetCaptchaService($captchaService);
        $this->SetAnnouncementRepository($announcementRepository);

        $this->LoadValidators();
	}

	/**
	 * @param IWebAuthentication $authentication
	 */
	private function SetAuthentication($authentication)
	{
		if (is_null($authentication))
		{
			$this->authentication = new WebAuthentication(PluginManager::Instance()->LoadAuthentication(), ServiceLocator::GetServer());
		}
		else
		{
			$this->authentication = $authentication;
		}
	}

    /**
     * @param ICaptchaService $captchaService
     */
    private function SetCaptchaService($captchaService)
    {
        if (is_null($captchaService))
        {
            $this->captchaService = CaptchaService::Create();
        }
        else
        {
            $this->captchaService = $captchaService;
        }
    }

    /**
     * @param IAnnouncementRepository $announcementRepository
     */
    private function SetAnnouncementRepository($announcementRepository)
    {
        if (is_null($announcementRepository))
        {
            $this->announcementRepository = new AnnouncementRepository();
        }
        else
        {
            $this->announcementRepository = $announcementRepository;
        }
    }

    public function PageLoad()
	{
		if ($this->authentication->IsLoggedIn())
		{
			$this->_Redirect();
			return;
		}

		$this->SetSelectedLanguage();

		if ($this->authentication->AreCredentialsKnown())
		{
			$this->Login();
			return;
		}

		$server = ServiceLocator::GetServer();
		$loginCookie = $server->GetCookie(CookieKeys::PERSIST_LOGIN);

		if ($this->IsCookieLogin($loginCookie))
		{
			if ($this->authentication->CookieLogin($loginCookie, new WebLoginContext(new LoginData(true))))
			{
				$this->_Redirect();
				return;
			}
		}

		$allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
		$allowAnonymousSchedule = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,  ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter());
		$allowGuestBookings = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter());
		$this->_page->SetShowRegisterLink($allowRegistration);
		$this->_page->SetShowScheduleLink($allowAnonymousSchedule || $allowGuestBookings);

		$hideLogin = Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_HIDE_BOOKED_LOGIN_PROMPT, new BooleanConverter());

		$this->_page->ShowForgotPasswordPrompt(!Configuration::Instance()->GetKey(ConfigKeys::DISABLE_PASSWORD_RESET, new BooleanConverter()) &&
											   $this->authentication->ShowForgotPasswordPrompt() &&
											   !$hideLogin);
		$this->_page->ShowPasswordPrompt($this->authentication->ShowPasswordPrompt() && !$hideLogin);
		$this->_page->ShowPersistLoginPrompt($this->authentication->ShowPersistLoginPrompt());

		$this->_page->ShowUsernamePrompt($this->authentication->ShowUsernamePrompt() && !$hideLogin);
		$this->_page->SetRegistrationUrl($this->authentication->GetRegistrationUrl() && !$hideLogin);
		$this->_page->SetPasswordResetUrl($this->authentication->GetPasswordResetUrl());
		$this->_page->SetAnnouncements($this->announcementRepository->GetFuture(Pages::ID_LOGIN));
	}

	public function Login()
	{
	    if (!$this->_page->IsValid())
        {
            return;
        }

		$id = $this->_page->GetEmailAddress();

		if ($this->authentication->Validate($id, $this->_page->GetPassword()))
		{
			$context = new WebLoginContext(new LoginData($this->_page->GetPersistLogin(), $this->_page->GetSelectedLanguage()));
			$this->authentication->Login($id, $context);
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
			$this->_page->Redirect(Pages::LOGIN);
		}
	}

	public function Logout()
	{
		$url = Configuration::Instance()->GetKey(ConfigKeys::LOGOUT_URL);
		if (empty($url))
		{
			$url = htmlspecialchars_decode($this->_page->GetResumeUrl());
			$url = sprintf('%s?%s=%s', Pages::LOGIN, QueryStringKeys::REDIRECT, urlencode($url));
		}
		$this->authentication->Logout(ServiceLocator::GetServer()->GetUserSession());
		$this->_page->Redirect($url);
	}

	private function _Redirect()
	{
		LoginRedirector::Redirect($this->_page);
	}

	private function IsCookieLogin($loginCookie)
	{
		return !empty($loginCookie);
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

		$resources = Resources::GetInstance();

		if ($resources->IsLanguageSupported($languageCookie))
		{
			$languageCode = $languageCookie;
		}
		else
		{
			if ($resources->IsLanguageSupported($languageHeader))
			{
				$languageCode = $languageHeader;
			}
		}

		$this->_page->SetSelectedLanguage(strtolower($languageCode));
		$resources->SetLanguage($languageCode);
	}

    protected function LoadValidators()
    {
        if (Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_CAPTCHA_ON_LOGIN, new BooleanConverter())) {
            $this->_page->RegisterValidator('captcha', new CaptchaValidator($this->_page->GetCaptcha(), $this->captchaService));
        }
    }
}