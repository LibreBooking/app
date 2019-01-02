<?php
/**
 * Copyright 2011-2019 Nick Korbel
 * Copyright 2012-2014 Alois Schloegl
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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/Authentication/ILoginBasePage.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface ILoginPage extends IPage, ILoginBasePage
{
    /**
     * @return string
     */
    public function GetEmailAddress();

    /**
     * @return string
     */
    public function GetPassword();

    /**
     * @return bool
     */
    public function GetPersistLogin();

    public function GetShowRegisterLink();

    public function SetShowRegisterLink($value);

    public function SetShowScheduleLink($value);

    /**
     * @return string
     */
    public function GetSelectedLanguage();

    /**
     * @return string
     */
    public function GetRequestedLanguage();

    public function SetUseLogonName($value);

    public function SetResumeUrl($value);

    public function SetShowLoginError();

    /**
     * @param $languageCode string
     */
    public function SetSelectedLanguage($languageCode);

    /**
     * @param $shouldShow bool
     */
    public function ShowUsernamePrompt($shouldShow);

    /**
     * @param $shouldShow bool
     */
    public function ShowPasswordPrompt($shouldShow);

    /**
     * @param $shouldShow bool
     */
    public function ShowPersistLoginPrompt($shouldShow);

    /**
     * @param $shouldShow bool
     */
    public function ShowForgotPasswordPrompt($shouldShow);

    /**
     * @param $url string
     */
    public function SetRegistrationUrl($url);

    /**
     * @param $url string
     */
    public function SetPasswordResetUrl($url);

    /**
     * @return string
     */
    public function GetCaptcha();

    /**
     * @param Announcement[] $announcements
     */
    public function SetAnnouncements($announcements);
}

class LoginPage extends Page implements ILoginPage
{
    protected $presenter = null;

    public function __construct()
    {
        parent::__construct('LogIn'); // parent Page class

        $this->presenter = new LoginPresenter($this); // $this pseudo variable of class object is Page object
        $resumeUrl = $this->server->GetQuerystring(QueryStringKeys::REDIRECT);
        $resumeUrl = str_replace('&amp;&amp;', '&amp;', $resumeUrl);
        $this->Set('ResumeUrl', $resumeUrl);
        $this->Set('ShowLoginError', false);
        $this->Set('Languages', Resources::GetInstance()->AvailableLanguages);

        $this->Set('AllowFacebookLogin', Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_ALLOW_FACEBOOK, new BooleanConverter()));
        $this->Set('AllowGoogleLogin', Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_ALLOW_GOOGLE, new BooleanConverter()));
        $scriptUrl = Configuration::Instance()->GetScriptUrl();
        $parts = explode('://', $scriptUrl);
        $this->Set('Protocol', $parts[0]);
        $this->Set('ScriptUrlNoProtocol', $parts[1]);
        $this->Set('GoogleState', strtr(base64_encode("resume=$scriptUrl/external-auth.php%3Ftype%3Dgoogle%26redirect%3D$resumeUrl"), '+/=', '-_,'));
        $this->Set('EnableCaptcha', Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_CAPTCHA_ON_LOGIN, new BooleanConverter()));
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();
        $this->Display('login.tpl');
    }

    public function GetEmailAddress()
    {
        return $this->GetForm(FormKeys::EMAIL);
    }

    public function GetPassword()
    {
        return $this->GetRawForm(FormKeys::PASSWORD);
    }

    public function GetPersistLogin()
    {
        return $this->GetCheckbox(FormKeys::PERSIST_LOGIN);
    }

    public function GetShowRegisterLink()
    {
        return $this->GetVar('ShowRegisterLink');
    }

    public function SetShowRegisterLink($value)
    {
        $this->Set('ShowRegisterLink', $value);
    }

    public function GetSelectedLanguage()
    {
        return $this->GetForm(FormKeys::LANGUAGE);
    }

    public function SetUseLogonName($value)
    {
        $this->Set('UseLogonName', $value);
    }

    public function GetCaptcha()
    {
        return $this->GetForm(FormKeys::CAPTCHA);
    }

    public function SetResumeUrl($value)
    {
        $this->Set('ResumeUrl', $value);
    }

    public function GetResumeUrl()
    {
        $resumeUrl = $this->GetForm(FormKeys::RESUME);
        if (empty($resumeUrl)) {
            return $this->GetQuerystring(QueryStringKeys::REDIRECT);
        }
        else {
            return $this->GetForm(FormKeys::RESUME);
        }
    }

    public function DisplayWelcome()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function LoggingIn()
    {
        $loggingIn = $this->GetForm(Actions::LOGIN);
        return !empty($loggingIn);
    }

    /**
     * @return bool
     */
    public function ChangingLanguage()
    {
        $lang = $this->GetRequestedLanguage();
        return !empty($lang);
    }

    public function Login()
    {
        $this->presenter->Login();
    }

    public function ChangeLanguage()
    {
        $this->presenter->ChangeLanguage();
    }

    public function SetShowLoginError()
    {
        $this->Set('ShowLoginError', true);
    }

    public function GetRequestedLanguage()
    {
        return $this->GetQuerystring(QueryStringKeys::LANGUAGE);
    }

    public function SetSelectedLanguage($languageCode)
    {
        $this->Set('SelectedLanguage', $languageCode);
    }

    protected function GetShouldAutoLogout()
    {
        return false;
    }

    public function ShowUsernamePrompt($shouldShow)
    {
        $this->Set('ShowUsernamePrompt', $shouldShow);
    }

    public function ShowPasswordPrompt($shouldShow)
    {
        $this->Set('ShowPasswordPrompt', $shouldShow);
    }

    public function ShowPersistLoginPrompt($shouldShow)
    {
        $this->Set('ShowPersistLoginPrompt', $shouldShow);
    }

    public function ShowForgotPasswordPrompt($shouldShow)
    {
        $this->Set('ShowForgotPasswordPrompt', $shouldShow);
    }

    public function SetShowScheduleLink($shouldShow)
    {
        $this->Set('ShowScheduleLink', $shouldShow);
    }

    public function SetPasswordResetUrl($url)
    {
        $this->Set('ForgotPasswordUrl', empty($url) ? Pages::FORGOT_PASSWORD : $url);
        if (BookedStringHelper::StartsWith($url, 'http')) {
            $this->Set('ForgotPasswordUrlNew', "target='_new'");
        }
    }

    public function SetRegistrationUrl($url)
    {
        $this->Set('RegisterUrl', empty($url) ? Pages::REGISTRATION : $url);
        if (BookedStringHelper::StartsWith($url, 'http')) {
            $this->Set('RegisterUrlNew', "target='_new'");
        }
    }

    public function SetAnnouncements($announcements)
    {
        $this->Set('Announcements', $announcements);
    }
}
