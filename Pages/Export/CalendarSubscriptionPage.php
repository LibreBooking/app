<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/CalendarSubscriptionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface ICalendarSubscriptionPage
{
    /**
     * @abstract
     * @return string
     */
    function GetSubscriptionKey();

    /**
     * @abstract
     * @return string
     */
    function GetUserId();

    /**
     * @abstract
     * @param array|iCalendarReservationView[] $reservations
     */
    function SetReservations($reservations);

    /**
     * @abstract
     * @return int
     */
    function GetScheduleId();

    /**
     * @abstract
     * @return int
     */
    function GetResourceId();
}

class CalendarSubscriptionPage extends Page implements ICalendarSubscriptionPage
{
    /**
     * @var CalendarSubscriptionPresenter
     */
    private $presenter;

    public function __construct()
    {
        $service = new CalendarSubscriptionService(new UserRepository(), new ResourceRepository(), new ScheduleRepository());
        $icalSubscriptionValidator = new CalendarSubscriptionValidator($this, $service);
        $this->presenter = new CalendarSubscriptionPresenter($this, new ReservationViewRepository(), $icalSubscriptionValidator, $service);
        parent::__construct('', 1);
    }

    public function GetSubscriptionKey()
    {
        return $this->GetQuerystring(QueryStringKeys::SUBSCRIPTION_KEY);
    }

    /**
     * @return string
     */
    public function GetUserId()
    {
        return $this->GetQuerystring(QueryStringKeys::USER_ID);
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();

        header("Content-Type: text/Calendar");
        header("Content-Disposition: inline; filename=calendar.ics");

        $config = Configuration::Instance();

        $this->Set('phpScheduleItVersion', $config->GetKey(ConfigKeys::VERSION));
        $this->Set('DateStamp', Date::Now());
        $this->Set('ScriptUrl', $config->GetScriptUrl());

        $this->Display('Export/ical.tpl');
    }

    /**
     * @param array|iCalendarReservationView[] $reservations
     */
    public function SetReservations($reservations)
    {
        $this->Set('Reservations', $reservations);
    }

    /**
     * @return int
     */
    public function GetScheduleId()
    {
        return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
    }

    /**
     * @return int
     */
    public function GetResourceId()
    {
        return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }
}

?>