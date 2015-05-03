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

require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Config/Configurator.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageConfigurationPresenter.php');

interface IManageConfigurationPage extends IActionPage
{
	/**
	 * @param bool $isPageEnabled
	 */
	public function SetIsPageEnabled($isPageEnabled);

	/**
	 * @param bool $isFileWritable
	 */
	public function SetIsConfigFileWritable($isFileWritable);

	/**
	 * @param ConfigSetting $configSetting
	 */
	public function AddSetting(ConfigSetting $configSetting);

	/**
	 * @param ConfigSetting $configSetting
	 */
	public function AddSectionSetting(ConfigSetting $configSetting);

	/**
	 * @return array|ConfigSetting[]
	 */
	public function GetSubmittedSettings();

	/**
	 * @param ConfigFileOption[] $configFiles
	 */
	public function SetConfigFileOptions($configFiles);

	/**
	 * @return string
	 */
	public function GetConfigFileToEdit();

	/**
	 * @param string $configFileName
	 */
	public function SetSelectedConfigFile($configFileName);

	/**
	 * @param string[] $homepageValues
	 * @param string[] $homepageOutput
	 */
	public function SetHomepages($homepageValues, $homepageOutput);
}

class ManageConfigurationPage extends ActionPage implements IManageConfigurationPage
{
	/**
	 * @var ManageConfigurationPresenter
	 */
	private $presenter;

	/**
	 * @var array|ConfigSetting[]
	 */
	private $settings;

	/**
	 * @var array|ConfigSetting[]
	 */
	private $sectionSettings;

	/**
	 * @var StringBuilder
	 */
	private $settingNames;

	public function __construct()
	{
		parent::__construct('ManageConfiguration', 1);
		$this->presenter = new ManageConfigurationPresenter($this, new Configurator());
		$this->settingNames = new StringBuilder();
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @return void
	 */
	public function ProcessPageLoad()
	{
		$this->Set('IsConfigFileWritable', true);

		$this->presenter->PageLoad();
		$this->Set('Settings', $this->settings);
		$this->Set('SectionSettings', $this->sectionSettings);
		$this->PopulateTimezones();
		$this->Set('Languages', Resources::GetInstance()->AvailableLanguages);
		$this->Set('SettingNames', $this->settingNames->ToString());

		$this->Display('Admin/Configuration/manage_configuration.tpl');
	}

	public function SetIsPageEnabled($isPageEnabled)
	{
		$this->Set('IsPageEnabled', $isPageEnabled);
	}

	/**
	 * @param bool $isFileWritable
	 */
	public function SetIsConfigFileWritable($isFileWritable)
	{
		$this->Set('IsConfigFileWritable', $isFileWritable);
	}

	/**
	 * @param ConfigSetting $configSetting
	 */
	public function AddSetting(ConfigSetting $configSetting)
	{
		$this->settings[] = $configSetting;
		$this->settingNames->Append($configSetting->Name . ',');
	}

	/**
	 * @param ConfigSetting $configSetting
	 */
	public function AddSectionSetting(ConfigSetting $configSetting)
	{
		$this->sectionSettings[$configSetting->Section][] = $configSetting;
		$this->settingNames->Append($configSetting->Name . ',');
	}

	private function PopulateTimezones()
	{
		$timezoneValues = array();
		$timezoneOutput = array();

		foreach ($GLOBALS['APP_TIMEZONES'] as $timezone)
		{
			$timezoneValues[] = $timezone;
			$timezoneOutput[] = $timezone;
		}

		$this->Set('TimezoneValues', $timezoneValues);
		$this->Set('TimezoneOutput', $timezoneOutput);
	}

	/**
	 * @return array|ConfigSetting[]
	 */
	public function GetSubmittedSettings()
	{
		$settingNames = $this->GetRawForm('setting_names');
		$settings = explode(',', $settingNames);
		$submittedSettings = array();
		foreach ($settings as $setting)
		{
			$setting = trim($setting);
			if (!empty($setting))
			{
//				Log::Debug("%s=%s", $setting, $this->GetForm($setting));
				$submittedSettings[] = ConfigSetting::ParseForm($setting, stripslashes($this->GetRawForm($setting)));
			}
		}

		return $submittedSettings;
	}

	public function SetHomepages($homepageValues, $homepageOutput)
	{
		$this->Set('HomepageValues', $homepageValues);
		$this->Set('HomepageOutput', $homepageOutput);
	}

	/**
	 * @param ConfigFileOption[] $configFiles
	 */
	public function SetConfigFileOptions($configFiles)
	{
		$this->Set('ConfigFiles', $configFiles);
	}

	/**
	 * @return string
	 */
	public function GetConfigFileToEdit()
	{
		return $this->GetQuerystring(QueryStringKeys::CONFIG_FILE);
	}

	/**
	 * @param string $configFileName
	 */
	public function SetSelectedConfigFile($configFileName)
	{
		$this->Set('SelectedFile', $configFileName);
	}
}