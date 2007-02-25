<?php
require_once('Page.php');
require_once(dirname(__FILE__) . '/../lib/Common/SmartyPage.php');
require_once(dirname(__FILE__) . '/../lib/Server/namespace.php');

interface ILoginPage extends IPage
{
	public function getEmailAddress();
	public function getPassword();
	public function getPersistLogin();
	public function getShowRegisterLink();
	public function setShowRegisterLink($value);
	public function setAvailableLanguages($languages);
	public function getCurrentLanguage();
}

class LoginPage extends Page implements ILoginPage
{
	private $_presenter = null;

	public function __construct(Server &$server = null, SmartyPage $smarty = null)
	{
		parent::__construct('Login', $server, $smarty);
		
		$this->_presenter = new LoginPresenter($this, $server);
	}

	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->_smarty->display('login.tpl');		
	}

	public function getEmailAddress()
	{
		return $this->_server->GetForm(FormKeys::EMAIL);
	}

	public function getPassword()
	{
		return $this->_server->GetForm(FormKeys::PASSWORD);
	}

	public function getPersistLogin()
	{
		return $this->_server->GetForm(FormKeys::PERSIST_LOGIN);
	}
	
	public function getShowRegisterLink()
	{
		return $this->_smarty->get_template_vars('ShowRegisterLink');
	}
	
	public function setShowRegisterLink($value)
	{
		$this->_smarty->assign('ShowRegisterLink', $value);	
	}
	
	public function setAvailableLanguages($languages)
	{
		$this->_smarty->assign('Languages', $languages);
	}
	
	public function getCurrentLanguage()
	{
		return $this->_server->GetForm(FormKeys::LANGUAGE);
	}
}
?>