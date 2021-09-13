<?php

interface INewReservationPreconditionService
{
    /**
     * @param INewReservationPage $page
     */
    public function CheckAll(INewReservationPage $page, UserSession $user);
}

interface IReservationPreconditionService
{
    /**
     * @param IReservationPage $page
     */
    public function CheckAll(IReservationPage $page, UserSession $user);
}
