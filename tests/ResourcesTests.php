<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class ResourcesTests extends TestBase
{
	private $Resources;
	
	public function setUp()
	{	
		parent::setup();
		Resources::SetInstance(null);
	}
	
	public function tearDown()
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