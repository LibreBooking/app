<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/ViewCalendarPage.php');
$allowAnonymousSchedule = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter());

$page = new ViewCalendarPage();

$allowAnonymousSchedule = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter());
$allowGuestBookings = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter());
if (!$allowAnonymousSchedule && !$allowGuestBookings) {
    $page = new SecurePageDecorator($page);
}

$page->PageLoad();
