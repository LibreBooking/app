<?php
/**
Copyright 2012 Nick Korbel

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

class iCalendarReservationView
{
    public $DateCreated;
    public $DateEnd;
    public $DateStart;
    public $Description;
    public $Organizer;
    public $RecurRule;
    public $ReferenceNumber;
    public $Summary;
    public $ReservationUrl;
    public $Location;

    /**
     * @param ReservationItemView|ReservationView $res
     */
    public function __construct($res)
    {
        $this->DateCreated = $res->DateCreated;
        $this->DateEnd = $res->EndDate;
        $this->DateStart = $res->StartDate;
        $this->Description = $res->Description;
        $this->Organizer = $res->OwnerEmailAddress;
        $this->RecurRule = $this->CreateRecurRule($res);
        $this->ReferenceNumber = $res->ReferenceNumber;
        $this->Summary = $res->Title;
        $this->ReservationUrl = sprintf("%s/%s?%s=%s", Configuration::Instance()->GetScriptUrl(), Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $res->ReferenceNumber);
        $this->Location = $res->ResourceName;
    }

    /**
     * @param ReservationItemView|ReservationView $res
     * @return null|string
     */
    private function CreateRecurRule($res)
    {
        if (empty($res->RepeatType) || $res->RepeatType == RepeatType::None)
        {
            return null;
        }

        $freqMapping = array(RepeatType::Daily => 'DAILY', RepeatType::Weekly => 'WEEKLY', RepeatType::Monthly => 'MONTHLY', RepeatType::Yearly => 'YEARLY');
        $freq = $freqMapping[$res->RepeatType];
        $interval = $res->RepeatInterval;
        $format = Resources::GetInstance()->GetDateFormat('ical');
        $end = $res->RepeatTerminationDate->Format($format);
        $rrule = sprintf('FREQ=%s;INTERVAL=%s;UNTIL=%s', $freq, $interval, $end);

        if ($res->RepeatType == RepeatType::Monthly)
        {
            if ($res->RepeatMonthlyType == RepeatMonthlyType::DayOfMonth)
            {
                $rrule .= ';BYMONTHDAY=' . $res->StartDate->Day();
            }
        }

        if (!empty($res->RepeatWeekdays))
        {
            $dayMapping = array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');
            $days = '';
            foreach ($res->RepeatWeekdays as $weekDay)
            {
                $days .= ($dayMapping[$weekDay] . ',');
            }
            $days = substr($days, 0, -1);
            $rrule .= (';BYDAY=' . $days);
        }

        return $rrule;
    }
}

?>