<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/ActivationPresenter.php');

class ActivationPresenterTests extends TestBase
{
	/**
	 * @var ActivationPresenter
	 */
	private $presenter;

	/**
	 * @var IActivationPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var FakeActivation
	 */
	private $accountActivation;

	/**
	 * @var FakeWebAuthentication
	 */
	private $auth;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IActivationPage');
		$this->accountActivation = new FakeActivation();
		$this->auth = new FakeWebAuthentication();

		$this->presenter = new ActivationPresenter($this->page, $this->accountActivation, $this->auth);
	}

	public function testActivatesAccount()
	{
		$user = new FakeUser(12);

		$activationSuccess = new ActivationResult(true, $user);
		$this->accountActivation->_ActivationResult = $activationSuccess;
		$activationCode = uniqid();

		$this->page->expects($this->once())
				->method('GetActivationCode')
				->will($this->returnValue($activationCode));

		$this->page->expects($this->once())
				->method('Redirect')
				->with($this->equalTo(Pages::UrlFromId($user->Homepage())));

		$this->presenter->PageLoad();

		$this->assertEquals($activationCode, $this->accountActivation->_LastActivationCode);
		$this->assertTrue($this->auth->_LoginCalled);
		$this->assertEquals($user->EmailAddress(), $this->auth->_LastLogin);
		$this->assertEquals(new WebLoginContext(new LoginData(false, $user->Language())), $this->auth->_LastLoginContext);
	}

	public function testWhenAccountCannotBeActivated()
	{
		$activationFailed = new ActivationResult(false);
		$this->accountActivation->_ActivationResult = $activationFailed;
		$activationCode = uniqid();

		$this->page->expects($this->once())
				->method('GetActivationCode')
				->will($this->returnValue($activationCode));

		$this->page->expects($this->once())
				->method('ShowError');

		$this->presenter->PageLoad();
	}
}

?>