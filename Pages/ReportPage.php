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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Presenters/ReportPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');


interface IReportPage extends IPage
{
	public function GetReportClicked();
		
	public function SetFirstName($firstName);
	public function SetLastName($lastName);
	public function SetUsername($username);	
	public function SetOrganization($organization);
	public function SetGroup($group);
	
	public function GetFirstName();
	public function GetLastName();
	public function GetUsername();	
	public function GetOrganization();
	public function GetGroup();
}

class ReportPage extends Page implements IReportPage
{
	public function __construct()
	{
		parent::__construct('Report');
		
		$this->_presenter = new ReportPresenter($this);			
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->smarty->display('reports.tpl');				
	}
	
	public function GetReportClicked()
	{
		return $this->GetForm(Actions::GET_REPORT);
	}

	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);	
	}
	
	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);	
	}	
		
	public function SetUsername($username)
	{
		$this->Set('Username', $username);	
	}	
	
	public function SetOrganization($organization)
    {
    	$this->Set('Organization', $organization);
    }

    public function SetGroup($group)
    {
    	$this->Set('Group', $group);
    }
		
	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}
	
	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}

	public function GetUsername()
	{
		return $this->GetForm(FormKeys::USERNAME);
	}

    public function GetOrganization()
    {
            return $this->GetForm(FormKeys::ORGANIZATION);
    }

    public function GetGroup()
    {
            return $this->GetForm(FormKeys::GROUP);
    }
}
?>