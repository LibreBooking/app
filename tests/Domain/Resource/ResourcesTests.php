<?php
/**
Copyright 2011-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class ResourcesTests extends TestBase
{
	private $Resources;

	public function setUp(): void
	{
		parent::setup();
		Resources::SetInstance(null);
	}

	public function teardown(): void
	{
		$this->Resources = null;
		parent::teardown();
	}

	public function testLanguageIsLoadedCorrectlyFromCookie()
	{
		$langFile = 'en_us.php';
		$lang = 'en_us';
		$langCookie = new Cookie(CookieKeys::LANGUAGE, $lang, time(), '/');

		$this->fakeServer->SetCookie($langCookie);

		$this->Resources = Resources::GetInstance();

		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}

	public function testDefaultLanguageIsUsedIfCannotLoadFromCookie()
	{
		$langFile = 'en_us.php';
		$lang = 'en_us';

		$this->fakeConfig->SetKey(ConfigKeys::LANGUAGE, $lang);

		$this->Resources = Resources::GetInstance();

		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}

	public function testLanguageIsLoadedCorrectlyWhenSet()
	{
		$langFile = 'en_us.php';
		$lang = 'en_us';

		$this->Resources = Resources::GetInstance();
		$this->Resources->SetLanguage($lang);

		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
}
?>