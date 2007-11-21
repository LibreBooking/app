<?php
require_once('Page.php');

interface IRegistrationPage extends IPage
{
	
}

class RegistrationPage implements IRegistrationPage
{
	public function __construct(SmartyPage $smarty = null)
	{
		$title = sprintf('phpScheduleIt - %s', Resources::GetInstance()->GetString('Register'));
		parent::__construct($title, $smarty);
		
		$this->_presenter = new RegistrationPresenter($this);
		$this->smarty->assign('ResumeUrl', $this->server->GetQuerystring(QueryStringKeys::REDIRECT));
		$this->smarty->assign('ShowLoginError', false);
	}
	
}
?>