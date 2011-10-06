<?php
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginPresenterTests extends TestBase
{
	private $auth;
	private $page;
	
	public function setup()
	{
		parent::setup();
		
		$this->auth = new FakeAuth();		
		$this->page = new FakeLoginPage();
		
		$this->page->_EmailAddress = 'nkorbel@phpscheduleit.org';
		$this->page->_Password = 'somepassword';
		$this->page->_PersistLogin = true;
		
		$this->fakeServer->SetSession(SessionKeys::USER_SESSION, new UserSession(1));
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->auth = null;
		$this->page = null;
	}
	
	public function testLoginCallsAuthValidate() 
	{	
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->Login();
		
		$this->assertEquals($this->page->_EmailAddress, $this->auth->_LastLogin);
		$this->assertEquals($this->page->_Password, $this->auth->_LastPassword);
	}
	
	public function testSuccessfulValidateCallsLogin()
	{
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->Login();
		
		$this->assertEquals($this->page->_EmailAddress, $this->auth->_LastLogin);
		$this->assertEquals($this->page->_PersistLogin, $this->auth->_LastPersist);
	}

	public function testSuccessfulValidateCallsRedirectToNormalPageWhenNoRequestedPage()
	{
		$userSession = new UserSession(1);
		$userSession->HomepageId = 2;
		
		$this->fakeServer->UserSession = $userSession;
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->Login();
		
		$this->assertEquals(Pages::UrlFromId(2), $this->page->_LastRedirect);
	}
	
	public function testRedirectsToRequestedPage()
	{
		$redirect = '/someurl/something.php';
		$this->page->_ResumeUrl = $redirect;
		
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->Login();
		
		$this->assertEquals($redirect, $this->page->_LastRedirect);
	}
	
	public function testPageLoadSetsVariablesCorrectly()
	{
		$this->fakeConfig->SetKey(ConfigKeys::ALLOW_REGISTRATION, 'true');
		
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->PageLoad();
		
		$this->assertEquals(true, $this->page->getShowRegisterLink());
	}
	
	public function testPageLoadSetsLanguagesCorrect()
	{
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->PageLoad();
		
		$resources = Resources::GetInstance();
		$curLang = 'en_US';
		$resources->CurrentLanguage = $curLang;
		
		$langs = $this->page->_Languages;
		
		$this->assertEquals(count($langs), count($resources->AvailableLanguages));
		foreach ($resources->AvailableLanguages as $lang)
		{
			$this->assertEquals($langs[$lang->LanguageCode], $lang->DisplayName);
		}
	}	
		
	public function testErrorIsDisplayedIfValidationFails()
	{
		$this->auth->_ValidateResult = false;
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->Login();
		
		$this->assertEquals("", $this->page->_LastRedirect, "Does not redirect if auth fails");
		$this->assertTrue($this->page->_ShowLoginError, "Should show login error if auth fails");
	}
	
	public function testAutoLoginIfCookieIsSet()
	{
		$this->page->_ResumeUrl = '/autologin/page/whatever.html';
		$cookie = new Cookie(CookieKeys::PERSIST_LOGIN, "part1|part2");
		$this->fakeServer->SetCookie($cookie);
		
		$this->auth->_CookieValidateResult = true;
		
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->PageLoad();
		
		$this->assertTrue($this->auth->_CookieLoginCalled, "should try to auto login if persist cookie is set");
		$this->assertEquals($cookie->Value, $this->auth->_LastLoginCookie);
		$this->assertEquals($this->page->_ResumeUrl, $this->page->_LastRedirect);
	}
	
	public function testDoesNotAutoLoginIfCookieNotSet()
	{
		$this->page->_ResumeUrl = '/autologin/page/whatever.html';	
		$presenter = new LoginPresenter($this->page, $this->auth);
		$presenter->PageLoad();
		
		$this->assertFalse($this->auth->_CookieLoginCalled, "should not try to auto login without persist cookie");
	}
}

class FakeLoginPage extends FakePageBase implements ILoginPage
{
	public $_EmailAddress;
	public $_Password;
	public $_PersistLogin = false;
	public $_LastRedirect;
	public $_ShowRegisterLink;
	public $_PageLoadWasCalled = false;
	public $_Languages = array();
	public $_UseLogonName = false;
	public $_ResumeUrl = "";
	public $_ShowLoginError = false;
	
	public function PageLoad()
	{
		$this->_PageLoadWasCalled = true;
	}
	
	public function getEmailAddress()
	{ 
		return $this->_EmailAddress;
	}
	
	public function getPassword()
	{ 
		return $this->_Password;
	}
	
	public function getPersistLogin()
	{
		return $this->_PersistLogin;
	}
	
	public function getShowRegisterLink()
	{
		return $this->_ShowRegisterLink;
	}
	
	public function setShowRegisterLink($value)
	{
		$this->_ShowRegisterLink = $value;
	}
	
	public function Redirect($url)
	{
		$this->_LastRedirect = $url;
	}
	
	public function setAvailableLanguages($languages)
	{
		$this->_Languages = $languages;
	}
	
	public function getCurrentLanguage()
	{
		return $this->_CurrentCode;
	}
	
	public function getUseLogonName()
	{
		return $this->_UseLogonName;
	}
	
	public function setUseLogonName($value)
	{
		$this->_UseLogonName = $value;
	}
	
	public function setResumeUrl($value)
	{
		$this->_ResumeUrl = $value;
	}
	
	public function getResumeUrl()
	{
		return $this->_ResumeUrl;
	}
	
	public function setShowLoginError()
	{
		$this->_ShowLoginError = true;
	}
}
?>