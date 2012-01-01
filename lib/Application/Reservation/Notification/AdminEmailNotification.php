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

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');

abstract class AdminEmailNotification implements IReservationNotification
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
	 * @param ReservationSeries $reservationSeries
	 * @return
	 */
	public function Notify($reservationSeries)
	{
		if (!$this->ShouldSend())
		{
			return;
		}

		$admins = $this->_userRepo->GetResourceAdmins($reservationSeries->ResourceId());
		$owner = $this->_userRepo->LoadById($reservationSeries->UserId());
		$resource = $reservationSeries->Resource();
			
		foreach ($admins as $admin)
		{
			$message = $this->GetMessage($admin, $owner, $reservationSeries, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}

	/**
	 * @return IEmailMessage
	 */
	protected abstract function GetMessage($admin, $owner, $reservationSeries, $resource);

	/**
	 * @return bool
	 */
	protected abstract function ShouldSend();
}

class AdminEmailCreatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationCreatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
	}
	
	protected function ShouldSend()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_NOTIFY_CREATED, new BooleanConverter());
	}
}

class AdminEmailUpdatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationUpdatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
	}
	
	protected function ShouldSend()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_NOTIFY_UPDATED, new BooleanConverter());
	}
}
?>