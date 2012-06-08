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

class PostRegistrationTests extends TestBase
{
	/**
	 * @var FakeRegistrationPage
	 */
	private $page;

	/**
	 * @var FakeAuth
	 */
	private $fakeAuth;

	/**
	 * @var FakeUser
	 */
	private $user;

	/**
	 * @var IPostRegistration
	 */
	private $postRegistration;

	/**
	 * @var FakeActivation
	 */
	private $activation;

	/**
	 * @var WebLoginContext
	 */
	private $context;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeRegistrationPage();
		$this->fakeAuth = new FakeAuth();

		$this->activation = new FakeActivation();

		$this->user = new FakeUser();
		$this->user->ChangeEmailAddress('e@m.com');
		$this->context = new WebLoginContext($this->fakeServer, new LoginData(false, 'en_us'));

		$this->postRegistration = new PostRegistration($this->fakeAuth, $this->activation);
	}

	public function testRedirectsToHomepageIfUserIsActive()
	{
		$this->user->SetStatus(AccountStatus::ACTIVE);
		$this->user->ChangeDefaultHomePage(2);
		$this->postRegistration->HandleSelfRegistration($this->user, $this->page, $this->context);

		$this->assertTrue($this->fakeAuth->_LoginCalled);
		$this->assertEquals($this->user->EmailAddress(), $this->fakeAuth->_LastLogin);
		$this->assertFalse($this->fakeAuth->_LastLoginContext->GetData()->Persist);
		$this->assertEquals(Pages::UrlFromId(2), $this->page->_RedirectDestination);
	}

	public function testRedirectsToActiveIfUserNeedsActivation()
	{
		$this->user->SetStatus(AccountStatus::AWAITING_ACTIVATION);

		$this->postRegistration->HandleSelfRegistration($this->user, $this->page, $this->context);

		$this->assertFalse($this->fakeAuth->_LoginCalled);
		$this->assertTrue($this->activation->_NotifyCalled);
		$this->assertEquals($this->user, $this->activation->_NotifiedUser);
		$this->assertEquals(Pages::ACTIVATION, $this->page->_RedirectDestination);
	}
}

?>