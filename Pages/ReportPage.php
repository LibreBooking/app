<?php
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Presenters/ReportPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');


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