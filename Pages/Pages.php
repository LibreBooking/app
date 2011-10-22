<?php
class Pages
{
	const DEFAULT_HOMEPAGE_ID = 1;

	const CALENDAR = 'calendar.php';
	const DASHBOARD = 'dashboard.php';
	const DEFAULT_LOGIN = 'dashboard.php';
	const INVITATION_RESPONSES = 'participation.php';
	const LOGIN = 'index.php';
	const MY_CALENDAR = 'my-calendar.php';
	const OPENINGS = 'openings.php';
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
						4 => array('url' => Pages::CALENDAR, 'name' => 'ResourceCalendar'),
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