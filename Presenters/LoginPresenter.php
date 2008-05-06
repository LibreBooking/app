<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginPresenter
{
	private $_page = null;
	
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
		$loginCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::PERSIST_LOGIN);

		if ($this->IsCookieLogin($loginCookie))
		{
			if ($this->_auth->CookieLogin($loginCookie))
			{
				$this->_Redirect();
			}
		}
		
		$allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
		$useLogonName = Configuration::Instance()->GetKey(ConfigKeys::USE_LOGON_NAME, new BooleanConverter());
		$this->_page->setShowRegisterLink($allowRegistration);
		$this->_page->setAvailableLanguages($this->GetLanguages());
		$this->_page->setUseLogonName($useLogonName);

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
			$defaultId = ServiceLocator::GetServer()->GetSession(SessionKeys::USER_SESSION)->HomepageId;
			$this->_page->Redirect(Pages::UrlFromId($defaultId));
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
