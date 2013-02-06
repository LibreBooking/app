<?php

/**
Part of phpScheduleIt
written by Stephen Oliver
add this file to /Pages/Admin
 */

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageRemindersPresenter.php');

interface IManageRemindersPage extends IActionPage
{
    /**
     * @abstract
     * @return int
     */
    public function GetReminderId();

    /**
     * @abstract
     * @return string
     */
    public function GetUserId();

    /**
     * @abstract
     * @return string
     */
    public function GetMessage();

    /**
     * @abstract
     * @return Date
     */
    public function GetSendtime();

    /**
     * @abstract
     * @return string
     */
    public function GetAddress();

    /**
     * @abstract
     * @return string
     */
    public function GetRefNumber();

    /**
     * @abstract
     * @param $reminders ReminderDto[]
     * @return void
     */
    public function BindReminders($reminders);
}

class ManageRemindersPage extends ActionPage implements IManageRemindersPage
{
    /**
     * @var ManageRemindersPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('ManageReminders', 1);
        $this->presenter = new ManageRemindersPresenter($this, new ReminderRepository());
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad();

        $this->Display('Admin/manage_reminders.tpl');
    }

    public function BindReminders($reminders)
    {
        $this->Set('reminders', $reminders);
    }

    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    /**
     * @return int
     */
    public function GetReminderId()
    {
        return $this->GetQuerystring(QueryStringKeys::REMINDER_ID);
    }

    /**
     * @return string
     */
    public function GetUserId()
    {
        $user = ServiceLocator::GetServer()->GetUserSession();
        return $user->Email;
    }

    /**
     * @return string
     */
    public function GetMessage()
    {
        return $this->GetForm(FormKeys::REMINDER_MESSAGE);
    }

    /**
     * @return Date
     */
    public function GetSendtime()
    {
        return $this->GetForm(FormKeys::REMINDER_SENDTIME);
    }

    /**
     * @return string
     */
    public function GetAddress()
    {
        return $this->GetForm(FormKeys::REMINDER_ADDRESS);
    }

    /**
     * @return string
     */
    public function GetRefNumber()
    {
        return $this->GetForm(FormKeys::REMINDER_REFNUMBER);
    }

    public function ProcessDataRequest($dataRequest)
    {
        // no-op
    }

}
