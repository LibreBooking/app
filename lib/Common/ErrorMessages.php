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

class ErrorMessages
{
	const UNKNOWN_ERROR = 0;
	const INSUFFICIENT_PERMISSIONS = 1;
	const MISSING_RESOURCE = 2;
	const MISSING_SCHEDULE = 3;
	const RESERVATION_NOT_FOUND = 4;
	const RESERVATION_NOT_AVAILABLE = 5;

	private $_resourceKeys = array();
	private static $_instance;

	private function __construct()
	{
		$this->SetKey(ErrorMessages::INSUFFICIENT_PERMISSIONS, 'InsufficientPermissionsError');
		$this->SetKey(ErrorMessages::MISSING_RESOURCE, 'MissingReservationResourceError');
		$this->SetKey(ErrorMessages::MISSING_SCHEDULE, 'MissingReservationScheduleError');
		$this->SetKey(ErrorMessages::RESERVATION_NOT_FOUND, 'ReservationNotFoundError');
		$this->SetKey(ErrorMessages::RESERVATION_NOT_AVAILABLE, 'ReservationNotAvailable');
	}

    /**
     * @static
     * @return ErrorMessages
     */
	public static function Instance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new ErrorMessages();
		}

		return self::$_instance;
	}

	private function SetKey($errorMessageId, $resourceKey)
	{
		$this->_resourceKeys[$errorMessageId] = $resourceKey;
	}

	public function GetResourceKey($errorMessageId)
	{
		if (!isset($this->_resourceKeys[$errorMessageId]))
		{
			return 'UnknownError';
		}

		return $this->_resourceKeys[$errorMessageId];
	}
}