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

require_once(ROOT_DIR . 'Pages/Admin/ManageConfigurationPage.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ConfigActions
{
	const Update = 'update';
}

class ManageConfigurationPresenter extends ActionPresenter
{
	/**
	 * @var IManageConfigurationPage
	 */
	private $page;

	/**
	 * @var IConfigurationSettings
	 */
	private $configSettings;

	/**
	 * @var
	 */
	private $configFilePath;

	public function __construct(IManageConfigurationPage $page, IConfigurationSettings $settings)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->configSettings = $settings;
		$this->configFilePath = ROOT_DIR . 'config/config.php';

		$this->AddAction(ConfigActions::Update, 'Update');
	}

	public function PageLoad()
	{
		$shouldShowConfig = Configuration::Instance()->GetSectionKey(ConfigSection::PAGES,
																	 ConfigKeys::PAGES_ENABLE_CONFIGURATION,
																	 new BooleanConverter());
		$this->page->SetIsPageEnabled($shouldShowConfig);

		if (!$shouldShowConfig)
		{
			Log::Debug('Show configuration UI is turned off. Not displaying the config values');
			return;
		}

		$isFileWritable = $this->configSettings->CanOverwriteFile($this->configFilePath);
		$this->page->SetIsConfigFileWritable($isFileWritable);

		if (!$isFileWritable)
		{
			Log::Debug('Config file is not writable');
			return;
		}

		Log::Debug('Loading and displaying config file for editing by %s',
				   ServiceLocator::GetServer()->GetUserSession()->Email);

		$settings = $this->configSettings->GetSettings($this->configFilePath);

		foreach ($settings as $key => $value)
		{
			if (is_array($value))
			{
				$section = $key;
				foreach ($value as $sectionkey => $sectionvalue)
				{
					if (!$this->ShouldBeSkipped($sectionkey, $section))
					{
						$this->page->AddSectionSetting(new ConfigSetting($sectionkey, $section, $sectionvalue));
					}
				}
			}
			else
			{
				if (!$this->ShouldBeSkipped($key))
				{
					$this->page->AddSetting(new ConfigSetting($key, null, $value));
				}
			}
		}

	}

	public function Update()
	{
		$shouldShowConfig = Configuration::Instance()->GetSectionKey(ConfigSection::PAGES,
																	 ConfigKeys::PAGES_ENABLE_CONFIGURATION,
																	 new BooleanConverter());

		if (!$shouldShowConfig)
		{
			Log::Debug('Show configuration UI is turned off. No updates are allowed');
			return;
		}

		$configSettings = $this->page->GetSubmittedSettings();

		$newSettings = array();

		foreach ($configSettings as $setting)
		{
			if (!empty($setting->Section))
			{
				$newSettings[$setting->Section][$setting->Key] = $setting->Value;
			}
			else
			{
				$newSettings[$setting->Key] = $setting->Value;
			}
		}

		$existingSettings = $this->configSettings->GetSettings($this->configFilePath);
		$mergedSettings = array_merge($existingSettings, $newSettings);

		Log::Debug("Saving %s settings", count($configSettings));
//		Log::Debug(var_export($mergedSettings, true));
		$this->configSettings->WriteSettings($this->configFilePath, $mergedSettings);
		Log::Debug('Config file saved by %s', ServiceLocator::GetServer()->GetUserSession()->Email);
	}

	private function ShouldBeSkipped($key, $section = null)
	{
		if ($section == ConfigSection::DATABASE || $section == ConfigSection::API)
		{
			return true;
		}
		switch ($key)
		{
			case ConfigKeys::INSTALLATION_PASSWORD:
			case ConfigKeys::PAGES_ENABLE_CONFIGURATION && $section == ConfigSection::PAGES:
				return true;
			default:
				return false;
		}
	}
}

class ConfigSetting
{
	public $Key;
	public $Section;
	public $Value;
	public $Type;
	public $Name;

	public function __construct($key, $section, $value)
	{
		$key = trim($key);
		$section = trim($section);
		$value = trim($value);

		$this->Name = $this->encode($key) . '|' . $this->encode($section);
		$this->Key = $key;
		$this->Section = $section;
		$this->Value = $value . '';

		$type = strtolower($value) == 'true' || strtolower($value) == 'false' ? ConfigSettingType::Boolean : ConfigSettingType::String;

		$this->Type = $type;

		if ($type == ConfigSettingType::Boolean)
		{
			$this->Value = strtolower($this->Value);
		}
	}

	public static function ParseForm($key, $value)
	{
		$k = self::decode($key);
		$keyAndSection = explode('|', $k);
		return new ConfigSetting($keyAndSection[0], $keyAndSection[1], $value);
	}

	private static function encode($value)
	{
		return str_replace('.', '__', $value);
	}

	private static function decode($value)
	{
		return str_replace('__', '.', $value);
	}
}

class ConfigSettingType
{
	const String = 'string';
	const Boolean = 'boolean';
}

?>