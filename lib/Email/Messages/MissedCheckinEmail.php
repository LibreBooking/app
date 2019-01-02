<?php
/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

class MissedCheckinEmail extends EmailMessage
{
    /**
     * @var ReservationItemView
     */
    private $reservation;

    public function __construct(ReservationItemView $reservation)
    {
        $this->reservation = $reservation;
        parent::__construct($reservation->OwnerLanguage);
    }

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function To()
    {
        return new EmailAddress($this->reservation->OwnerEmailAddress, new FullName($this->reservation->OwnerFirstName, $this->reservation->OwnerLastName));
    }

    public function Subject()
    {
        return $this->Translate('MissedCheckinEmailSubject', array($this->reservation->ResourceName));
    }

    public function Body()
    {
        $this->Set('StartDate', $this->reservation->StartDate->ToTimezone($this->reservation->OwnerTimezone));
        $this->Set('EndDate', $this->reservation->EndDate->ToTimezone($this->reservation->OwnerTimezone));
        $this->Set('ResourceName', $this->reservation->ResourceName);
        $this->Set('Title', $this->reservation->Title);
        $this->Set('Description', $this->reservation->Description);
        $this->Set('IsAutoRelease', $this->reservation->AutoReleaseMinutes != null);
        $this->Set('AutoReleaseTime', $this->reservation->StartDate->AddMinutes($this->reservation->AutoReleaseMinutes));
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER,
            $this->reservation->ReferenceNumber));

        return $this->FetchTemplate('MissedCheckinEmail.tpl');
    }
}