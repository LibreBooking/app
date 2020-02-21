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

class ReservationPersistenceFactory implements IReservationPersistenceFactory
{
	private $services = array();
	private $creationStrategies = array();

	public function __construct()
	{
		$this->creationStrategies[ReservationAction::Approve] = 'CreateUpdateService';
		$this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
		$this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
		$this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
	}

	/**
	 * @param string $reservationAction
	 * @return IReservationPersistenceService
	 */
	public function Create($reservationAction)
	{
		if (!array_key_exists($reservationAction, $this->services))
		{
			$this->AddCachedService($reservationAction);
		}

		return $this->services[$reservationAction];
	}

	private function AddCachedService($reservationAction)
	{
		$createMethod = $this->creationStrategies[$reservationAction];
		$this->services[$reservationAction] = $this->$createMethod();
	}

	private function CreateAddService()
	{
		return new AddReservationPersistenceService(new ReservationRepository());
	}

	private function CreateDeleteService()
	{
		return new DeleteReservationPersistenceService(new ReservationRepository());
	}

	private function CreateUpdateService()
	{
		return new UpdateReservationPersistenceService(new ReservationRepository());
	}
}