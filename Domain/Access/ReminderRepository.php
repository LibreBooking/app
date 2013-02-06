<?php
/**
Part of phpScheduleIt
written by Stephen Oliver
add this file to /Domain/Access
 */

require_once (ROOT_DIR . 'Domain/Reminder.php');

class ReminderRepository implements IReminderRepository
{
    public function GetAll()
    {
        $reminders = array();

        $reader = ServiceLocator::GetDatabase()->Query(new GetAllRemindersCommand());

        while ($row = $reader->GetRow())
        {
            $reminders[] = Reminder::FromRow($row);
        }
        $reader->Free();
        return $reminders;
    }

    /**
     * @param Reminder $reminder
     */
    public function Add(Reminder $reminder)
    {
        ServiceLocator::GetDatabase()->ExecuteInsert(new AddReminderCommand($reminder->UserID(), $reminder->Address(), $reminder->Message(), $reminder->SendTime(), $reminder->RefNumber()));
    }

    /**
     * @param string $user_id
     * @return Reminder[]
     */
    public function GetByUser($user_id)
    {
        $reminders = array();
        $reader = ServiceLocator::GetDatabase()->Query(new GetReminderByUserCommand($user_id));

        while ($row = $reader->GetRow())
        {
            $reminders[] = Reminder::FromRow($row);
        }

        $reader->Free();
        return $reminders;
    }

    /**
     * @param string $refnumber
     * @return Reminder[]
     */
    public function GetByRefNumber($refnumber)
    {
        $reminders = array();
        $reader = ServiceLocator::GetDatabase()->Query(new GetReminderByRefNumberCommand($refnumber));

        if ($row = $reader->GetRow())
        {
            $reminders = Reminder::FromRow($row);
        }

        $reader->Free();
        return $reminders;
    }

    /**
     * @param int $reminder_id
     */
    public function DeleteReminder($reminder_id)
    {
        ServiceLocator::GetDatabase()->Query(new DeleteReminderCommand($reminder_id));
    }
    /**
 * @param $user_id
 */
    public function DeleteReminderByUser($user_id)
    {
        ServiceLocator::GetDatabase()->Query(new DeleteReminderByUserCommand($user_id));
    }
    /**
     * @param $user_id
     */
    public function DeleteReminderByRefNumber($refnumber)
    {
        ServiceLocator::GetDatabase()->Query(new DeleteReminderByRefNumberCommand($refnumber));
    }

}

interface IReminderRepository
{

    /**
     * @abstract
     * @return Reminder[]|array
     */
    public function GetAll();

    /**
     * @abstract
     * @param Reminder $reminder
     */
    public function Add(Reminder $reminder);

    /**
     * @abstract
     * @param string $user_id
     * @return Reminder[]|array
     */
    public function GetByUser($user_id);

    /**
     * @abstract
     * @param string $refnumber
     * @return Reminder[]|array
     */
    public function GetByRefNumber($refnumber);

    /**
     * @abstract
     * @param int $reminder_id
     */
    public function DeleteReminder($reminder_id);

    /**
     * @abstract
     * @param $user_id
     */
    public function DeleteReminderByUser($user_id);

    /**
     * @abstract
     * @param $refnumber
     */
    public function DeleteReminderByRefNumber($refnumber);
}

?>