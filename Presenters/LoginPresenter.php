<?php

/**
 * Presenting login page.
 */
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginPresenter {

    /**
     * @var ILoginPage
     */
    private $_page = null;

    /**
     * @var IAuthentication
     */
    private $authentication = null;

    public function __construct(ILoginPage &$page, $authentication = null) {
        $this->_page = & $page;
        $this->SetAuthorization($authentication);
    }

    private function SetAuthorization($authentication) {
        if (is_null($authentication)) {
            $this->authentication = PluginManager::Instance()->LoadAuthentication();
        } else {
            $this->authentication = $authentication;
        }
    }

    /**
     * User validation, assigning cookie, check cookie, and whether to show registration link
     */
    public function PageLoad() {
        if ($this->authentication->AreCredentialsKnown()) {
            $this->Login();
        }

        $loginCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::PERSIST_LOGIN);

        if ($this->IsCookieLogin($loginCookie)) {
            if ($this->authentication->CookieLogin($loginCookie)) {
                $this->_Redirect();
            }
        }

        $allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
        $this->_page->setShowRegisterLink($allowRegistration);
    }

    public function Login() {
        if ($this->authentication->Validate($this->_page->getEmailAddress(), $this->_page->getPassword())) {
            $this->authentication->Login($this->_page->getEmailAddress(), $this->_page->getPersistLogin());
            $this->_Redirect();
        } else {
            $this->authentication->HandleLoginFailure($this->_page);
            $this->_page->setShowLoginError();
        }
    }

    public function Logout() {
        $this->authentication->Logout(ServiceLocator::GetServer()->GetUserSession());
        $this->_page->Redirect(Pages::LOGIN);
    }

    private function _Redirect() {
        $redirect = $this->_page->getResumeUrl();

        if (!empty($redirect)) {
            $this->_page->Redirect($redirect);
        } else {
            $defaultId = ServiceLocator::GetServer()->GetUserSession()->HomepageId;
            $this->_page->Redirect(Pages::UrlFromId($defaultId));
        }
    }

    private function IsCookieLogin($loginCookie) {
        return!is_null($loginCookie);
    }

}

?>