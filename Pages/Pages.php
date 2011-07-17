<?php
class Pages
{
	const DEFAULT_HOMEPAGE_ID = 1;

	const DASHBOARD = 'dashboard.php';
	const DEFAULT_LOGIN = 'dashboard.php';
	const INVITATION_RESPONSES = '';
	const LOGIN = 'index.php';
	const MY_CALENDAR = 'mycalendar.php';
	const PROFILE = 'profile.php';
	const RESERVATION = 'reservation.php';
	const SCHEDULE = 'schedule.php';
	const SCHEDULE_CALENDAR = 'schedulecalendar.php';

	private static $_pages = array(
						1 => array('url' => Pages::DASHBOARD, 'name' => 'MyDashboard'),
						2 => array('url' => Pages::SCHEDULE, 'name' => 'Schedule'),
						3 => array('url' => Pages::MY_CALENDAR, 'name' => 'MyCalendar'),
						4 => array('url' => Pages::SCHEDULE_CALENDAR, 'name' => 'ScheduleCalendar'),
						5 => array('url' => Pages::RESERVATION, 'name' => 'Reservation'),
						);
	
	private function __construct()
	{
	}
	
	public static function UrlFromId($pageId)
	{
		return self::$_pages[$pageId]['url'];
	}
	
	public static function GetAvailablePages()
	{
		return self::$_pages;
	}
}

?>