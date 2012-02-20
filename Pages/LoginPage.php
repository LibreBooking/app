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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

/**
 * An interface extending IPage interface to be implemented by class
 */
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

	public function SetSelectedLanguage($languageCode);
}

/**
 * Class to implement login page
 */
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

	/**
	 * Present appropriate page by calling PageLoad method.
	 * Call template engine Smarty object to display login template.
	 */
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

	/**
	 * Calling upon _presenter->Login() for authentication to a requested page.
	 * (Notice that this is not the Login Page, better understand the Login Page is an extension of Page).
	 * $this->_presenter = new LoginPresenter($this): is infact an extension of Page class
	 */
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
}

?>