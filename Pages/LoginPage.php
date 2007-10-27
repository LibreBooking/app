<?php
require_once('Page.php');
require_once(dirname(__FILE__) . '/../lib/Authorization/namespace.php');

interface ILoginPage extends IPage
{
	public function getEmailAddress();
	public function getPassword();
	public function getPersistLogin();
	public function getShowRegisterLink();
	public function setShowRegisterLink($value);
	public function setAvailableLanguages($languages);
	public function getCurrentLanguage();
	public function setUseLogonName($value);
	public function setResumeUrl($value);
	public function getResumeUrl();
	public function setShowLoginError();
}

class LoginPage extends Page implements ILoginPage
{
	private $_presenter = null;

	public function __construct(Server &$server, SmartyPage $smarty = null)
	{
		$title = sprintf('phpScheduleIt - %s', Resources::GetInstance($server)->GetString('Log In'));
		parent::__construct($title, $server, $smarty);
		
		$this->_presenter = new LoginPresenter($this, $server);
		$this->smarty->assign('ResumeUrl', $this->server->GetQuerystring(QueryStringKeys::REDIRECT));
	}

	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('login.tpl');		
	}

	public function getEmailAddress()
	{
		return $this->server->GetForm(FormKeys::EMAIL);
	}

	public function getPassword()
	{
		return $this->server->GetForm(FormKeys::PASSWORD);
	}

	public function getPersistLogin()
	{
		return $this->server->GetForm(FormKeys::PERSIST_LOGIN);
	}
	
	public function getShowRegisterLink()
	{
		return $this->smarty->get_template_vars('ShowRegisterLink');
	}
	
	public function setShowRegisterLink($value)
	{
		$this->smarty->assign('ShowRegisterLink', $value);	
	}
	
	public function setAvailableLanguages($languages)
	{
		$this->smarty->assign('Languages', $languages);
	}
	
	public function getCurrentLanguage()
	{
		return $this->server->GetForm(FormKeys::LANGUAGE);
	}
	
	public function setUseLogonName($value)
	{
		$this->smarty->assign('UseLogonName', $value);
	}
	
	public function setResumeUrl($value)
	{
		$this->smarty->assign('ResumeUrl', $value);
	}
	
	public function getResumeUrl()
	{
		return $this->server->GetForm(FormKeys::RESUME);
	}
	
	public function DisplayWelcome()
	{
		return false;
	}
	
	public function LoggingIn()
	{
		return $this->server->GetForm(Actions::LOGIN);
	}
	
	public function Login()
	{
		$this->_presenter->Login(new Authorization($this->server));
	}
	
	public function setShowLoginError()
	{
		$this->smarty->assign('ShowLoginError', true);
	}
}
?>