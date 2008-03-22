<?php
require_once($root . 'lib/Common/namespace.php');
require_once($root . 'lib/Config/namespace.php');

class ResourcesTests extends TestBase
{
	private $Resources;
	
	public function setUp()
	{	
		parent::setup();
	}
	
	public function tearDown()
	{
		$this->Resources = null;
		Configuration::Reset();
		parent::teardown();
	}
	
	public function testLanguageIsLoadedCorrectlyFromCookie()
	{
		$jscalendarFile = 'calendar-en.js';
		$langFile = 'en_US.lang.php';		
		$lang = 'en_US';
		$langCookie = new Cookie(CookieKeys::LANGUAGE, $lang, time(), '/');
		
		$this->fakeServer->SetCookie($langCookie);
		
		$this->Resources = Resources::GetInstance();
		
		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($jscalendarFile, $this->Resources->CalendarLanguageFile);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
	
	public function testDefaultLanguageIsUsedIfCannotLoadFromCookie()
	{		
		$jscalendarFile = 'calendar-en.js';
		$langFile = 'en_US.lang.php';		
		$lang = 'en_US';
		
		Configuration::SetKey(ConfigKeys::LANGUAGE, $lang);
		
		$this->Resources = Resources::GetInstance();
		
		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($jscalendarFile, $this->Resources->CalendarLanguageFile);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
	
	public function testLanguageIsLoadedCorrectlyWhenSet()
	{
		$jscalendarFile = 'calendar-es.js';
		$langFile = 'es.lang.php';
		
		$lang = 'es';
		
		$this->Resources = Resources::GetInstance();
		$this->Resources->SetLanguage($lang);
		
		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($jscalendarFile, $this->Resources->CalendarLanguageFile);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
}
?>