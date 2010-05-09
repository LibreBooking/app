<?php
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');

interface IForgotPwdPage extends IPage
{
	public function ResetClicked();

	public function getEmailAddress();
	public function getResumeUrl();
	public function setRandomPassword($value);
	public function setResumeUrl($value);
}

class ForgotPwdPage extends Page implements IForgotPwdPage
{
	private $_presenter = null;

	public function __construct()
	{
		parent::__construct('LogIn');
		
		$this->_presenter = new ForgotPwdPresenter($this);
		$this->smarty->assign('ResumeUrl', $this->server->GetQuerystring(QueryStringKeys::REDIRECT));
	}

	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('forgot_pwd.tpl');		
	}

	public function ResetClicked()
	{
		return $this->GetForm(Actions::RESET);
	}
	
	public function getEmailAddress()
	{
		return $this->server->GetForm(FormKeys::EMAIL);
	}

	public function setRandomPassword($value)
	{
		$this->smarty->assign('RandomPassword', $value);	
	}
		
	public function setResumeUrl($value)
	{
		$this->smarty->assign('ResumeUrl', $value);
	}
	
	public function getResumeUrl()
	{
		return $this->server->GetForm(FormKeys::RESUME);
	}
}
?>