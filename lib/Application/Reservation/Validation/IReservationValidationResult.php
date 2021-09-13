<?php

interface IReservationValidationResult
{
    /**
     * @return bool
     */
    public function CanBeSaved();

    /**
     * @return string[]
     */
    public function GetErrors();

    /**
     * @return string[]
     */
    public function GetWarnings();

    /**
     * @return bool
     */
    public function CanBeRetried();

    /**
     * @return ReservationRetryParameter[]
     */
    public function GetRetryParameters();

    /**
     * @return string[]
     */
    public function GetRetryMessages();

    /**
     * @return bool
     */
    public function CanJoinWaitList();
}
