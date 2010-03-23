<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class RegistrationMiniPresenter
{
	private $_page;
	private $_registration;
	private $_auth;
	
	public function __construct(IRegistrationMiniPage $page, $registration = null, $authorization = null)
	{
		$this->_page = $page;
		$this->SetRegistration($registration);
		$this->SetAuthorization($authorization);
				
		if ($page->IsPostBack())
		{
			$this->LoadValidators();
		}
	}
	
	private function SetRegistration($registration)
	{
		if (is_null($registration))
		{
			$this->_registration = new RegistrationMini();
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
		$this->BounceIfNotAllowingRegistration();
		
		if ($this->_page->RegisterClicked())
		{
			$this->RegisterMini();
		}
		
		$this->_page->SetUseLoginName(Configuration::Instance()->GetKey(ConfigKeys::USE_LOGON_NAME, new BooleanConverter()));

	}
	
	public function RegisterMini()
	{
		if ($this->_page->IsValid())
	    {
	      // TODO fix this in mysql insert $reghomepageId = 1;

    		$this->_registration->RegisterMini(
    			$this->_page->GetLoginName(), 
    			$this->_page->GetEmail(),
    			$this->_page->GetFirstName(),
    			$this->_page->GetLastName(),
    			$this->_page->GetPassword(),
                        date('e')); //TODO this should be set by the admin of the scheduler, not taken from the server
			//$reghomepageId); TODO this should default to 1, not 0 in mysql insert
    			
    		$this->_auth->Login($this->_page->GetEmail(), false);
    		$this->_page->Redirect(Pages::DASHBOARD);
	    }
	}
	
	private function BounceIfNotAllowingRegistration()
	{
		if (!Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter()))
		{
			$this->_page->Redirect(Pages::LOGIN);
		}
	}
	
	private function LoadValidators()
	{
		$this->_page->RegisterValidator('fname', new RequiredValidator($this->_page->GetFirstName()));
		$this->_page->RegisterValidator('lname', new RequiredValidator($this->_page->GetLastName()));
		$this->_page->RegisterValidator('passwordmatch', new EqualValidator($this->_page->GetPassword(), $this->_page->GetPasswordConfirm()));
		$this->_page->RegisterValidator('passwordcomplexity', new RegexValidator($this->_page->GetPassword(), Configuration::Instance()->GetKey(ConfigKeys::PASSWORD_PATTERN)));
		$this->_page->RegisterValidator('emailformat', new EmailValidator($this->_page->GetEmail()));
		$this->_page->RegisterValidator('uniqueemail', new UniqueEmailValidator($this->_page->GetEmail()));
		
		if (Configuration::Instance()->GetKey(ConfigKeys::USE_LOGON_NAME, new BooleanConverter()))
		{
			$this->_page->RegisterValidator('uniqueusername', new UniqueUserNameValidator($this->_page->GetLoginName()));		
		}
	}
}
?>