<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');

abstract class AdminPage extends SecurePage
{
	public function __construct($titleKey = '', $pageDepth = 1)
	{
		parent::__construct($titleKey, $pageDepth);
			
		$user = ServiceLocator::GetServer()->GetUserSession();
		
		if (!$user->IsAdmin)
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}
	
	public function Display($adminTemplateName)
	{
		$this->smarty->display('admin/' . $adminTemplateName);
	}
	
	public function TakingAction()
	{
		$action = $this->GetAction();
		return !empty($action);
	}
	
	public function GetAction()
	{
		return $this->server->GetQuerystring(QueryStringKeys::ACTION);
	}
	
	abstract function ProcessAction();
}
?>