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

require_once(ROOT_DIR . 'lib/Application/Reservation/Persistence/IReservationPersistenceService.php');

interface IUpdateReservationPersistenceService extends IReservationPersistenceService
{
	/**
	 * @param int $reservationInstanceId
	 * @return ExistingReservationSeries
	 */
	public function LoadByInstanceId($reservationInstanceId);

	/**
	 * @param string $referenceNumber
	 * @return ExistingReservationSeries
	 */
	public function LoadByReferenceNumber($referenceNumber);
}

class UpdateReservationPersistenceService implements IUpdateReservationPersistenceService
{
	/**
	 * @var IReservationRepository
	 */
	private $_repository;

	public function __construct(IReservationRepository $repository)
	{
		$this->_repository = $repository;
	}

	public function LoadByInstanceId($reservationInstanceId)
	{
		return $this->_repository->LoadById($reservationInstanceId);
	}

	public function Persist($existingReservationSeries)
	{
		$this->_repository->Update($existingReservationSeries);
	}

	public function LoadByReferenceNumber($referenceNumber)
	{
		return $this->_repository->LoadByReferenceNumber($referenceNumber);
	}
}