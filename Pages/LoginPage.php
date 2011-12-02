<?php

/**
 *
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

    public function __construct() {
        parent::__construct('LogIn');   // parent Page class
        /**
         * As well instantiate LoginPresenter class object
         */
        $this->_presenter = new LoginPresenter($this);  // $this pseudo variable of class object is null
        $this->smarty->assign('ResumeUrl', $this->server->GetQuerystring(QueryStringKeys::REDIRECT));
        $this->smarty->assign('ShowLoginError', false);
    }

    /**
     * Present appropriate page by calling PageLoad method.
     * Call template engine Smarty object to display login template.
     */
    public function PageLoad() {
        $this->_presenter->PageLoad();
        $this->smarty->display('login.tpl');
    }

    public function getEmailAddress() {
        return $this->server->GetForm(FormKeys::EMAIL);
    }

    public function getPassword() {
        return $this->server->GetForm(FormKeys::PASSWORD);
    }

    public function getPersistLogin() {
        return $this->server->GetForm(FormKeys::PERSIST_LOGIN);
    }

    public function getShowRegisterLink() {
        return $this->smarty->get_template_vars('ShowRegisterLink');
    }

    public function setShowRegisterLink($value) {
        $this->smarty->assign('ShowRegisterLink', $value);
    }

    public function getCurrentLanguage() {
        return $this->server->GetForm(FormKeys::LANGUAGE);
    }

    public function setUseLogonName($value) {
        $this->smarty->assign('UseLogonName', $value);
    }

    public function setResumeUrl($value) {
        $this->smarty->assign('ResumeUrl', $value);
    }

    public function getResumeUrl() {
        return $this->server->GetForm(FormKeys::RESUME);
    }

    public function DisplayWelcome() {
        return false;
    }
    
    /**
     * Get and return form status on Actions::LOGIN
     * @return type null
     */
    public function LoggingIn() {
        return $this->server->GetForm(Actions::LOGIN);
    }
    
    /**
     * 
     */
    public function Login() {
        $this->_presenter->Login();
    }

    public function setShowLoginError() {
        $this->smarty->assign('ShowLoginError', true);
    }

}

?>