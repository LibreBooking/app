<?php
require_once(dirname(__FILE__) . '/../lib/SmartLoader.php');
require_once(dirname(__FILE__) . '/../lib/Common/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once('fakes/FakeServer.php');

class ResourcesTests extends PHPUnit_Framework_TestCase
{
	private $Resources;
	
	public function setUp()
	{	
	}
	
	public function tearDown()
	{
		$this->Resources = null;
		Configuration::Reset();
	}
	
	public function testLanguageIsLoadedCorrectlyFromCookie()
	{
		$jscalendarFile = 'calendar-en.js';
		$langFile = 'en_US.lang.php';		
		$lang = 'en_US';
		$langCookie = new Cookie(CookieKeys::COOKIE_LANGUAGE, $lang, time(), '/');
		
		$server = new FakeServer();
		$server->SetCookie($langCookie);
		
		$this->Resources = Resources::GetInstance($server);
		
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
		
		$server = new FakeServer();		
		$this->Resources = Resources::GetInstance($server);
		
		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($jscalendarFile, $this->Resources->CalendarLanguageFile);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
	
	public function testLanguageIsLoadedCorrectlyWhenSet()
	{
		$jscalendarFile = 'calendar-es.js';
		$langFile = 'es.lang.php';
		
		$lang = 'es';
		$server = new FakeServer();
		
		$this->Resources = Resources::GetInstance($server);
		$this->Resources->SetLanguage($lang);
		
		$this->assertEquals($lang, $this->Resources->CurrentLanguage);
		$this->assertEquals($jscalendarFile, $this->Resources->CalendarLanguageFile);
		$this->assertEquals($langFile, $this->Resources->LanguageFile);
	}
}
?>