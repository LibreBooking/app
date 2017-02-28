<?php
/**
Copyright 2012-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/RegistrationPage.php');

class FakeRegistrationPage extends FakePageBase implements IRegistrationPage
{
	public $_Timezone;
	public $_TimezoneValues;
	public $_TimezoneOutput;
	public $_HomepageValues;
	public $_HomepageOutput;
	public $_Homepage;
	public $_LoginName;
	public $_Email;
	public $_FirstName;
	public $_LastName;
	public $_PhoneNumber;
	public $_Password;
	public $_PasswordConfirm;
	public $_UseLoginName;
    public $_CaptchaUrl;
	public $_Action;
	public $_Attributes = array();

	/**
	 * @var array|AttributeFormElement[]
	 */
	public $_AttributeValues = array();

	public function __construct()
	{
		$this->_AttributeValues = array(new AttributeFormElement(1,2));
	}

	public function RegisterClicked()
	{
		return false;
	}

	public function SetUseLoginName($useLoginName)
	{
		$this->_UseLoginName = $useLoginName;
	}

	public function SetTimezone($timezone)
	{
		$this->_Timezone = $timezone;
	}

	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->_TimezoneValues = $timezoneValues;
		$this->_TimezoneOutput = $timezoneOutput;
	}

	public function SetHomepages($homepageValues, $homepageOutput)
	{
		$this->_HomepageValues = $homepageValues;
		$this->_HomepageOutput = $homepageOutput;
	}

	public function SetHomepage($homepage)
	{
		$this->_Homepage = $homepage;
	}

	public function SetLoginName($loginName)
	{
		$this->_LoginName = $loginName;
	}

	public function SetEmail($email)
	{
		$this->_Email = $email;
	}

	public function SetFirstName($firstName)
	{
		$this->_FirstName = $firstName;
	}

	public function SetLastName($lastName)
	{
		$this->_LastName = $lastName;
	}

	public function SetPhone($phoneNumber)
	{
		$this->_PhoneNumber = $phoneNumber;
	}

	public function SetInstitution($institution)
	{

	}

	public function SetPosition($positon)
	{

	}

	public function SetPassword($password)
	{
		$this->_Password = $password;
	}

	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->_PasswordConfirm = $passwordConfirm;
	}

	public function GetTimezone()
	{
		return $this->_Timezone;
	}

	public function GetHomepage()
	{
		return $this->_Homepage;
	}

	public function GetLoginName()
	{
		return $this->_LoginName;
	}

	public function GetEmail()
	{
		return $this->_Email;
	}

	public function GetFirstName()
	{
		return $this->_FirstName;
	}

	public function GetLastName()
	{
		return $this->_LastName;
	}

	public function GetPhone()
	{
		return $this->_PhoneNumber;
	}

	public function GetInstitution()
	{
		return '';
	}

	public function GetPosition()
	{
		return '';
	}

	public function GetPassword()
	{
		return $this->_Password;
	}

	public function GetPasswordConfirm()
	{
		return $this->_PasswordConfirm;
	}

	public function SetOrganization($organization)
	{
		// TODO: Implement SetOrganization() method.
	}

	public function GetOrganization()
	{
		// TODO: Implement GetOrganization() method.
	}

    public function SetCaptchaImageUrl($captchaUrl)
    {
        $this->_CaptchaUrl = $captchaUrl;
    }

    public function GetCaptcha()
    {
        // TODO: Implement GetCaptcha() method.
    }

	public function TakingAction()
	{
		return !empty($this->_Action);
	}

	public function GetAction()
	{
		return $this->_Action;
	}

	public function RequestingData()
	{
		// TODO: Implement RequestingData() method.
	}

	public function GetDataRequest()
	{
		// TODO: Implement GetDataRequest() method.
	}

	public function SetAttributes($attributeValues)
	{
		$this->_Attributes = $attributeValues;
	}

	/**
	 * @return array|AttributeValue[]
	 */
	public function GetAttributes()
	{
		return $this->_AttributeValues;
	}

	public function RedirectPage($url)
	{
		$this->_RedirectDestination = $url;
	}

}
?>