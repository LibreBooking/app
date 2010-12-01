<?php
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class SecurePage extends Page
{
	public function __construct($titleKey = '', $pageDepth = 0)
	{
		parent::__construct($titleKey, $pageDepth);
			
		if (!$this->IsAuthenticated())
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}
	
	private function GetResumeUrl()
	{
		return sprintf("%s?%s=%s", Pages::LOGIN, QueryStringKeys::REDIRECT, $this->server->GetUrl());
	}
}
?>