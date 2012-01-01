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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');

abstract class OwnerEmailNotification implements IReservationNotification
{
	/**
	 * @var IUserRepository
	 */
	private $_userRepo;
	
	/**
	 * @param IUserRepository $userRepo
	 */
	public function __construct(IUserRepository $userRepo)
	{
		$this->_userRepo = $userRepo;
	}

	/**
	 * @param ReservationSeries $reservation
	 * @return void
	 */
	public function Notify($reservation)
	{
		$owner = $this->_userRepo->LoadById($reservation->UserId());
		if ($this->ShouldSend($owner))
		{
			$resource = $reservation->Resource();
			
			$message = $this->GetMessage($owner, $reservation, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
	
	/**
	 * @abstract
	 * @param $owner User
	 * @return bool
	 */
	protected abstract function ShouldSend(User $owner);
	
	/**
	 * @abstract
	 * @param $owner User
	 * @param $reservation ReservationSeries
	 * @param $resource BookableResource
	 * @return EmailMessage
	 */
	protected abstract function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource);
}

class OwnerEmailCreatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationCreatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationCreatedEmail($owner, $reservation, $resource);	
	}	
}

class OwnerEmailUpdatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationUpdatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationUpdatedEmail($owner, $reservation, $resource);	
	}	
}

class OwnerEmailApprovedNotification extends OwnerEmailNotification
{
	/**
	 * @param $owner User
	 * @return bool
	 */
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationApprovedEvent());
	}

	/**
	 * @param $owner User
	 * @param $reservation ReservationSeries
	 * @param $resource BookableResource
	 * @return EmailMessage
	 */
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationApprovedEmail($owner, $reservation, $resource);
	}
}
?>