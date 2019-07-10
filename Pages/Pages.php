<?php
/**
 * Copyright 2011-2019 Nick Korbel
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

class Pages
{
    const ID_DASHBOARD = 1;
    const ID_LOGIN = 5;

    const DEFAULT_HOMEPAGE_ID = self::ID_DASHBOARD;

    const ACTIVATION = 'activate.php';
    const CALENDAR = 'calendar.php';
    const CALENDAR_EXPORT = 'ical.php';
    const CALENDAR_SUBSCRIBE = 'ical-subscribe.php';
    const CALENDAR_SUBSCRIBE_ATOM = 'atom-subscribe.php';
    const CHECKOUT = 'checkout.php';
    const CREDITS = 'credits.php';
    const DASHBOARD = 'dashboard.php';
    const DISPLAY_RESOURCE = 'resource-display.php';
    const DEFAULT_LOGIN = 'dashboard.php';
    const GUEST_INVITATION_RESPONSES = 'guest-participation.php';
    const FORGOT_PASSWORD = 'forgot.php';
    const GUEST_RESERVATION = 'guest-reservation.php';
    const INVITATION_RESPONSES = 'participation.php';
    const LOGIN = 'index.php';
    const MANAGE_RESERVATIONS = 'manage_reservations.php';
    const MANAGE_GROUPS = 'manage_groups.php';
    const MANAGE_GROUPS_ADMIN = 'manage_admin_groups.php';
    const MANAGE_GROUP_RESERVATIONS = 'manage_group_reservations.php';
    const MY_CALENDAR = 'my-calendar.php';
    const OPENINGS = 'search-availability.php';
    const NOTIFICATION_PREFERENCES = 'notification-preferences.php';
    const PARTICIPATION = 'participation.php';
    const PASSWORD = 'password.php';
    const PROFILE = 'profile.php';
    const REPORTS_GENERATE = 'generate-report.php';
    const REPORTS_SAVED = 'saved-reports.php';
    const REPORTS_COMMON = 'common-reports.php';
    const RESERVATION = 'reservation.php';
    const RESERVATION_FILE = 'reservation-file.php';
    const RESOURCE_QR_ROUTER = 'resource-qr-router.php';
    const REGISTRATION = 'register.php';
    const SCHEDULE = 'schedule.php';
    const SEARCH_RESERVATIONS = 'search-reservations.php';
    const VIEW_CALENDAR = 'view-calendar.php';

    private static $_pages = array(
        1 => array('url' => Pages::DASHBOARD, 'name' => 'Dashboard'),
        2 => array('url' => Pages::SCHEDULE, 'name' => 'Schedule'),
        3 => array('url' => Pages::MY_CALENDAR, 'name' => 'MyCalendar'),
        4 => array('url' => Pages::CALENDAR, 'name' => 'ResourceCalendar'),
        5 => array('url' => Pages::LOGIN, 'name' => 'Login'),
    );

    private function __construct()
    {
    }

    public static function UrlFromId($pageId)
    {
        return self::$_pages[$pageId]['url'];
    }

    public static function NameFromId($pageId)
    {
        return self::$_pages[$pageId]['name'];
    }

    public static function GetAvailablePages()
    {
        return array_filter(self::$_pages, function($key) { return $key != Pages::ID_LOGIN; }, ARRAY_FILTER_USE_KEY);
    }
}
