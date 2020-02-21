<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/ActivationPage.php');

class ActivationPresenter
{
	/**
	 * @var IActivationPage
	 */
	private $page;

	/**
	 * @var IAccountActivation
	 */
	private $accountActivation;

	/**
	 * @var IWebAuthentication
	 */
	private $authentication;

	public function __construct(IActivationPage $page, IAccountActivation $accountActivation, IWebAuthentication $authentication)
	{
		$this->page = $page;
		$this->accountActivation = $accountActivation;
		$this->authentication = $authentication;
	}

	public function PageLoad()
	{
		$activationCode = $this->page->GetActivationCode();
		if(empty($activationCode))
		{
			$this->page->ShowSent();
		}
		else
		{
			$activationResult =	$this->accountActivation->Activate($activationCode);

			if ($activationResult->Activated())
			{
				$user = $activationResult->User();
				$this->authentication->Login($user->EmailAddress(), new WebLoginContext(new LoginData(false, $user->Language())));
				$this->page->Redirect(Pages::UrlFromId($user->Homepage()));
			}
			else
			{
				$this->page->ShowError();
			}
		}
	}
}

