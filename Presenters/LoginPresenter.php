<?php
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Common/namespace.php');

class LoginPresenter
{
	private $_page = null;
	
	public function __construct(ILoginPage &$page, IAuthorization $auth)
	{
		$this->_page =& $page;
		$this->_auth = $auth;
	}
	
	public function PageLoad()
	{
		$loginCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::PERSIST_LOGIN);
	
		if ($this->IsCookieLogin($loginCookie))
		{
			if ($this->_auth->CookieLogin($loginCookie))
			{
				$this->_Redirect();
			}
		}
		else
		{
			$allowRegistration = (bool)Configuration::GetKey(ConfigKeys::ALLOW_REGISTRATION);
			$useLogonName = (bool)Configuration::GetKey(ConfigKeys::USE_LOGON_NAME);
			$this->_page->setShowRegisterLink($allowRegistration);
			$this->_page->setAvailableLanguages($this->GetLanguages());
			$this->_page->setUseLogonName($useLogonName);
		}
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
			$this->_page->setShowLoginError();
		}
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
			$this->_page->Redirect(Pages::DEFAULT_LOGIN);
		}
	}
	
	private function GetLanguages()
	{		
		$languages = array();
		
		$langs = Resources::GetInstance()->AvailableLanguages;
		
		foreach($langs as $lang)
		{
			$languages[$lang->LanguageCode] = $lang->DisplayName;
		}
		
		return $languages;
	}
	
	private function IsCookieLogin($loginCookie)
	{
		return !is_null($loginCookie);
	}
}
?>
