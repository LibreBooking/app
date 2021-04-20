<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/NotificationPreferencesPresenter.php');

interface INotificationPreferencesPage extends IPage
{
    /**
     * @param bool $enabled
     */
    public function SetEmailEnabled($enabled);

    /**
     * @param bool $wantsApprovalEmails
     */
    public function SetApproved($wantsApprovalEmails);

    /**
     * @param bool $wantsCreationEmails
     */
    public function SetCreated($wantsCreationEmails);

    /**
     * @param bool $wantsUpdateEmails
     */
    public function SetUpdated($wantsUpdateEmails);

    /**
     * @param bool $wantsDeleteEmails
     */
    public function SetDeleted($wantsDeleteEmails);

    /**
     * @param bool $wantsSeriesEndingEmails
     */
    public function SetSeriesEnding($wantsSeriesEndingEmails);

    /**
     * @param bool $wantsParticipantChangedEmails
     */
    public function SetParticipantChanged($wantsParticipantChangedEmails);

    /**
     * @return bool
     */
    public function GetApproved();

    /**
     * @return bool
     */
    public function GetCreated();

    /**
     * @return bool
     */
    public function GetUpdated();

    /**
     * @return bool
     */
    public function GetDeleted();

    /**
     * @return bool
     */
    public function GetSeriesEnding();

    /**
     * @return bool
     */
    public function GetParticipantChanged();

    /**
     * @param bool $werePreferencesUpdated
     */
    public function SetPreferencesSaved($werePreferencesUpdated);

    /**
     * @param bool $enabled
     */
    public function SetParticipationEnabled($enabled);
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

    public function SetApproved($wantsApprovalEmails)
    {
        $this->Set('Approved', $wantsApprovalEmails);
    }

    public function SetCreated($wantsCreationEmails)
    {
        $this->Set('Created', $wantsCreationEmails);
    }

    public function SetUpdated($wantsUpdateEmails)
    {
        $this->Set('Updated', $wantsUpdateEmails);
    }

    public function SetDeleted($wantsDeleteEmails)
    {
        $this->Set('Deleted', $wantsDeleteEmails);
    }

    public function SetSeriesEnding($wantsSeriesEndingEmails)
    {
        $this->Set('SeriesEnding', $wantsSeriesEndingEmails);
    }

    public function SetParticipantChanged($wantsParticipantChangedEmails)
    {
        $this->Set('ParticipantChanged', $wantsParticipantChangedEmails);
    }

    public function GetApproved()
    {
        return (bool)$this->GetForm(ReservationEvent::Approved);
    }

    public function GetCreated()
    {
        return (bool)$this->GetForm(ReservationEvent::Created);
    }

    public function GetUpdated()
    {
        return (bool)$this->GetForm(ReservationEvent::Updated);
    }

    public function GetDeleted()
    {
        return (bool)$this->GetForm(ReservationEvent::Deleted);
    }

    public function GetSeriesEnding()
    {
        return (bool)$this->GetForm(ReservationEvent::SeriesEnding);
    }

    public function GetParticipantChanged()
    {
        return (bool)$this->GetForm(ReservationEvent::ParticipationChanged);
    }

    public function SetPreferencesSaved($werePreferencesUpdated)
    {
        $this->Set('PreferencesUpdated', $werePreferencesUpdated);
    }

    public function SetEmailEnabled($enabled)
    {
        $this->Set('EmailEnabled', $enabled);
    }

    public function SetParticipationEnabled($enabled)
    {
        $this->Set('ParticipationEnabled', $enabled);
    }
}
