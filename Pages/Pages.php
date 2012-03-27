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


class Pages {
    const DEFAULT_HOMEPAGE_ID = 1;

    const CALENDAR = 'calendar.php';
    const CALENDAR_EXPORT = 'ical.php';
    const CALENDAR_SUBSCRIBE = 'ical-subscribe.php';
    const DASHBOARD = 'dashboard.php';
    const DEFAULT_LOGIN = 'dashboard.php';
    const INVITATION_RESPONSES = 'participation.php';
    const LOGIN = 'index.php';
    const MANAGE_RESERVATIONS = 'manage_reservations.php';
    const MANAGE_GROUP_RESERVATIONS = 'manage_group_reservations.php';
    const MY_CALENDAR = 'my-calendar.php';
    const OPENINGS = 'openings.php';
    const NOTIFICATION_PREFERENCES = 'notification-preferences.php';
    const PARTICIPATION = 'participation.php';
    const PASSWORD = 'password.php';
    const PROFILE = 'profile.php';
    const RESERVATION = 'reservation.php';
    const REGISTRATION = 'register.php';
    const SCHEDULE = 'schedule.php';

    private static $_pages = array(
        1 => array('url' => Pages::DASHBOARD, 'name' => 'MyDashboard'),
        2 => array('url' => Pages::SCHEDULE, 'name' => 'Schedule'),
        3 => array('url' => Pages::MY_CALENDAR, 'name' => 'MyCalendar'),
        4 => array('url' => Pages::CALENDAR, 'name' => 'ResourceCalendar')
    );

    private function __construct() {
        // Constructor can be empty.
    }

    public static function UrlFromId($pageId) {
        return self::$_pages[$pageId]['url'];
    }

    public static function GetAvailablePages() {
        return self::$_pages;
    }

}

?>