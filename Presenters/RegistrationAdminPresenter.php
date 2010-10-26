<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class RegistrationAdminPresenter
{
	private $_page;
	private $_registration;
	private $_auth;
	
	public function __construct(IRegistrationAdminPage $page, $registration = null, $authorization = null)
	{
		$this->_page = $page;
		$this->SetRegistration($registration);
		$this->SetAuthorization($authorization);
				
		if ($page->IsPostBack())
		{
			//TODO fill the new values into the radio-buttons
		}
	}
	
	private function SetRegistration($registration)
	{
		if (is_null($registration))
		{
			$this->_registration = new RegistrationAdmin();
		}
		else
		{
			$this->_registration = $registration;
		}
	}
			
	private function SetAuthorization($authorization)
	{
		if (is_null($authorization))
		{
			$this->_auth = PluginManager::Instance()->LoadAuth();
		}
		else
		{
			$this->_auth = $authorization;
		}
	}
	
	public function PageLoad()
	{			
		if ($this->_page->SaveClicked())
		{
			$this->RegisterAdmin();
		}
		
	}
	
	public function RegisterAdmin()
	{
		if ($this->_page->IsValid())
	    {
	     
    		$this->_registration->RegisterAdmin(
    			$this->_page->GetFirstName(),
    			$this->_page->GetLastName(),
    			$this->_page->GetUsername(), 
    			$this->_page->GetEmail(),
    			$this->_page->GetPassword(),
    			$this->_page->GetOrganization(),
    			$this->_page->GetGroup(),
    			$this->_page->GetPosition(),
    			$this->_page->GetAddress(),
    			$this->_page->GetPhone(),
    			$this->_page->GetHomepage(),
                date('e'),
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE)); // = timezone, TODO this should be set by the admin of the scheduler, not taken from the server
				
    		$this->_page->Redirect(Pages::DASHBOARD);
	    }
	}		
}
?>