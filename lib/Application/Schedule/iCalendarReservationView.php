<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
	public $StartReminder;
	public $EndReminder;

	/**
	 * @param ReservationItemView|ReservationView $res
	 * @param UserSession $currentUser
	 * @param IPrivacyFilter $privacyFilter
	 */
	public function __construct($res, UserSession $currentUser, IPrivacyFilter $privacyFilter)
	{
		$canViewUser = $privacyFilter->CanViewUser($currentUser, $res, $res->OwnerId);
		$canViewDetails = $privacyFilter->CanViewDetails($currentUser, $res, $res->OwnerId);

		$privateNotice = 'Private';

		$this->DateCreated = $res->DateCreated;
		$this->DateEnd = $res->EndDate;
		$this->DateStart = $res->StartDate;
		$this->Description = $canViewDetails ? $res->Description : $privateNotice;
		$fullName = new FullName($res->OwnerFirstName, $res->OwnerLastName);
		$this->Organizer = $canViewUser ? $fullName->__toString() : $privateNotice;
		$this->OrganizerEmail = $canViewUser ? $res->OwnerEmailAddress : $privateNotice;
		$this->RecurRule = $this->CreateRecurRule($res);
		$this->ReferenceNumber = $res->ReferenceNumber;
		$this->Summary = $canViewDetails ? $res->Title : $privateNotice;
		$this->ReservationUrl = sprintf("%s/%s?%s=%s", Configuration::Instance()->GetScriptUrl(), Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $res->ReferenceNumber);
		$this->Location = $res->ResourceName;
		$this->StartReminder = $res->StartReminder;
		$this->EndReminder = $res->EndReminder;

		if ($res->OwnerId == $currentUser->UserId)
		{
			$this->OrganizerEmail = str_replace('@', '-noreply@', $res->OwnerEmailAddress);
		}
	}

	/**
	 * @param ReservationItemView|ReservationView $res
	 * @return null|string
	 */
	private function CreateRecurRule($res)
	{
		if (is_a($res, 'ReservationItemView'))
		{
			// don't populate the recurrance rule when a list of reservation is being exported
			return null;
		}
		### !!!  THIS DOES NOT WORK BECAUSE EXCEPTIONS TO RECURRENCE RULES ARE NOT PROPERLY HANDLED !!!
		### see bug report http://php.brickhost.com/forums/index.php?topic=11450.0

		if (empty($res->RepeatType) || $res->RepeatType == RepeatType::None)
		{
			return null;
		}

		$freqMapping = array(RepeatType::Daily => 'DAILY', RepeatType::Weekly => 'WEEKLY', RepeatType::Monthly => 'MONTHLY', RepeatType::Yearly => 'YEARLY');
		$freq = $freqMapping[$res->RepeatType];
		$interval = $res->RepeatInterval;
		$format = Resources::GetInstance()->GetDateFormat('ical');
		$end = $res->RepeatTerminationDate->SetTime($res->EndDate->GetTime())->Format($format);
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