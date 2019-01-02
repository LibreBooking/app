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

require_once(ROOT_DIR . 'Presenters/Install/InstallSecurityGuard.php');
require_once(ROOT_DIR . 'lib/Config/Configurator.php');

class ConfigurePresenter
{
	/**
	 * @var IConfgurePage
	 */
	private $page;

	/**
	 * @var InstallSecurityGuard
	 */
	private $securityGuard;

	public function __construct(IConfgurePage $page, InstallSecurityGuard $securityGuard)
	{
		$this->page = $page;
		$this->securityGuard = $securityGuard;
	}

	public function PageLoad()
	{
		$this->CheckForInstallPasswordInConfig();
		$this->CheckForInstallPasswordProvided();

		$this->Configure();
	}

	private function CheckForInstallPasswordInConfig()
	{
		$this->page->SetPasswordMissing(!$this->securityGuard->CheckForInstallPasswordInConfig());
	}

	private function CheckForInstallPasswordProvided()
	{
		if ($this->securityGuard->IsAuthenticated())
		{
			return;
		}

		$installPassword = $this->page->GetInstallPassword();

		if (empty($installPassword))
		{
			$this->page->SetShowPasswordPrompt(true);
			return;
		}

		$validated = $this->Validate($installPassword);
		if (!$validated)
		{
			$this->page->SetShowPasswordPrompt(true);
			$this->page->SetShowInvalidPassword(true);
			return;
		}

		$this->page->SetShowPasswordPrompt(false);
		$this->page->SetShowInvalidPassword(false);
	}

	private function Validate($installPassword)
	{
		return $this->securityGuard->ValidatePassword($installPassword);
	}

	private function Configure()
	{
		if (!$this->securityGuard->IsAuthenticated())
		{
			return;
		}
		$user = ServiceLocator::GetServer()->GetUserSession();
		Log::Debug('Editing configuration file. Email=%s, UserId=%s', $user->Email, $user->UserId);

		$configFile = ROOT_DIR . 'config/config.php';
		$configDistFile = ROOT_DIR . 'config/config.dist.php';

		$configurator = new Configurator();

		if ($configurator->CanOverwriteFile($configFile))
		{
			$configurator->Merge($configFile, $configDistFile);
			$this->page->ShowConfigUpdateSuccess();
		}
		else
		{
			$manualConfig = $configurator->GetMergedString($configFile, $configDistFile);
			$this->page->ShowManualConfig($manualConfig);
		}
	}
}