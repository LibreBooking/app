<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IForgotPwdPage extends IPage
{
	public function ResetClicked();
	public function ShowResetEmailSent($showResetEmailSent);

	public function GetEmailAddress();
	public function SetEnabled($enabled);
}

class ForgotPwdPage extends Page implements IForgotPwdPage
{
	private $_presenter = null;

	public function __construct()
	{
		parent::__construct('ForgotPassword');

		$this->_presenter = new ForgotPwdPresenter($this);
	}

	public function PageLoad()
	{
		$this->SetEnabled(true);
		$this->_presenter->PageLoad();

		$this->Display('forgot_pwd.tpl');
	}

	public function ResetClicked()
	{
		$reset = $this->GetForm(Actions::RESET);
		return !empty($reset);
	}

	public function GetEmailAddress()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function ShowResetEmailSent($showResetEmailSent)
	{
		$this->Set('ShowResetEmailSent', $showResetEmailSent);
	}

	public function SetEnabled($enabled)
	{
		$this->Set('Enabled', $enabled);
	}
}