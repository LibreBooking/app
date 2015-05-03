<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Install/Installer.php');
require_once(ROOT_DIR . 'Presenters/Install/MySqlScript.php');
require_once(ROOT_DIR . 'Presenters/Install/InstallationResult.php');
require_once(ROOT_DIR . 'Presenters/Install/InstallSecurityGuard.php');

class InstallPresenter
{
	/**
	 * @var IInstallPage
	 */
	private $page;

	/**
	 * @var InstallSecurityGuard
	 */
	private $securityGuard;

	public function __construct(IInstallPage $page, InstallSecurityGuard $securityGuard)
	{
		$this->page = $page;
		$this->securityGuard = $securityGuard;
	}

	/**
	 * Get and Set data to be process by template engine
	 * @return void
	 */
	public function PageLoad()
	{
		if ($this->page->RunningInstall())
		{
			$this->RunInstall();
			return;
		}

		if ($this->page->RunningUpgrade())
		{
			$this->RunUpgrade();
			return;
		}

		$dbname = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
		$dbuser = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
		$dbhost = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);

		$this->page->SetDatabaseConfig($dbname, $dbuser, $dbhost);

		$this->CheckForInstallPasswordInConfig();
		$this->CheckForInstallPasswordProvided();
		$this->CheckForAuthentication();
		$this->CheckForUpgrade();
	}

	public function CheckForInstallPasswordInConfig()
	{
		$this->page->SetInstallPasswordMissing(!$this->securityGuard->CheckForInstallPasswordInConfig());
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

	private function CheckForAuthentication()
	{
		if ($this->securityGuard->IsAuthenticated())
		{
			$this->page->SetShowDatabasePrompt(true);
			return;
		}

		$this->page->SetShowDatabasePrompt(false);
	}


	private function Validate($installPassword)
	{
		return $this->securityGuard->ValidatePassword($installPassword);
	}

	private function RunInstall()
	{
		$install = new Installer($this->page->GetInstallUser(), $this->page->GetInstallUserPassword());

		$results = $install->InstallFresh($this->page->GetShouldCreateDatabase(), $this->page->GetShouldCreateUser(), $this->page->GetShouldCreateSampleData());
        $install->ClearCachedTemplates();

		$this->page->SetInstallResults($results);
	}

	private function RunUpgrade()
	{
		$install = new Installer($this->page->GetInstallUser(), $this->page->GetInstallUserPassword());
		$results = $install->Upgrade();
        $install->ClearCachedTemplates();

		$this->page->SetUpgradeResults($results, Configuration::VERSION);
	}

	private function CheckForUpgrade()
	{
		$install = new Installer($this->page->GetInstallUser(), $this->page->GetInstallUserPassword());
		$currentVersion = $install->GetVersion();

		if (!$currentVersion)
		{
			$this->page->ShowInstallOptions(true);
			return;
		}

		if (floatval($currentVersion) < floatval(Configuration::VERSION))
		{
			$this->page->SetCurrentVersion($currentVersion);
			$this->page->SetTargetVersion(Configuration::VERSION);
			$this->page->ShowUpgradeOptions(true);
		}
		else
		{
			$this->page->ShowUpToDate(true);
			$this->page->ShowInstallOptions(true);
		}
	}
}

?>