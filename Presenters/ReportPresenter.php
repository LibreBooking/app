<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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