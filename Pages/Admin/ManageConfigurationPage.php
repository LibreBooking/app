<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Config/Configurator.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageConfigurationPresenter.php');

interface IManageConfigurationPage
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

	public function __construct()
	{
		parent::__construct('ManageConfiguration', 1);
		$this->presenter = new ManageConfigurationPresenter($this, new Configurator());
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		// no-op
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
		$this->presenter->PageLoad();
		$this->Set('Settings', $this->settings);
		$this->Set('SectionSettings', $this->sectionSettings);
		$this->PopulateTimezones();
		$this->Set('Languages', Resources::GetInstance()->AvailableLanguages);
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
	}

	/**
	 * @param ConfigSetting $configSetting
	 */
	public function AddSectionSetting(ConfigSetting $configSetting)
	{
		$this->sectionSettings[$configSetting->Section][] = $configSetting;
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
}

?>