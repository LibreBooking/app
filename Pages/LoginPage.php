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
interface ILoginPage extends IPage {

    public function getEmailAddress();

    public function getPassword();

    public function getPersistLogin();

    public function getShowRegisterLink();

    public function setShowRegisterLink($value);

    public function getCurrentLanguage();

    public function setUseLogonName($value);

    public function setResumeUrl($value);

    public function getResumeUrl();

    public function setShowLoginError();
}

/**
 * Class to implement login page
 */
class LoginPage extends Page implements ILoginPage {

    private $_presenter = null;

    /**
     *
     */
    public function __construct() {
        /**
         * Calling a parent constructor within a constructor
         */
        parent::__construct('LogIn');   // parent Page class
        /**
         * As well instantiate LoginPresenter class object
         */
        $this->_presenter = new LoginPresenter($this);  // $this pseudo variable of class object is Page object
        $this->Set('ResumeUrl', $this->server->GetQuerystring(QueryStringKeys::REDIRECT));
        $this->Set('ShowLoginError', false);
    }

    /**
     * Present appropriate page by calling PageLoad method.
     * Call template engine Smarty object to display login template.
     */
    public function PageLoad() {
        $this->_presenter->PageLoad();
        $this->Display('login.tpl');
    }

    public function getEmailAddress() {
        return $this->GetForm(FormKeys::EMAIL);
    }

    public function getPassword() {
        return $this->GetForm(FormKeys::PASSWORD);
    }

    public function getPersistLogin() {
        return $this->GetForm(FormKeys::PERSIST_LOGIN);
    }

    public function getShowRegisterLink() {
        return $this->GetVar('ShowRegisterLink');
    }

    public function setShowRegisterLink($value) {
        $this->Set('ShowRegisterLink', $value);
    }

    public function getCurrentLanguage() {
        return $this->GetForm(FormKeys::LANGUAGE);
    }

    public function setUseLogonName($value) {
        $this->Set('UseLogonName', $value);
    }

    public function setResumeUrl($value) {
        $this->Set('ResumeUrl', $value);
    }

    public function getResumeUrl() {
        return $this->GetForm(FormKeys::RESUME);
    }

    public function DisplayWelcome() {
        return false;
    }

    /**
     * Get and return form status on Actions::LOGIN
     * @return type null
     */
    public function LoggingIn() {

        return $this->GetForm(Actions::LOGIN);
    }

    /**
     * Calling upon _presenter->Login() for authentication to a requested page.
     * (Notice that this is not the Login Page, better understand the Login Page is an extension of Page).
     * $this->_presenter = new LoginPresenter($this): is infact an extension of Page class
     */
    public function Login() {
        $this->_presenter->Login();
    }

    public function setShowLoginError() {
        $this->Set('ShowLoginError', true);
    }

}

?>