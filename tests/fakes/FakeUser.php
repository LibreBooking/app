<?php
/**
Copyright 2011-2019 Nick Korbel

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

class FakeUser extends User
{
	public $_IsAdminForUser = false;
	public $_IsResourceAdmin = true;
    public $_ResourceAdminResourceIds = array();
    public $_WantsEmail;
    public $_Password;
    public $_Salt;
    public $_CurrentCredits;

    public function __construct($userId = null, $email = 'test@test.com')
	{
		$this->timezone = 'America/Chicago';
		$this->language = 'en_us';
		$this->emailAddress = $email;
		$this->id = $userId;
		$this->statusId = AccountStatus::ACTIVE;
		$this->homepageId = Pages::CALENDAR;
        $this->preferences = new UserPreferences();
	}

	public function SetStatus($statusId)
	{
		$this->statusId = $statusId;
	}

	public function SetLanguage($language)
	{
		$this->language = $language;
	}

	public function SetTimezone($timezone)
	{
		$this->timezone = $timezone;
	}

	/**
	 * @param $groups array|UserGroup[]
	 * @return void
	 */
	public function SetGroups($groups)
	{
		$this->groups = $groups;
	}

	public function WithPublicId($publicId)
	{
		$this->SetPublicId($publicId);
	}

	public function _SetIsAdminForUser($isAdminForUser)
	{
		$this->_IsAdminForUser = $isAdminForUser;
	}

	public function IsAdminFor(User $user)
	{
		return $this->_IsAdminForUser;
	}

	public function IsResourceAdminFor(IResource $resource)
	{
		return $this->_IsResourceAdmin || in_array($resource->GetId(), $this->_ResourceAdminResourceIds);
	}

	public function WantsEventEmail(IDomainEvent $event)
    {
        return $this->_WantsEmail;
    }

    public function ChangePassword($encryptedPassword, $salt)
    {
       $this->_Password = $encryptedPassword;
       $this->_Salt = $salt;
    }
}