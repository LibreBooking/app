<?php

/**
 * Copyright 2015 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Reservation/NewReservationPage.php');

interface IGuestReservationPage extends INewReservationPage
{
	public function GuestInformationCollected();
}

class GuestReservationPage extends NewReservationPage implements IGuestReservationPage
{
	public function PageLoad()
	{
		if (Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter()))
		{
			parent::PageLoad();
		}
		else {
			$this->RedirectToError(ErrorMessages::INSUFFICIENT_PERMISSIONS);
		}
	}

	protected function GetPresenter()
	{
		return new GuestReservationPresenter(
					$this,
					$this->initializationFactory,
					new NewReservationPreconditionService());
	}

	protected function GetTemplateName()
	{
		if ($this->GuestInformationCollected())
		{
			return parent::GetTemplateName();
		}

		return 'Reservation/collect-guest.tpl';
	}

	public function GuestInformationCollected()
	{
		return ServiceLocator::GetServer()->GetUserSession()->IsGuest();
	}
}

class GuestReservationPresenter extends ReservationPresenter
{
	/**
	 * @var IGuestReservationPage
	 */
	private $page;

	public function __construct(IGuestReservationPage $page, IReservationInitializerFactory $initializationFactory, INewReservationPreconditionService $preconditionService)
	{
		$this->page = $page;
		parent::__construct($page, $initializationFactory, $preconditionService);
	}

	public function PageLoad()
	{
		if ($this->page->GuestInformationCollected())
		{
			parent::PageLoad();
		}
		else
		{

		}
	}
}