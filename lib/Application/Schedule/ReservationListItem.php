<?php

/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ReservationListItem
{
    /**
     * @var IReservedItemView
     */
    protected $item;

    public function __construct(IReservedItemView $reservedItem)
    {
        $this->item = $reservedItem;
    }

    /**
     * @return Date
     */
    public function StartDate()
    {
        return $this->item->GetStartDate();
    }

    /**
     * @return Date
     */
    public function EndDate()
    {
        return $this->item->GetEndDate();
    }

    /**
     * @return Date
     */
    public function BufferedStartDate()
    {
        if ($this->HasBufferTime()) {
            return $this->item->BufferedTimes()->GetBegin();
        }
        return $this->item->GetStartDate();
    }

    /**
     * @return Date
     */
    public function BufferedEndDate()
    {
        if ($this->HasBufferTime()) {
            return $this->item->BufferedTimes()->GetEnd();
        }
        return $this->item->GetEndDate();
    }

    public function OccursOn(Date $date)
    {
        return $this->item->OccursOn($date);
    }

    /**
     * @param SchedulePeriod $start
     * @param SchedulePeriod $end
     * @param Date $displayDate
     * @param int $span
     * @return IReservationSlot
     */
    public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
    {
        return new ReservationSlot($start, $end, $displayDate, $span, $this->item);
    }

    /**
     * @return int
     */
    public function ResourceId()
    {
        return $this->item->GetResourceId();
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->item->GetId();
    }

    public function IsReservation()
    {
        return true;
    }

    public function ReferenceNumber()
    {
        return $this->item->GetReferenceNumber();
    }

    /**
     * @return null|TimeInterval
     */
    public function BufferTime()
    {
        return $this->item->GetBufferTime();
    }

    /**
     * @return bool
     */
    public function HasBufferTime()
    {
        $bufferTime = $this->BufferTime();
        return !empty($bufferTime) && $bufferTime->TotalSeconds() > 0;
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function CollidesWith(Date $date)
    {
        if ($this->HasBufferTime()) {
            $range = new DateRange($this->StartDate()->SubtractInterval($this->BufferTime()),
                $this->EndDate()->AddInterval($this->BufferTime()));
        }
        else {
            $range = new DateRange($this->StartDate(), $this->EndDate());
        }

        return $range->Contains($date, false);
    }

    public function GetColor()
    {
        return $this->item->GetColor();
    }

    public function GetTextColor()
    {
        return $this->item->GetTextColor();
    }

    public function GetBorderColor()
    {
        return $this->item->GetBorderColor();
    }

    /**
     * @return string
     */
    public function GetTitle()
    {
        return $this->item->GetTitle();
    }

    /**
     * @return string
     */
    public function GetResourceName()
    {
        return $this->item->GetResourceName();
    }

    /**
     * @return string
     */
    public function GetUserName()
    {
        return $this->item->GetUserName();
    }

    public function RequiresCheckin()
    {
        return $this->item->RequiresCheckin();
    }

    /**
     * @param $currentUserId int
     * @param $timezone string
     * @return ReservationListItemDto
     */
    public function AsDto(int $currentUserId, string $timezone)
    {
        $dto = new ReservationListItemDto();
        $dto->StartDate = $this->StartDate()->Timestamp();
        $dto->EndDate = $this->EndDate()->Timestamp();
        $dto->BufferedStartDate = $this->BufferedStartDate()->Timestamp();
        $dto->BufferedEndDate = $this->BufferedEndDate()->Timestamp();
        $dto->Id = $this->Id();
        $dto->ReferenceNumber = $this->ReferenceNumber();
        $dto->ResourceId = $this->ResourceId();
        $dto->RequiresCheckin = $this->RequiresCheckin();
        $dto->BorderColor = $this->GetBorderColor();
        $dto->BackgroundColor = $this->GetColor();
        $dto->TextColor = $this->GetTextColor();
        $dto->IsReservation = $this->IsReservation();
        $dto->Label = $this->GetTitle();
        $dto->IsPending = $this->GetPending();
        $dto->IsNew = $this->GetIsNew();
        $dto->IsUpdated = $this->GetIsUpdated();
        $dto->IsOwner = $this->GetIsOwner($currentUserId);
        $dto->Label = $this->GetLabel();
        $dto->IsPast = $this->BufferedEndDate()->LessThan(Date::Now());
        $format = Resources::GetInstance()->GetDateFormat('period_time');
        $dto->StartTime = $this->StartDate()->ToTimezone($timezone)->Format($format);
        $dto->EndTime =  $this->EndDate()->ToTimezone($timezone)->Format($format);
//        if (is_a($this->item, 'ReservationItemView')) {
//            $dto->Label = SlotLabelFactory::Create($this->item);
//            $dto->IsPending = $this->item->RequiresApproval;
//            $dto->IsNew = $this->IsNew($this->item);
//            $dto->IsUpdated = $this->IsUpdated($this->item);
//            $dto->IsOwner = $this->item->OwnerId === $currentUserId;
//        }

        return $dto;
    }

    private function GetIsNew()
    {
        $newMinutes = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_UPDATE_HIGHLIGHT_MINUTES, new IntConverter());
        return $this->item->GetIsNew($newMinutes);
    }

    private function GetIsUpdated()
    {
        $updatedMinutes = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_UPDATE_HIGHLIGHT_MINUTES, new IntConverter());
        return $this->item->GetIsUpdated($updatedMinutes);
    }

    private function GetPending()
    {
        return $this->item->IsPending();
    }

    private function GetIsOwner(int $userId)
    {
        return $this->item->IsOwner($userId);
    }

    private function GetLabel()
    {
        return $this->item->GetLabel();
    }
}

