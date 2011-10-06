<?php
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
	private $_auth = null;
	
	public function __construct(ILoginPage &$page, $authorization = null)
	{
		$this->_page =& $page;
		$this->SetAuthorization($authorization);
	}
	
	private function SetAuthorization($authorization)
	{
		if (is_null($authorization))
		{
			$this->_auth = PluginManager::Instance()->LoadAuth();
		}
		else
		{
			$this->_auth = $authorization;
		}
	}
	
	public function PageLoad()
	{
		if ($this->_auth->AreCredentialsKnown())
		{
			$this->Login();
		}
		
		$loginCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::PERSIST_LOGIN);

		if ($this->IsCookieLogin($loginCookie))
		{
			if ($this->_auth->CookieLogin($loginCookie))
			{
				$this->_Redirect();
			}
		}
		
		$allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
		$this->_page->setShowRegisterLink($allowRegistration);
	}
	
	public function Login()
	{
		if ($this->_auth->Validate($this->_page->getEmailAddress(), $this->_page->getPassword()))
		{
			$this->_auth->Login($this->_page->getEmailAddress(), $this->_page->getPersistLogin());		
			$this->_Redirect();
		}
		else 
		{
			$this->_auth->HandleLoginFailure($this->_page);
			$this->_page->setShowLoginError();
		}
	}
	
	public function Logout()
	{
		$this->_auth->Logout(ServiceLocator::GetServer()->GetUserSession());		
		$this->_page->Redirect(Pages::LOGIN);
	}

	private function _Redirect()
	{
		$redirect = $this->_page->getResumeUrl();
		
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
}
?>
