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

class ManageConfigurationPresenter
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
		$this->page = $page;
		$this->configSettings = $settings;
		$this->configFilePath = ROOT_DIR . 'config/config.php';
		;
	}

	public function PageLoad()
	{
		$shouldShowConfig = Configuration::Instance()->GetSectionKey(ConfigSection::PAGES,
																	 ConfigKeys::PAGES_ENABLE_CONFIGURATION,
																	 new BooleanConverter());
		$this->page->SetIsPageEnabled($shouldShowConfig);

		if (!$shouldShowConfig)
		{
			return;
		}

		$isFileWritable = $this->configSettings->CanOverwriteFile($this->configFilePath);
		$this->page->SetIsConfigFileWritable($isFileWritable);

		if (!$isFileWritable)
		{
			return;
		}

		$settings = $this->configSettings->GetSettings($this->configFilePath);

		foreach ($settings as $key => $value)
		{
			if (is_array($value))
			{
				$section = $key;
				foreach ($value as $sectionkey => $sectionvalue)
				{
					if (!$this->ShouldBeSkipped($sectionkey))
					{
						$type = strtolower($sectionvalue) == 'true' || strtolower($sectionvalue) == 'false' ? ConfigSettingType::Boolean : ConfigSettingType::String;
						$this->page->AddSectionSetting(new ConfigSetting($sectionkey, $section, $sectionvalue, $type));
					}
				}
			}
			else
			{
				if (!$this->ShouldBeSkipped($key))
				{
					$type = strtolower($value) == 'true' || strtolower($value) == 'false' ? ConfigSettingType::Boolean : ConfigSettingType::String;
					$this->page->AddSetting(new ConfigSetting($key, null, $value, $type));
				}
			}
		}

	}

	private function ShouldBeSkipped($key)
	{
		switch ($key)
		{
			case ConfigKeys::DATABASE_HOSTSPEC:
			case ConfigKeys::DATABASE_NAME:
			case ConfigKeys::DATABASE_PASSWORD:
			case ConfigKeys::DATABASE_TYPE:
			case ConfigKeys::DATABASE_USER:
			case ConfigKeys::INSTALLATION_PASSWORD:
			case ConfigKeys::PAGES_ENABLE_CONFIGURATION:
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

	public function __construct($key, $section, $value, $type)
	{
		$this->Key = $key;
		$this->Section = $section;
		$this->Value = $value;
		$this->Type = $type;

		if ($type == ConfigSettingType::Boolean)
		{
			$this->Value = strtolower($this->Value);
		}
	}
}

class ConfigSettingType
{
	const String = 'string';
	const Boolean = 'boolean';
}

?>