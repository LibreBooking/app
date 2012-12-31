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

require_once(ROOT_DIR . 'Presenters/Admin/ManageConfigurationPresenter.php');

class ManageConfigurationPresenterTests extends TestBase
{
	/**
	 * @var ManageConfigurationPresenter
	 */
	private $presenter;

	/**
	 * @var FakeManageConfigurationPage
	 */
	private $page;

	/**
	 * @var IConfigurationSettings|PHPUnit_Framework_MockObject_MockObject
	 */
	private $configSettings;

	/**
	 * @var string
	 */
	private $configFilePath;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeManageConfigurationPage();
		$this->configSettings = $this->getMock('IConfigurationSettings');

		$this->configFilePath = ROOT_DIR . 'config/config.php';

		$this->presenter = new ManageConfigurationPresenter($this->page, $this->configSettings);
		$this->fakeConfig->SetSectionKey(ConfigSection::PAGES, ConfigKeys::PAGES_ENABLE_CONFIGURATION, 'true');
	}

	public function testDoesNothingIfPageIsNotEnabled()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PAGES, ConfigKeys::PAGES_ENABLE_CONFIGURATION, 'false');

		$this->presenter->PageLoad();

		$this->assertFalse($this->page->_PageEnabled);
	}

	public function testDoesNothingIfCannotOverwriteFile()
	{
		$this->configSettings->expects($this->once())
				->method('CanOverwriteFile')
				->with($this->equalTo($this->configFilePath))
				->will($this->returnValue(false));

		$this->presenter->PageLoad();

		$this->assertFalse($this->page->_ConfigFileWritable);
	}

	public function testPopulatesPageFromExistingValues()
	{
		$this->configSettings->expects($this->once())
				->method('CanOverwriteFile')
				->with($this->equalTo($this->configFilePath))
				->will($this->returnValue(true));

		$configValues = $this->getDefaultConfigValues();

		$this->configSettings->expects($this->once())
				->method('GetSettings')
				->with($this->equalTo($this->configFilePath))
				->will($this->returnValue($configValues));

		$this->presenter->PageLoad();

		$this->assertContains(new ConfigSetting('key', 'section', 'type'), $this->page->_Settings);
		$this->assertNotContains(new ConfigSetting('installkey', 'section', 'type'), $this->page->_Settings);
		$this->assertNotContains(new ConfigSetting('database keys', 'section', 'type'), $this->page->_Settings);
	}

	private function getDefaultConfigValues()
	{
		global $conf;
		return $conf[Configuration::SETTINGS];
	}
}

class FakeManageConfigurationPage implements IManageConfigurationPage
{
	/**
	 * @var bool
	 */
	public $_PageEnabled;

	/**
	 * @var bool
	 */
	public $_ConfigFileWritable;

	public function SetIsPageEnabled($isPageEnabled)
	{
		$this->_PageEnabled = $isPageEnabled;
	}

	/**
	 * @param bool $isFileWritable
	 */
	public function SetIsConfigFileWritable($isFileWritable)
	{
		$this->_ConfigFileWritable = $isFileWritable;
	}
}

?>