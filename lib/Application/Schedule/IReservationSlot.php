<?php

interface IReservationSlot
{
	/**
	 * @return Time
	 */
	public function Begin();
	
	/**
	 * @return Time
	 */
	public function End();
	
	/**
	 * @return int
	 *
	 */
	public function PeriodSpan();	
	
	/**
	 * @return string
	 */
	public function Label();
	
	/**
	 * @return bool
	 */
	public function IsReservable();
	
	/**
	 * @return bool
	 */
	public function IsReserved();
	
	/**
	 * @param string $timezone
	 * @return IReservationSlot
	 */
	public function ToTimezone($timezone);
}

?>