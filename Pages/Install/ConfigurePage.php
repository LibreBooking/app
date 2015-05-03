<?php
/**
Copyright 2012-2015 Nick Korbel

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
require_once(ROOT_DIR . 'Presenters/Install/ConfigurePresenter.php');

interface IConfgurePage
{

	/**
	 * @abstract
	 * @param bool $isPasswordMissing
	 */
	public function SetPasswordMissing($isPasswordMissing);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetInstallPassword();

	/**
	 * @abstract
	 * @param bool $showPasswordPrompt
	 */
	public function SetShowPasswordPrompt($showPasswordPrompt);

	/**
	 * @abstract
	 * @param bool $showInvalidPassword
	 */
	public function SetShowInvalidPassword($showInvalidPassword);

	/**
	 * @abstract
	 */
	public function ShowConfigUpdateSuccess();

	/**
	 * @abstract
	 * @param string $manualConfig
	 */
	public function ShowManualConfig($manualConfig);
}

class ConfigurePage extends Page implements IConfgurePage
{
	/**
	 * @var ConfigurePresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('Install', 1);

		$this->presenter = new ConfigurePresenter($this, new InstallSecurityGuard());
	}

	public function PageLoad()
	{
		$this->Set('SuggestedInstallPassword', uniqid());
		$this->Set('ConfigSetting', '$conf[\'settings\'][\'install.password\']');
		$this->Set('ConfigPath', '/config/config.php');
		$this->presenter->PageLoad();
		$this->Display('Install/configure.tpl');
	}

	public function SetPasswordMissing($isPasswordMissing)
	{
		$this->Set('InstallPasswordMissing', $isPasswordMissing);
	}

	public function GetInstallPassword()
	{
		return $this->GetForm(FormKeys::INSTALL_PASSWORD);
	}

	public function SetShowPasswordPrompt($showPrompt)
	{
		$this->Set('ShowPasswordPrompt', $showPrompt);
	}

	public function SetShowInvalidPassword($showInvalidPassword)
	{
		$this->Set('ShowInvalidPassword', $showInvalidPassword);
	}

	public function SetShowDatabasePrompt($showDatabasePrompt)
	{
		$this->Set('ShowDatabasePrompt', $showDatabasePrompt);
	}

	public function ShowConfigUpdateSuccess()
	{
		$this->Set('ShowConfigSuccess', true);
	}

	/**
	 * @param string $manualConfig
	 */
	public function ShowManualConfig($manualConfig)
	{
		$this->Set('ShowManualConfig', true);
		$this->Set('ManualConfig', $manualConfig);
	}
}

?>