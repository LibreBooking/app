<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Reservation/GuestReservationPage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/GuestAccountCreationEmail.php');

class GuestReservationPresenter extends ReservationPresenter
{
	/**
	 * @var IGuestReservationPage
	 */
	private $page;

	/**
	 * @var IRegistration
	 */
	private $registration;

	/**
	 * @var IWebAuthentication
	 */
	private $authentication;

	public function __construct(IGuestReservationPage $page,
								IRegistration $registration,
								IWebAuthentication $authentication,
								IReservationInitializerFactory $initializationFactory,
								INewReservationPreconditionService $preconditionService)
	{
		$this->page = $page;
		$this->registration = $registration;
		$this->authentication = $authentication;
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
			$this->LoadValidators();
			if ($this->page->IsCreatingAccount() && $this->page->IsValid())
			{
				$email = $this->page->GetEmail();
				Log::Debug('Creating a guest reservation as %s', $email);

				$currentLanguage = Resources::GetInstance()->CurrentLanguage;
				$this->registration->Register($email, $email, 'Guest', 'Guest', Password::GenerateRandom(), null, $currentLanguage, null);
				$this->authentication->Login($email, new WebLoginContext(new LoginData(false, $currentLanguage)));
				parent::PageLoad();
			}
		}
	}

	protected function LoadValidators()
	{
		$this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
		$this->page->RegisterValidator('uniqueemail', new UniqueEmailValidator(new UserRepository(), $this->page->GetEmail()));
	}
}