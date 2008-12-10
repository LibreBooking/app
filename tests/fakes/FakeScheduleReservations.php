<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

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
														'2008-11-11', 
														'2008-11-11', 
														'06:00:00', 
														'08:00:00', 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l');
		self::$Reservation2 = new ScheduleReservation(3, 
														'2008-11-11', 
														'2008-11-11', 
														'08:00:00', 
														'13:30:00', 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l');
		self::$Reservation3 = new ScheduleReservation(3, 
														'2008-11-12', 
														'2008-11-12', 
														'06:00:00', 
														'08:00:00', 
														ReservationTypes::Reservation, 
														null, 
														null, 
														1, 
														1, 
														'f', 
														'l');
														
		self::$Rows[] = self::$Reservation1;
		self::$Rows[] = self::$Reservation2;
		self::$Rows[] = self::$Reservation3;
	}
}
?>