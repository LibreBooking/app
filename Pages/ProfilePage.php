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


require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ProfilePresenter.php');

interface IProfilePage extends IPage
{
	public function SetFirstName($firstName);

	public function SetLastName($lastName);

	public function SetEmail($email);
	
	public function SetUsername($username);

	public function SetTimezone($timezoneName);

	public function SetHomepage($homepageId);

	public function SetTimezones($timezoneValues, $timezoneOutput);

	public function SetHomepages($homepageValues, $homepageOutput);

	public function SetProfileUpdated();

	public function GetFirstName();

	public function GetLastName();

	public function GetEmail();

	public function GetLoginName();

	public function GetTimezone();

	public function GetHomepage();

	public function GetPhone();

	public function GetOrganization();

	public function GetPosition();

	public function SetPhone($phone);

	public function SetOrganization($organization);

	public function SetPosition($position);
}

class ProfilePage extends SecurePage implements IProfilePage
{
	/**
	 * @var \ProfilePresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('EditProfile');
		$this->presenter = new ProfilePresenter($this, new UserRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('profile.tpl');
	}

	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);
	}

	public function SetEmail($email)
	{
		$this->Set('Email', $email);
	}

	public function SetHomepage($homepageId)
	{
		$this->Set('Homepage', $homepageId);
	}

	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);
	}

	public function SetTimezone($timezoneName)
	{
		$this->Set('Timezone', $timezoneName);
	}

	public function SetHomepages($homepageValues, $homepageOutput)
	{
		$this->Set('HomepageValues', $homepageValues);
		$this->Set('HomepageOutput', $homepageOutput);
	}

	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->Set('TimezoneValues', $timezoneValues);
		$this->Set('TimezoneOutput', $timezoneOutput);
	}

	public function SetUsername($username)
	{
		$this->Set('Username', $username);
	}

	public function SetProfileUpdated()
	{
		$this->Set('ProfileUpdated', true);
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

	public function GetLoginName()
	{
		return $this->GetForm(FormKeys::USERNAME);
	}

	public function GetHomepage()
	{
		return $this->GetForm(FormKeys::DEFAULT_HOMEPAGE);
	}

	public function GetTimezone()
	{
		return $this->GetForm(FormKeys::TIMEZONE);
	}

	public function GetOrganization()
	{
		return $this->GetForm(FormKeys::ORGANIZATION);
	}

	public function GetPhone()
	{
		return $this->GetForm(FormKeys::PHONE);
	}

	public function GetPosition()
	{
		return $this->GetForm(FormKeys::POSITION);
	}

	public function SetOrganization($organization)
	{
		$this->Set('Organization', $organization);
	}

	public function SetPhone($phone)
	{
		$this->Set('Phone', $phone);
	}

	public function SetPosition($position)
	{
		$this->Set('Position', $position);
	}
}

?>