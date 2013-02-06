<?php
/**
Part of phpScheduleIt
written by Stephen Oliver
add this file to /Presenters/Admin
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageReminderActions
{
	const Add = 'addReminder';
	const Change = 'changeReminder';
	const Delete = 'deleteReminder';
}

class ManageRemindersPresenter extends ActionPresenter
{
	/**
	 * @var IManageRemindersPage
	 */
	private $page;

	/**
	 * @var IReminderRepository
	 */
	private $reminderRepository;

	/**
	 * @param IManageRemindersPage $page
     * @param IReminderRepository $reminderRepository
	 */
	public function __construct(IManageRemindersPage $page, IReminderRepository $reminderRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->reminderRepository = $reminderRepository;

		$this->AddAction(ManageReminderActions::Add, 'AddReminder');
		$this->AddAction(ManageReminderActions::Change, 'ChangeReminder');
		$this->AddAction(ManageReminderActions::Delete, 'DeleteReminder');

	}

	public function PageLoad()
	{
        $reminders = $this->reminderRepository->GetAll();

		$this->page->BindReminders($reminders);
	}

	public function AddReminder()
	{
        $user = $this->page->GetUserId();
		$message = $this->page->GetMessage();
        $address = $this->page->GetAddress();
		$sendtime = $this->page->GetSendtime();

		$this->reminderRepository->Add(Reminder::Create(null, $user, $message, $address, Date::Now(), ''));
	}

	public function DeleteReminder()
	{
		$id = $this->page->GetReminderId();

		$this->reminderRepository->DeleteReminder($id);
	}
    /*
//THIS DOES NOT WORK YET, PLEASE DON'T TRY TO USE ITÉ
public function ChangeReminder()
{
    //nothing here yet
}
*/
}
?>