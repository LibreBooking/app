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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/Authentication/ILoginBasePage.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class ExternalAuthLoginPage extends Page implements ILoginBasePage
{
	public $presenter;

	public function __construct()
	{
		$this->presenter = new ExternalAuthLoginPresenter($this, new WebAuthentication(PluginManager::Instance()->LoadAuthentication()), new Registration());
		parent::__construct('Login');
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
	}

	/**
	 * @return string
	 */
	public function GetResumeUrl()
	{
        return $this->GetQuerystring(QueryStringKeys::REDIRECT);
	}

	/**
	 * @return null|string
	 */
	public function GetType()
	{
		return $this->GetQuerystring(QueryStringKeys::TYPE);
	}

	public function ShowError($messages)
	{
		$this->Set('Errors', $messages);
		$this->Display('ExternalAuth/external-login-error.tpl');
	}
}
