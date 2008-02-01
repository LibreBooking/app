<?php
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Common/namespace.php');
//require_once(dirname(__FILE__) . '/../lib/Common/Validators/EmailValidator.php');
//require_once(dirname(__FILE__) . '/../Zend/Date.php');


class RegistrationPresenter
{
	private $_page;
	private $_registration;
	
	public function __construct(IRegistrationPage $page, IRegistration $registration)
	{
		$this->_page = $page;
		$this->_registration = $registration;
		
		if ($page->IsPostBack())
		{
			$this->LoadValidators();
		}
	}
	
	public function PageLoad()
	{		
		foreach($GLOBALS['APP_TIMEZONES'] as $timezone)
		{
			$timezoneValues[] = $timezone['Name'];			
			$timezoneOutput[] = sprintf('(GMT %s) %s', $this->FormatOffset($timezone['Offset']), $timezone['DisplayName']);
		
		}
		$this->_page->SetTimezones($timezoneValues, $timezoneOutput);
		$this->_page->SetTimezone(Configuration::GetKey(ConfigKeys::SERVER_TIMEZONE));
		$this->_page->SetFirstName(null);
	}
	
	public function Register()
	{
		$additionalFields = array($this->_page->GetPhone());
		
		$this->_registration->Register(
			$this->_page->GetLoginName(), 
			$this->_page->GetEmail(),
			$this->_page->GetFirstName(),
			$this->_page->GetLastName(),
			$this->_page->GetPassword(),
			$this->_page->GetPasswordConfirm(),
			$this->_page->GetTimezone(),
			$additionalFields);
	}
	
	private function FormatOffset($offset)
	{
		$hour = intval($offset);
		$decimalPartOfHour = abs($offset) - intval(abs($offset));
		$min = $decimalPartOfHour * 60;
		
		return sprintf("%+d:%02d", $hour, $min);
	}
	
	private function LoadValidators()
	{
		$this->_page->RegisterValidator('fname', new RequiredValidator($this->_page->GetFirstName()));
		$this->_page->RegisterValidator('lname', new RequiredValidator($this->_page->GetLastName()));
		$this->_page->RegisterValidator('passwordmatch', new EqualValidator($this->_page->GetPassword(), $this->_page->GetPasswordConfirm()));
		$this->_page->RegisterValidator('passwordcomplexity', new RegexValidator($this->_page->GetPassword(), Configuration::GetKey(ConfigKeys::PASSWORD_PATTERN)));
		$this->_page->RegisterValidator('emailformat', new EmailValidator($this->_page->GetEmail()));
		$this->_page->RegisterValidator('uniqueemail', new UniqueEmailValidator($this->_page->GetEmail()));
		
		if (Configuration::GetKey(ConfigKeys::USE_LOGON_NAME, new BooleanConverter()))
		{
			$this->_page->RegisterValidator('uniqueusername', new UniqueUserNameValidator($this->_page->GetLoginName()));		
		}
	}
}
?>