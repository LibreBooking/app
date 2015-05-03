<?php
/**
Copyright 2013-2015 Nick Korbel

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


class Reminder
{
    private $user_id;
    private $reminder_id;
    private $reminderaddress;
    private $remindermessage;
    private $sendTime;
    private $refNumber;

    /**
     * @return string
     */
    public function UserID()
    {
        return $this->user_id;
    }
    /**
     * @return int
     */
    public function ReminderID()
    {
        return $this->reminder_id;
    }

    /**
     * @return string
     */
    public function Address()
    {
        return $this->reminderaddress;
    }

    /**
     * @return string
     */
    public function Message()
    {
        return $this->remindermessage;
    }

    /**
     * @return Date
     */
    public function SendTime()
    {
        return $this->sendTime;
    }

    /**
     * @return string
     */
    public function RefNumber()
    {
        return $this->refNumber;
    }


    public function __construct($id, $userid, $address, $message, $sendtime, $refnumber)
    {
        $this->reminder_id = $id;
        $this->user_id = $userid;
        $this->reminderaddress = $address;
        $this->remindermessage = $message;
        $this->sendTime = $sendtime;
        $this->refNumber = $refnumber;
    }

    public static function Create($id, $userid, $address, $message, $sendtime, $refnumber)
    {
        return new Reminder($id, $userid, $address, $message, $sendtime, $refnumber);
    }

    public static function FromRow($row)
    {
        return new Reminder(
            $row[ColumnNames::REMINDER_ID],
            $row[ColumnNames::REMINDER_USER_ID],
            $row[ColumnNames::REMINDER_ADDRESS],
            $row[ColumnNames::REMINDER_MESSAGE],
            $row[ColumnNames::REMINDER_SENDTIME],
            $row[ColumnNames::REMINDER_REFNUMBER]
        );
    }
    public static function SendItOut(Reminder $reminder){
        $message = $reminder->Message();
        $subject = "Automatic Reminder from Booked Scheduler";
	/* replace 'username' and 'password' with your GoogleVoice sign-in */
        $gv = new GoogleVoice("username", "password");
        $addresses = explode(',',str_replace(' ', '', $reminder->Address()));
        foreach($addresses as $address)
        {
            var_dump($address);
            if(ctype_digit($address))
            {
                $gv->sms($address,$message);
            }
            else
            {
                mail($address,$subject,$message);
            }
        }
        $repository = new ReminderRepository();
        $repository->DeleteReminder($reminder->ReminderID());
        return;
    }

}

?>