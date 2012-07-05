<?php
/**
Copyright 2011-2012 Nick Korbel
Copyright 2012 Alois Schloegl

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

#require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface ILoginPage extends IPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetEmailAddress();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetPassword();

	/**
	 * @abstract
	 * @return bool
	 */
	public function GetPersistLogin();

	public function GetShowRegisterLink();

	public function SetShowRegisterLink($value);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetSelectedLanguage();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetRequestedLanguage();

	public function SetUseLogonName($value);

	public function SetResumeUrl($value);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetResumeUrl();

	public function SetShowLoginError();

	/**
	 * @abstract
	 * @param $languageCode string
	 */
	public function SetSelectedLanguage($languageCode);

	/**
	 * @abstract
	 * @param $shouldShow bool
	 */
	public function ShowUsernamePrompt($shouldShow);

	/**
	 * @abstract
	 * @param $shouldShow bool
	 */
	public function ShowPasswordPrompt($shouldShow);

	/**
	 * @abstract
	 * @param $shouldShow bool
	 */
	public function ShowPersistLoginPrompt($shouldShow);

	/**
	 * @abstract
	 * @param $shouldShow bool
	 */
	public function ShowForgotPasswordPrompt($shouldShow);
}

class LoginPage extends Page implements ILoginPage
{
	protected $presenter = null;

	public function __construct()
	{
		parent::__construct('LogIn'); // parent Page class

		$this->presenter = new LoginPresenter($this); // $this pseudo variable of class object is Page object
		$this->Set('ResumeUrl', urldecode($this->server->GetQuerystring(QueryStringKeys::REDIRECT)));
		$this->Set('ShowLoginError', false);
		$this->Set('Languages', Resources::GetInstance()->AvailableLanguages);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('login.tpl');
	}

	public function GetEmailAddress()
	{
                // TODO: conf.settings can not be resolved
                if ($conf['settings']['plugins']['Authentication'] == 'Krb5')
                {
			### Required when using Krb5, its excluded because of possible conflict with other methods
                	### TODO: this should be done in a more generic way. 
                	$ru = explode('@', $_SERVER['REMOTE_USER']);
                	$value =  $ru[0].'@ist.ac.at';
                	return $value;
		}
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}

	public function GetPersistLogin()
	{
		return $this->GetForm(FormKeys::PERSIST_LOGIN);
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
		// TODO: conf.settings can not be resolved
		if ($conf['settings']['plugins']['Authentication'] == 'Krb5') 
		{
			### Required when using Krb5, its excluded because of possible conflict with other methods
			### TODO: this should be done in a more generic way
			$ru = explode('@', $_SERVER['REMOTE_USER']);
			$value = $ru[0];
		}
		$this->Set('UseLogonName', $value);
	}

	public function SetResumeUrl($value)
	{
		$this->Set('ResumeUrl', $value);
	}

	public function GetResumeUrl()
	{
		return $this->GetForm(FormKeys::RESUME);
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
}

?>