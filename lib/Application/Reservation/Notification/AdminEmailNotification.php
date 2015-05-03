<?php
/**
 * Copyright 2011-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationDeletedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationRequiresApprovalEmailAdmin.php');

abstract class AdminEmailNotification implements IReservationNotification
{
	/**
	 * @var IUserRepository
	 */
	private $userRepo;

	/**
	 * @var IUserViewRepository
	 */
	private $userViewRepo;

	/**
	 * @var IAttributeRepository
	 */
	protected $attributeRepository;

	/**
	 * @param IUserRepository $userRepo
	 * @param IUserViewRepository $userViewRepo
	 * @param IAttributeRepository $attributeRepository
	 */
	public function __construct(IUserRepository $userRepo, IUserViewRepository $userViewRepo, IAttributeRepository $attributeRepository)
	{
		$this->userRepo = $userRepo;
		$this->userViewRepo = $userViewRepo;
		$this->attributeRepository = $attributeRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return void
	 */
	public function Notify($reservationSeries)
	{
		$resourceAdmins = array();
		$applicationAdmins = array();
		$groupAdmins = array();

		if ($this->SendForResourceAdmins($reservationSeries))
		{
			$resourceAdmins = $this->userViewRepo->GetResourceAdmins($reservationSeries->ResourceId());
		}
		if ($this->SendForApplicationAdmins($reservationSeries))
		{
			$applicationAdmins = $this->userViewRepo->GetApplicationAdmins();
		}
		if ($this->SendForGroupAdmins($reservationSeries))
		{
			$groupAdmins = $this->userViewRepo->GetGroupAdmins($reservationSeries->UserId());
		}

		$admins = array_merge($resourceAdmins, $applicationAdmins, $groupAdmins);

		if (count($admins) == 0)
		{
			// skip if there is nobody to send to
			return;
		}

		$owner = $this->userRepo->LoadById($reservationSeries->UserId());
		$resource = $reservationSeries->Resource();

		$adminIds = array();
		/** @var $admin UserDto */
		foreach ($admins as $admin)
		{
			$id = $admin->Id();
			if (array_key_exists($id, $adminIds) || $id == $owner->Id())
			{
				// only send to each person once
				continue;
			}
			$adminIds[$id] = true;

			$message = $this->GetMessage($admin, $owner, $reservationSeries, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}

	/**
	 * @return IEmailMessage
	 */
	protected abstract function GetMessage($admin, $owner, $reservationSeries, $resource);

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return bool
	 */
	protected abstract function SendForResourceAdmins(ReservationSeries $reservationSeries);

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return bool
	 */
	protected abstract function SendForApplicationAdmins(ReservationSeries $reservationSeries);

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return bool
	 */
	protected abstract function SendForGroupAdmins(ReservationSeries $reservationSeries);
}

class AdminEmailCreatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationCreatedEmailAdmin($admin, $owner, $reservationSeries, $resource, $this->attributeRepository);
	}

	protected function SendForResourceAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_CREATE_RESOURCE_ADMINS,
												 new BooleanConverter());
	}

	protected function SendForApplicationAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_CREATE_APPLICATION_ADMINS,
												 new BooleanConverter());
	}

	protected function SendForGroupAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_CREATE_GROUP_ADMINS,
												 new BooleanConverter());
	}
}

class AdminEmailUpdatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationUpdatedEmailAdmin($admin, $owner, $reservationSeries, $resource, $this->attributeRepository);
	}

	protected function SendForResourceAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_UPDATE_RESOURCE_ADMINS,
												 new BooleanConverter());
	}


	protected function SendForApplicationAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_UPDATE_APPLICATION_ADMINS,
												 new BooleanConverter());
	}

	protected function SendForGroupAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_UPDATE_GROUP_ADMINS,
												 new BooleanConverter());
	}
}

class AdminEmailDeletedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationDeletedEmailAdmin($admin, $owner, $reservationSeries, $resource, $this->attributeRepository);
	}

	protected function SendForResourceAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
														ConfigKeys::NOTIFY_DELETE_RESOURCE_ADMINS,
														new BooleanConverter());
	}


	protected function SendForApplicationAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
														ConfigKeys::NOTIFY_DELETE_APPLICATION_ADMINS,
														new BooleanConverter());
	}

	protected function SendForGroupAdmins(ReservationSeries $reservationSeries)
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
														ConfigKeys::NOTIFY_DELETE_GROUP_ADMINS,
														new BooleanConverter());
	}
}

class AdminEmailApprovalNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationRequiresApprovalEmailAdmin($admin, $owner, $reservationSeries, $resource, $this->attributeRepository);
	}

	protected function SendForResourceAdmins(ReservationSeries $reservationSeries)
	{
		return $reservationSeries->RequiresApproval() &&
		Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_APPROVAL_RESOURCE_ADMINS,
												 new BooleanConverter());
	}


	protected function SendForApplicationAdmins(ReservationSeries $reservationSeries)
	{
		return $reservationSeries->RequiresApproval() &&
		Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_APPROVAL_RESOURCE_ADMINS,
												 new BooleanConverter());
	}

	protected function SendForGroupAdmins(ReservationSeries $reservationSeries)
	{
		return $reservationSeries->RequiresApproval() &&
		Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
												 ConfigKeys::NOTIFY_APPROVAL_RESOURCE_ADMINS,
												 new BooleanConverter());
	}
}