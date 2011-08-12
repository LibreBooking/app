<?php
interface ICalendarSegment
{
	/**
	 * @abstract
	 * @return Date
	 */
	public function FirstDay();

	/**
	 * @abstract
	 * @return Date
	 */
	public function LastDay();

	/**
	 * @abstract
	 * @param $reservations array|ReservationItemView[]
	 * @return void
	 */
	public function AddReservations($reservations);

	/**
	 * @abstract
	 * @return string|CalendarTypes
	 */
	public function GetType();

	/**
	 * @abstract
	 * @return Date
	 */
	public function GetPreviousDate();

	/**
	 * @abstract
	 * @return Date
	 */
	public function GetNextDate();
}
?>