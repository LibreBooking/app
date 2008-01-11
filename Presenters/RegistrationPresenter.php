<?php
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Common/namespace.php');
require_once('Validators/EmailValidator.php');
//require_once(dirname(__FILE__) . '/../Zend/Date.php');


class RegistrationPresenter
{
	private $_page;
	private $_registration;
	private $_validators;
	
	public function __construct(IRegistrationPage $page, IRegistration $registration)
	{
		$this->_page = $page;
		$this->_registration = $registration;
		
		// if is post back
		$this->LoadValidators();
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
	}
	
	public function IsValid()
	{
		foreach ($this->_validators as $validator)
		{
			if (!$validator->IsValid())
			{
				return false;
			}
		}
		return true;
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
		$this->_validators = array();
		$this->_validators[] = new EmailValidator($this->_page->GetEmail());
		
		// add required field validators
	}
}
?>