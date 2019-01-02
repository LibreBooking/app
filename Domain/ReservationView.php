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

class ReservationView
{
    public $ReservationId;
    public $SeriesId;
    public $ReferenceNumber;
    public $ResourceId;
    public $ResourceName;
    public $ScheduleId;
    public $StatusId;
    /**
     * @var Date
     */
    public $StartDate;
    /**
     * @var Date
     */
    public $EndDate;
    /**
     * @var Date
     */
    public $DateCreated;
    /**
     * @var Date
     */
    public $DateModified;
    /**
     * @var Date
     */
    public $CheckinDate;
    /**
     * @var Date
     */
    public $CheckoutDate;
    /**
     * @var Date
     */
    public $OriginalEndDate;
    public $OwnerId;
    public $OwnerEmailAddress;
    public $OwnerPhone;
    public $OwnerFirstName;
    public $OwnerLastName;
    public $Title;
    public $Description;
    /**
     * @var string|RepeatType
     */
    public $RepeatType;
    /**
     * @var int
     */
    public $RepeatInterval;
    /**
     * @var array
     */
    public $RepeatWeekdays;
    /**
     * @var string|RepeatMonthlyType
     */
    public $RepeatMonthlyType;
    /**
     * @var Date
     */
    public $RepeatTerminationDate;
    /**
     * @var int[]
     */
    public $AdditionalResourceIds = array();

    /**
     * @var ReservationResourceView[]
     */
    public $Resources = array();

    /**
     * @var ReservationUserView[]
     */
    public $Participants = array();

    /**
     * @var ReservationUserView[]
     */
    public $Invitees = array();

    /**
     * @var array|ReservationAccessoryView[]
     */
    public $Accessories = array();

    /**
     * @var array|AttributeValue[]
     */
    public $Attributes = array();

    /**
     * @var array|ReservationAttachmentView[]
     */
    public $Attachments = array();

    /**
     * @var ReservationReminderView|null
     */
    public $StartReminder;

    /**
     * @var ReservationReminderView|null
     */
    public $EndReminder;

    /**
     * @var string[]
     */
    public $ParticipatingGuests = array();

    /**
     * @var string[]
     */
    public $InvitedGuests = array();

    /**
     * @var bool
     */
    public $AllowParticipation = false;

    /**
     * @var int
     */
    public $CreditsConsumed;

    /**
     * @var bool
     */
    public $HasAcceptedTerms = false;

    /**
     * @var Date|null
     */
    public $TermsAcceptanceDate;

    public function __construct()
    {
        $this->CheckinDate = new NullDate();
        $this->CheckoutDate = new NullDate();
        $this->OriginalEndDate = new NullDate();
    }

    /**
     * @param AttributeValue $attribute
     */
    public function AddAttribute(AttributeValue $attribute)
    {
        $this->Attributes[$attribute->AttributeId] = $attribute;
    }

    /**
     * @param $attributeId int
     * @return mixed
     */
    public function GetAttributeValue($attributeId)
    {
        if (array_key_exists($attributeId, $this->Attributes))
        {
            return $this->Attributes[$attributeId]->Value;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function IsRecurring()
    {
        return $this->RepeatType != RepeatType::None;
    }

    /**
     * @return bool
     */
    public function IsDisplayable()
    {
        return true; // some qualification should probably be made
    }

    /**
     * @return bool
     */
    public function RequiresApproval()
    {
        return $this->StatusId == ReservationStatus::Pending;
    }

    /**
     * @param ReservationAttachmentView $attachment
     */
    public function AddAttachment(ReservationAttachmentView $attachment)
    {
        $this->Attachments[] = $attachment;
    }

    public function IsCheckinEnabled()
    {
        foreach ($this->Resources as $resource)
        {
            if ($resource->IsCheckInEnabled())
            {
                return true;
            }
        }

        return false;
    }

    public function IsCheckinAvailable()
    {
		$checkinMinutes = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_CHECKIN_MINUTES, new IntConverter());

        if ($this->CheckinDate->ToString() == '' && Date::Now()->AddMinutes($checkinMinutes)->GreaterThanOrEqual($this->StartDate))
        {
            return $this->IsCheckinEnabled();
        }

        return false;
    }

    public function IsCheckoutAvailable()
    {
        if ($this->StartDate->LessThan(Date::Now()) &&
            $this->CheckoutDate->ToString() == '' &&
            $this->CheckinDate->ToString() != '')
        {
            return $this->IsCheckinEnabled();
        }

        return false;
    }

    public function AutoReleaseMinutes()
    {
        $autoRelease = 0;
        foreach ($this->Resources as $resource)
        {
            $min = $resource->GetAutoReleaseMinutes();
            if (!empty($min) && ($autoRelease == 0 || $min < $autoRelease))
            {
                $autoRelease = $min;
            }
        }

        if (!empty($autoRelease))
        {
            return $autoRelease;
        }

        return null;
    }
}


class NullReservationView extends ReservationView
{
    /**
     * @var NullReservationView
     */
    private static $instance;

    public static function Instance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new NullReservationView();
        }

        return self::$instance;
    }

    public function IsDisplayable()
    {
        return false;
    }
}