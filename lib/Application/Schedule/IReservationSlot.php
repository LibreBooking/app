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
	 * @return Date
	 */
	public function BeginDate();
	
	/**
	 * @return Date
	 */
	public function EndDate();
	
	/**
	 * @return Date
	 */
	public function Date();
	
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
	 * @return bool
	 */
	public function IsPending();
	
	/**
	 * @param $date Date
	 * @return bool
	 */
	public function IsPastDate(Date $date);
	
	/**
	 * @param string $timezone
	 * @return IReservationSlot
	 */
	public function ToTimezone($timezone);

	/**
	 * @abstract
	 * @param UserSession $session
	 * @return void
	 */
	public function IsOwnedBy(UserSession $session);
}

?>