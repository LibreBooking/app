<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ReportPresenter
{
	private $_page;
	private $_report;
	private $_auth;
	
	public function __construct(IReportPage $page, $report = null, $authorization = null)
	{
		$this->_page = $page;
		$this->SetReporting($report);
		$this->SetAuthorization($authorization);
				
		if ($page->IsPostBack())
		{
			//TODO fill the new values into the radio-buttons
		}
	}
	
	private function SetReporting($report)
	{
		if (is_null($report))
		{
			$this->_report = new Reporting();
		}
		else
		{
			$this->_report = $report;
		}
	}
			
	private function SetAuthorization($authorization)
	{
		if (is_null($authorization))
		{
			$this->_auth = PluginManager::Instance()->LoadAuthentication();
		}
		else
		{
			$this->_auth = $authorization;
		}
	}
	
	public function PageLoad()
	{			
		if ($this->_page->GetReportClicked())
		{
			$this->Report();
		}
		
	}
	
	public function Report()
	{
		if ($this->_page->IsValid())
	    {
	     
    		$this->_report->Report(
    			$this->_page->GetFirstName(),
    			$this->_page->GetLastName(),
    			$this->_page->GetUsername(), 
    			$this->_page->GetOrganization(),
    			$this->_page->GetGroup());
				
    		$this->_page->Redirect(Pages::DASHBOARD);
	    }
	}		
}
?>