<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeScheduleReservations
{
	public static $Rows = array();
	
	/**
	 * @var ScheduleReservation
	 */
	public static $Reservation1;
	
	/**
	 * @var ScheduleReservation
	 */
	public static $Reservation2;
	
	/**
	 * @var ScheduleReservation
	 */
	public static $Reservation3;
	
	
	public static function Initialize()
	{
		self::$Reservation1 = new ScheduleReservation(1, 
														Date::Parse('2008-11-11 06:00:00', 'UTC'), 
														Date::Parse('2008-11-11 08:00:00', 'UTC'), 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l',
														'r1');
		self::$Reservation2 = new ScheduleReservation(2, 
														Date::Parse('2008-11-11 08:00:00', 'UTC'), 
														Date::Parse('2008-11-11 13:30:00', 'UTC'), 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l',
														'r2');
		self::$Reservation3 = new ScheduleReservation(3, 
														Date::Parse('2008-11-12 06:00:00', 'UTC'), 
														Date::Parse('2008-11-12 18:00:00', 'UTC'), 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l',
														'r3');
														
		self::$Rows[] = self::$Reservation1;
		self::$Rows[] = self::$Reservation2;
		self::$Rows[] = self::$Reservation3;
	}
}
?>