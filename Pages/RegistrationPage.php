<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'Presenters/RegistrationPresenter.php');
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IRegistrationPage extends IPage, IActionPage
{
	public function RegisterClicked();

	public function SetTimezones($timezoneValues, $timezoneOutput);
	public function SetTimezone($timezone);
	public function SetHomepages($homepageValues, $homepageOutput);
	public function SetHomepage($homepage);
	public function SetLoginName($loginName);
	public function SetEmail($email);
	public function SetFirstName($firstName);
	public function SetLastName($lastName);
	public function SetPhone($phoneNumber);
	public function SetOrganization($organization);
	public function SetPosition($position);
	public function SetPassword($password);
	public function SetPasswordConfirm($passwordConfirm);
    public function SetCaptchaImageUrl($captchaUrl);

	public function GetTimezone();
	public function GetHomepage();
	public function GetLoginName();
	public function GetEmail();
	public function GetFirstName();
	public function GetLastName();
	public function GetPhone();
	public function GetOrganization();
	public function GetPosition();
	public function GetPassword();
	public function GetPasswordConfirm();
	public function GetCaptcha();

	/**
	 * @abstract
	 * @param $attributeValues array|Attribute[]
	 */
	public function SetAttributes($attributeValues);

	/**
	 * @abstract
	 * @return AttributeFormElement[]
	 */
	public function GetAttributes();

	public function RedirectPage($url);
}

class RegistrationPage extends ActionPage implements IRegistrationPage
{
	public function __construct()
	{
		parent::__construct('Registration');

		$this->_presenter = new RegistrationPresenter($this);
	}

	public function ProcessPageLoad()
	{
        $this->Set('EnableCaptcha', Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_ENABLE_CAPTCHA, new BooleanConverter()));
		$this->_presenter->PageLoad();

		$this->Display('register.tpl');
	}

	public function RegisterClicked()
	{
		return $this->GetForm(Actions::REGISTER);
	}

	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->Set('TimezoneValues', $timezoneValues);
		$this->Set('TimezoneOutput', $timezoneOutput);
	}

	public function SetTimezone($timezone)
	{
		$this->Set('Timezone', $timezone);
	}

	public function SetHomepages($homepageValues, $homepageOutput)
	{
		$this->Set('HomepageValues', $homepageValues);
		$this->Set('HomepageOutput', $homepageOutput);
	}

	public function SetHomepage($homepage)
	{
		$this->Set('Homepage', $homepage);
	}

	public function SetLoginName($loginName)
	{
		$this->Set('LoginName', $loginName);
	}

	public function SetEmail($email)
	{
		$this->Set('Email', $email);
	}

	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);
	}

	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);
	}

	public function SetPhone($phoneNumber)
	{
		$this->Set('PhoneNumber', $phoneNumber);
	}

	public function SetOrganization($organization)
	{
       	$this->Set('Organization', $organization);
	}

	public function SetPosition($position)
	{
		$this->Set('Position', $position);
	}

	public function SetPassword($password)
	{
		$this->Set('Password', $password);
	}

	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->Set('PasswordConfirm', $passwordConfirm);
	}

	public function GetTimezone()
	{
		return $this->GetForm(FormKeys::TIMEZONE);
	}

	public function GetHomepage()
	{
		return $this->GetForm(FormKeys::DEFAULT_HOMEPAGE);
	}

	public function GetLoginName()
	{
		return $this->GetForm(FormKeys::LOGIN);
	}

	public function GetEmail()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}

	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}

	public function GetPhone()
	{
		return $this->GetForm(FormKeys::PHONE);
	}

	public function GetOrganization()
	{
		return $this->GetForm(FormKeys::ORGANIZATION);
	}

	public function GetPosition()
	{
		return $this->GetForm(FormKeys::POSITION);
	}

	public function GetPassword()
	{
		return $this->GetRawForm(FormKeys::PASSWORD);
	}

	public function GetPasswordConfirm()
	{
		return $this->GetRawForm(FormKeys::PASSWORD_CONFIRM);
	}

    public function SetCaptchaImageUrl($captchaUrl)
    {
        $this->Set('CaptchaImageUrl', $captchaUrl);
    }

    public function GetCaptcha()
    {
        return $this->GetForm(FormKeys::CAPTCHA);
    }

	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	public function SetAttributes($attributeValues)
	{
		$this->Set('Attributes', $attributeValues);
	}

	public function Redirect($url)
	{
		$this->SetJson(array('url' => $url));
	}

	public function RedirectPage($url)
	{
		parent::Redirect($url);
	}

	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}
}
?>