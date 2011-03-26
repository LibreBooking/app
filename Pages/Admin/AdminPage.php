<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class AdminPage extends SecurePage
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
}
?>