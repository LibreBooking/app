<?php
/**
Copyright 2012-2016 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class WebServiceAuthenticationTests extends TestBase
{
	/**
	 * @var FakeAuth
	 */
	private $fakeAuth;

	/**
	 * @var WebServiceAuthentication
	 */
	private $webAuth;

	private $username = 'LoGInName';
	private $password = 'password';

	/**
	 * @var IUserSessionRepository
	 */
	private $userSessionRepository;

	public function setup()
	{
		parent::setup();

		WebServiceSessionToken::$_Token = 'hard coded token';

		$this->fakeAuth = new FakeAuth();
		$this->userSessionRepository = $this->getMock('IUserSessionRepository');

		$this->webAuth = new WebServiceAuthentication($this->fakeAuth, $this->userSessionRepository);
	}

	public function testValidatePassesThrough()
	{
		$this->fakeAuth->_ValidateResult = true;

		$isValid = $this->webAuth->Validate($this->username, $this->password);

		$this->assertEquals($this->username, $this->fakeAuth->_LastLogin);
		$this->assertEquals($this->password, $this->fakeAuth->_LastPassword);
		$this->assertTrue($isValid);
	}

	public function testSuccessfulLoginSetsSessionInDatabase()
	{
		$session = new FakeUserSession();
		$this->fakeAuth->_Session = $session;
		$expectedSession = WebServiceUserSession::FromSession($session);

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($expectedSession->SessionToken))
				->will($this->returnValue(null));

		$this->userSessionRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($expectedSession));

		$actualSession = $this->webAuth->Login($this->username);

		$this->assertEquals($expectedSession, $actualSession);
	}

	public function testUpdateWhenSessionExistsInDatabase()
	{
		$user = new FakeUserSession();
		$this->fakeAuth->_Session = $user;
		$expectedSession = WebServiceUserSession::FromSession($user);

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($expectedSession->SessionToken))
				->will($this->returnValue(new WebServiceUserSession(123)));

		$this->userSessionRepository->expects($this->once())
				->method('Update')
				->with($this->equalTo($expectedSession));

		$actualSession = $this->webAuth->Login($this->username);

		$this->assertEquals($expectedSession, $actualSession);
	}

	public function testLogsUserOutIfUserIdAndSessionTokenMatch()
	{
		$sessionToken = 'token';
		$userId = 91919;

		$userSession = new WebServiceUserSession($userId);
		$userSession->UserId = $userId;

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($sessionToken))
				->will($this->returnValue($userSession));

		$this->userSessionRepository->expects($this->once())
				->method('Delete')
				->with($this->equalTo($userSession));

		$this->webAuth->Logout($userId, $sessionToken);

		$this->assertTrue($this->fakeAuth->_LogoutCalled);
	}

	public function testDoesNotLogUserOutIfUserIdAndSessionTokenMismatch()
	{
		$userId = 123;
		$sessionToken = 'token';

		$userSession = new WebServiceUserSession(999);

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($sessionToken))
				->will($this->returnValue($userSession));

		$this->webAuth->Logout($userId, $sessionToken);

		$this->assertFalse($this->fakeAuth->_LogoutCalled);
	}

}

?>