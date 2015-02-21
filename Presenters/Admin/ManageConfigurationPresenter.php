<?php
/**
Copyright 2012-2014-2013 Nick Korbel

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

	private $deletedSettings = array('password.pattern');


	public function __construct(IManageConfigurationPage $page, IConfigurationSettings $settings)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->configSettings = $settings;
		$this->configFilePath = ROOT_DIR . 'config/config.php';
		$this->configFilePathDist = ROOT_DIR . 'config/config.dist.php';

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

		$configFiles = $this->GetConfigFiles();
		$this->page->SetConfigFileOptions($configFiles);

		$this->HandleSelectedConfigFile($configFiles);

		$isFileWritable = $this->configSettings->CanOverwriteFile($this->configFilePath);
		$this->page->SetIsConfigFileWritable($isFileWritable);

		if (!$isFileWritable)
		{
			Log::Debug('Config file is not writable');
			return;
		}

		Log::Debug('Loading and displaying config file for editing by %s',
				   ServiceLocator::GetServer()->GetUserSession()->Email);

		$this->BringConfigFileUpToDate();

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

		$this->PopulateHomepages();
	}

	private function PopulateHomepages()
	{
		$homepageValues = array();
		$homepageOutput = array();

		$pages = Pages::GetAvailablePages();
		foreach ($pages as $pageid => $page)
		{
			$homepageValues[] = $pageid;
			$homepageOutput[] = Resources::GetInstance()->GetString($page['name']);
		}

		$this->page->SetHomepages($homepageValues, $homepageOutput);
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

		$configFiles = $this->GetConfigFiles();
		$this->HandleSelectedConfigFile($configFiles);

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

		foreach ($this->deletedSettings as $deletedSetting)
		{
			if (array_key_exists($deletedSetting, $mergedSettings))
			{
				unset($mergedSettings[$deletedSetting]);
			}
		}

		Log::Debug("Saving %s settings", count($configSettings));

		$this->configSettings->WriteSettings($this->configFilePath, $mergedSettings);

		Log::Debug('Config file saved by %s', ServiceLocator::GetServer()->GetUserSession()->Email);
	}

	private function ShouldBeSkipped($key, $section = null)
	{
		if ($section == ConfigSection::DATABASE || $section == ConfigSection::API)
		{
			return true;
		}
		if (in_array($key, $this->deletedSettings))
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

	private function GetConfigFiles()
	{
		$files = array(new ConfigFileOption('config.php', ''));

		$pluginBaseDir = ROOT_DIR . 'plugins/';
		if ($h = opendir($pluginBaseDir))
		{
			while (false !== ($entry = readdir($h)))
			{
				$pluginDir = $pluginBaseDir . $entry;
				if (is_dir($pluginDir) && $entry != "." && $entry != "..")
				{
					$plugins = scandir($pluginDir);
					foreach ($plugins as $plugin)
					{
						if (is_dir("$pluginDir/$plugin") && $plugin != "." && $plugin != ".." && strpos($plugin,'Example') === false)
						{
							$configFiles = array_merge(glob("$pluginDir/$plugin/*.config.php"), glob("$pluginDir/$plugin/*.config.dist.php"));
							if (count($configFiles) > 0)
							{
								$files[] = new ConfigFileOption("$entry-$plugin", "$entry/$plugin");
							}
						}
					}
				}
			}

			closedir($h);
		}

		return $files;
	}

	private function HandleSelectedConfigFile($configFiles)
	{
		$requestedConfigFile = $this->page->GetConfigFileToEdit();
		if (!empty($requestedConfigFile))
		{
			/** @var $file ConfigFileOption */
			foreach ($configFiles as $file)
			{
				if ($file->Location == $requestedConfigFile)
				{
					$this->page->SetSelectedConfigFile($requestedConfigFile);

					$rootDir = ROOT_DIR . 'plugins/' . $requestedConfigFile;

					$distFile = glob("$rootDir/*config.dist.php");
					$configFile = glob("$rootDir/*config.php");
					if (count($distFile) == 1 && count($configFile) == 0)
					{
						copy($distFile[0], str_replace('.dist', '', $distFile[0]));
					}
					$configFile = glob("$rootDir/*config.php");
					$this->configFilePath = $configFile[0];
					$this->configFilePathDist = str_replace('.php', '.dist.php', $configFile[0]);
				}
			}
		}
	}

	private function BringConfigFileUpToDate()
	{
		if (!file_exists($this->configFilePathDist))
		{
			return;
		}

		$configurator = new Configurator();
		$configurator->Merge($this->configFilePath, $this->configFilePathDist);
	}
}

class ConfigFileOption
{
	public function __construct($name, $location)
	{
		$this->Name = $name;
		$this->Location = $location;
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