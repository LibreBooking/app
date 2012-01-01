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

class ReservationNotificationFactory implements IReservationNotificationFactory
{
	/**
	 * @var array|string[]
	 */
	private $creationStrategies = array();
	
	public function __construct()
	{
		$this->creationStrategies[ReservationAction::Approve] = 'CreateApproveService';
		$this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
		$this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
		$this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
	}
	
	public function Create($reservationAction)
	{
		$userRepo = new UserRepository();
		$resourceRepo = new ResourceRepository();
				
		if (array_key_exists($reservationAction, $this->creationStrategies))
		{
			$createMethod = $this->creationStrategies[$reservationAction];
			return $this->$createMethod($userRepo, $resourceRepo);
		}

		return new NullReservationNotificationService();
	}
	
	private function CreateAddService($userRepo, $resourceRepo)
	{
		return new AddReservationNotificationService($userRepo, $resourceRepo);
	}

	private function CreateApproveService($userRepo, $resourceRepo)
	{
		return new ApproveReservationNotificationService($userRepo, $resourceRepo);
	}
	
	private function CreateDeleteService($userRepo, $resourceRepo)
	{
		return new DeleteReservationNotificationService();
	}
	
	private function CreateUpdateService($userRepo, $resourceRepo)
	{

		return new UpdateReservationNotificationService($userRepo, $resourceRepo);
	}
}

class NullReservationNotificationService implements IReservationNotificationService
{

	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries)
	{
		// no-op
	}
}
?>