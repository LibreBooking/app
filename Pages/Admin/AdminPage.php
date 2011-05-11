<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');

interface IActionPage
{
	function TakingAction();
	function GetAction();
}

abstract class AdminPage extends SecurePage implements IActionPage
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

	public function RequestingData()
	{
		$dataRequest = $this->GetDataRequest();
		return !empty($dataRequest);
	}
	
	public function GetAction()
	{
		return $this->GetQuerystring(QueryStringKeys::ACTION);
	}

	public function GetDataRequest()
	{
		return $this->GetQuerystring(QueryStringKeys::DATA_REQUEST);
	}
	
	abstract function ProcessAction();
}
?>