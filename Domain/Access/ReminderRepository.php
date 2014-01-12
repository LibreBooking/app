<?php
/**
Copyright 2013-2014 Stephen Oliver, Nick Korbel

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

require_once (ROOT_DIR . 'Domain/Reminder.php');
require_once (ROOT_DIR . 'Domain/ReminderNotice.php');

class ReminderRepository implements IReminderRepository
{

	// select date_sub(start_date,INTERVAL rr.minutes_prior MINUTE) as reminder_date from reservation_instances ri INNER JOIN reservation_reminders rr on ri.series_id = rr.series_id

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

	/**
	 * @param Date $now
	 * @param ReservationReminderType $reminderType
	 * @return ReminderNotice[]|array
	 */
	public function GetReminderNotices(Date $now, $reminderType)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetReminderNoticesCommand($now->ToTheMinute(), $reminderType));

		$notices = array();
		while ($row = $reader->GetRow())
		{
			$notices[] = ReminderNotice::FromRow($row);
		}

		$reader->Free();
		return $notices;
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