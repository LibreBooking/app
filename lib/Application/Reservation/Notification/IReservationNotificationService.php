<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

interface IReservationNotificationService
{
	/**
	 * @param $reservationSeries ReservationSeries|ExistingReservationSeries
	 * @return void
	 */
	function Notify($reservationSeries);
}

abstract class ReservationNotificationService implements IReservationNotificationService
{
	/**
	 * @var IReservationNotification[]
	 */
	protected $notifications;

	/**
	 * @param IReservationNotification[] $notifications
	 */
	public function __construct($notifications)
	{
		$this->notifications = $notifications;
	}

	/**
	 * @param $reservationSeries ReservationSeries|ExistingReservationSeries
	 * @return void
	 */
	public function Notify($reservationSeries)
	{
		$referenceNumber = $reservationSeries->CurrentInstance()->ReferenceNumber();

		foreach ($this->notifications as $notification)
		{
			try
			{
				Log::Debug("Calling notify on %s for reservation %s", get_class($notification), $referenceNumber);

				$notification->Notify($reservationSeries);
			}
			catch(Exception $ex)
			{
				Log::Error("Error sending notification of type %s for reservation %s. Exception: %s", get_class($notification), $referenceNumber, $ex);
			}
		}
	}
}