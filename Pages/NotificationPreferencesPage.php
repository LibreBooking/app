<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/NotificationPreferencesPresenter.php');

interface INotificationPreferencesPage extends IPage
{
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
     * @param $wantsUpdateEmails
     */
    public function SetUpdated($wantsUpdateEmails);

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
		$this->Display('notification-preferences.tpl');
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
	 * @param bool $werePreferencesUpdated
	 */
	public function SetPreferencesSaved($werePreferencesUpdated)
	{
		$this->Set('PreferencesUpdated', $werePreferencesUpdated);
	}
}

?>