class BufferItem extends ReservationListItem
{
    const LOCATION_BEFORE = 'begin';
    const LOCATION_AFTER = 'end';

    /**
     * @var string
     */
    private $location;

    /**
     * @var Date
     */
    private $startDate;

    /**
     * @var Date
     */
    private $endDate;

    public function __construct(ReservationListItem $item, $location)
    {
        parent::__construct($item->item);
        $this->item = $item;
        $this->location = $location;

        if ($this->IsBefore()) {
            $this->startDate = $this->item->StartDate()->SubtractInterval($this->item->BufferTime());
            $this->endDate = $this->item->StartDate();
        }
        else {
            $this->startDate = $this->item->EndDate();
            $this->endDate = $this->item->EndDate()->AddInterval($this->item->BufferTime());
        }
    }

    public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
    {
        return new BufferSlot($start, $end, $displayDate, $span, $this->item->item);
    }

    /**
     * @return Date
     */
    public function StartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Date
     */
    public function EndDate()
    {
        return $this->endDate;
    }

    private function IsBefore()
    {
        return $this->location == self::LOCATION_BEFORE;
    }

    public function OccursOn(Date $date)
    {
        return $this->item->OccursOn($date);
    }

    public function Id()
    {
        return $this->Id() . 'buffer_' . $this->location;
    }

    public function IsReservation()
    {
        return false;
    }

    public function HasBufferTime()
    {
        return false;
    }

    public function BufferTime()
    {
        return 0;
    }
}

class BlackoutListItem extends ReservationListItem
{
    protected $blackoutItem;

    public function __construct(BlackoutItemView $item)
    {
        $this->blackoutItem = $item;
        parent::__construct($item);
    }

    /**
     * @param SchedulePeriod $start
     * @param SchedulePeriod $end
     * @param Date $displayDate
     * @param int $span
     * @return IReservationSlot
     */
    public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
    {
        return new BlackoutSlot($start, $end, $displayDate, $span, $this->blackoutItem);
    }

    public function IsReservation()
    {
        return false;
    }
}

class ReservationListItemDto
{
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
    public $BufferedStartDate;
    /**
     * @var Date
     */
    public $BufferedEndDate;
    /**
     * @var int
     */
    public $Id;
    /**
     * @var string
     */
    public $ReferenceNumber;
    /**
     * @var int
     */
    public $ResourceId;
    /**
     * @var bool
     */
    public $RequiresCheckin;
    /**
     * @var string
     */
    public $BorderColor;
    /**
     * @var string|null
     */
    public $BackgroundColor;
    /**
     * @var string
     */
    public $TextColor;
    /**
     * @var bool
     */
    public $IsReservation;
    /**
     * @var string
     */
    public $Label;
    /**
     * @var bool
     */
    public $IsPending;
    /**
     * @var bool
     */
    public $IsNew;
    /**
     * @var bool
     */
    public $IsUpdated;
    /**
     * @var bool
     */
    public $IsOwner;
    /**
     * @var bool
     */
    public $IsPast;
    /**
     * @var string
     */
    public $StartTime;
    /**
     * @var string
     */
    public $EndTime;
}