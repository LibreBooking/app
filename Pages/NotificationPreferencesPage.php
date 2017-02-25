<?php
/**
Copyright 2011-2017 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/NotificationPreferencesPresenter.php');

interface INotificationPreferencesPage extends IPage
{
    /**
     * @abstract
     * @param bool $enabled
     */
    public function SetEmailEnabled($enabled);

    /**
     * @abstract
     * @param bool $wantsApprovalEmails
     */
    public function SetApproved($wantsApprovalEmails);

    /**
     * @abstract
     * @param bool $wantsCreationEmails
     */
    public function SetCreated($wantsCreationEmails);

    /**
     * @abstract
     * @param bool $wantsUpdateEmails
     */
    public function SetUpdated($wantsUpdateEmails);

    /**
     * @abstract
     * @param bool $wantsDeleteEmails
     */
    public function SetDeleted($wantsDeleteEmails);

    /**
     * @abstract
     * @return bool
     */
    public function GetApproved();

    /**
     * @abstract
     * @return bool
     */
    public function GetCreated();

    /**
     * @abstract
     * @return bool
     */
    public function GetUpdated();

    /**
     * @abstract
     * @return bool
     */
    public function GetDeleted();

	/**
	 * @abstract
	 * @param bool $werePreferencesUpdated
	 */
	public function SetPreferencesSaved($werePreferencesUpdated);
}

class NotificationPreferencesPage extends SecurePage implements INotificationPreferencesPage
{
	/**
	 * @var NotificationPreferencesPresenter
	 */
	private $presenter;

	public function __construct()
	{
	    parent::__construct('NotificationPreferences');
		$this->presenter = new NotificationPreferencesPresenter($this, new UserRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('MyAccount/notification-preferences.tpl');
	}

    /**
     * @param bool $wantsApprovalEmails
     */
    public function SetApproved($wantsApprovalEmails)
    {
        $this->Set('Approved', $wantsApprovalEmails);
    }

    /**
     * @param bool $wantsCreationEmails
     */
    public function SetCreated($wantsCreationEmails)
    {
        $this->Set('Created', $wantsCreationEmails);
    }

    /**
     * @param $wantsUpdateEmails
     */
    public function SetUpdated($wantsUpdateEmails)
    {
       $this->Set('Updated', $wantsUpdateEmails);
    }

    /**
     * @param bool $wantsDeleteEmails
     */
    public function SetDeleted($wantsDeleteEmails)
    {
        $this->Set('Deleted', $wantsDeleteEmails);
    }

    /**
     * @return bool
     */
    public function GetApproved()
    {
        return (bool)$this->GetForm(ReservationEvent::Approved);
    }

    /**
     * @return bool
     */
    public function GetCreated()
    {
        return (bool)$this->GetForm(ReservationEvent::Created);
    }

    /**
     * @return bool
     */
    public function GetUpdated()
    {
        return (bool)$this->GetForm(ReservationEvent::Updated);
    }

    /**
     * @return bool
     */
    public function GetDeleted()
    {
        return (bool)$this->GetForm(ReservationEvent::Deleted);
    }

	/**
	 * @param bool $werePreferencesUpdated
	 */
	public function SetPreferencesSaved($werePreferencesUpdated)
	{
		$this->Set('PreferencesUpdated', $werePreferencesUpdated);
	}

    /**
     * @param bool $enabled
     */
    public function SetEmailEnabled($enabled)
    {
        $this->Set('EmailEnabled', $enabled);
    }

}

