<?php
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Common/namespace.php');

class LoginPresenter
{
	private $_page = null;
	private $_server = null;
	
	public function __construct(ILoginPage &$page, Server &$server)
	{
		$this->_page =& $page;
		$this->_server =& $server;
	}
	
	public function PageLoad()
	{
		$allowRegistration = (bool)Configuration::GetKey(ConfigKeys::ALLOW_REGISTRATION);
		$this->_page->setShowRegisterLink($allowRegistration);
		$this->_page->setAvailableLanguages($this->GetLanguages());
		//$this->_page->setCurrentLanguage($this->GetCurrentLanguageCode());
	}
	
	public function Login(&$auth)
	{
		if ($auth->Validate($this->_page->getEmailAddress(), $this->_page->getPassword()))
		{
			$auth->Login($this->_page->getEmailAddress(), $this->_page->getPersistLogin());		
			$this->_Redirect();
		}
	}

	private function _Redirect()
	{
		$redirect = $this->_server->GetQuerystring(QueryStringKeys::REDIRECT);
		
		if (!empty($redirect))
		{
			$this->_page->Redirect($redirect);
		}
		else
		{
			$this->_page->Redirect('ctrlpnl.php');
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
//	
//	private function GetCurrentLanguageCode()
//	{
//		return Resources::GetInstance()->CurrentLanguage;
//	}
}
?>
