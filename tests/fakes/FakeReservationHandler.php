<?php

/**
 * Copyright 2017-2018 Nick Korbel
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

require_once(ROOT_DIR. 'lib/Application/Reservation/namespace.php');

class FakeReservationHandler implements IReservationHandler
{
	/**
	 * @var bool
	 */
	public $_Success = false;

	/**
	 * @var ReservationSeries
	 */
	public $_LastSeries;

	/**
	 * @var string[]
	 */
	public $_Errors = array();

	public function Handle($reservationSeries, IReservationSaveResultsView $view)
	{
		$this->_LastSeries = $reservationSeries;
		$view->SetErrors($this->_Errors);
		return $this->_Success;
	}
}