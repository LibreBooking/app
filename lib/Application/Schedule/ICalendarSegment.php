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
	 * @param $reservations array|ReservationItemView[]
	 * @return void
	 */
	public function AddReservations($reservations);
}
?>