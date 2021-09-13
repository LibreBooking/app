<?php

interface IReservationSlot
{
    /**
     * @return Time
     */
    public function Begin();

    /**
     * @return Time
     */
    public function End();

    /**
     * @return Date
     */
    public function BeginDate();

    /**
     * @return Date
     */
    public function EndDate();

    /**
     * @return Date
     */
    public function Date();

    /**
     * @return int
     *
     */
    public function PeriodSpan();

    /**
     * @return string
     */
    public function Label();

    /**
     * @return bool
     */
    public function IsReservable();

    /**
     * @return bool
     */
    public function IsReserved();

    /**
     * @return bool
     */
    public function IsPending();

    /**
     * @param $date Date
     * @return bool
     */
    public function IsPastDate(Date $date);

    /**
     * @return bool
     */
    public function RequiresCheckin();

    /**
     * @return int
     */
    public function AutoReleaseMinutes();

    /**
     * @return int
     */
    public function AutoReleaseMinutesRemaining();

    /**
     * @param string $timezone
     * @return IReservationSlot
     */
    public function ToTimezone($timezone);

    /**
     * @param UserSession $session
     * @return bool
     */
    public function IsOwnedBy(UserSession $session);

    /**
     * @param UserSession $session
     * @return bool
     */
    public function IsParticipating(UserSession $session);

    /**
     * @return string
     */
    public function BeginSlotId();

    /**
     * @return string
     */
    public function EndSlotId();

    /**
     * @return bool
     */
    public function HasCustomColor();

    /**
     * @return string
     */
    public function Color();

    /**
     * @return string
     */
    public function TextColor();

    /**
     * @param Date $date
     * @return bool
     */
    public function CollidesWith(Date $date);

    /**
     * @return string
     */
    public function Id();

    /**
     * @return int|null
     */
    public function OwnerId();

    /**
     * @return int[]
     */
    public function OwnerGroupIds();

    /**
     * @return bool
     */
    public function IsNew();

    /**
     * @return bool
     */
    public function IsUpdated();
}
