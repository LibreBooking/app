<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'Presenters/ActivationPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IActivationPage extends IPage
{
	public function ShowSent();
	public function ShowError();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetActivationCode();
}

class ActivationPage extends ActionPage implements IActivationPage
{
	public function __construct()
	{
		parent::__construct('AccountActivation');

		$userRepo = new UserRepository();
		$this->_presenter = new ActivationPresenter($this, new AccountActivation($userRepo, $userRepo), new WebAuthentication(PluginManager::Instance()->LoadAuthentication()));
	}

	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad();
	}

	public function ProcessAction()
	{
		//$this->_presenter->Resend();
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	public function ShowSent()
	{
		$this->Display('Activation/activation-sent.tpl');
	}

	public function ShowError()
	{
		$this->Display('Activation/activation-error.tpl');
	}


	/**
	 * @return string
	 */
	public function GetActivationCode()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCOUNT_ACTIVATION_CODE);
	}
}

