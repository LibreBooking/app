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

		$this->userSessionRepository->expects($this->once())
				->method('LoadByUserId')
				->with($this->equalTo($session->UserId))
				->will($this->returnValue(null));

		$this->userSessionRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo(WebServiceUserSession::FromSession($session)));

		$actualSession = $this->webAuth->Login($this->username);

		$this->assertEquals($session, $actualSession);
	}

	public function testUpdateWhenSessionExistsInDatabase()
	{
		$user = new FakeUserSession();
		$this->fakeAuth->_Session = $user;

		$this->userSessionRepository->expects($this->once())
				->method('LoadByUserId')
				->with($this->equalTo($user->UserId))
				->will($this->returnValue(new WebServiceUserSession(123)));

		$this->userSessionRepository->expects($this->once())
				->method('Update')
				->with($this->equalTo(WebServiceUserSession::FromSession($user)));

		$actualSession = $this->webAuth->Login($this->username);

		$this->assertEquals($user, $actualSession);
	}

	public function testLogsUserOutIfUserIdAndSessionTokenMatch()
	{
		$publicId = 123;
		$sessionToken = 'token';

		$userSession = new WebServiceUserSession(1);
		$userSession->PublicId = $publicId;

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($sessionToken))
				->will($this->returnValue($userSession));

		$this->userSessionRepository->expects($this->once())
				->method('Delete')
				->with($this->equalTo($userSession));

		$this->webAuth->Logout($publicId, $sessionToken);

		$this->assertTrue($this->fakeAuth->_LogoutCalled);
	}

	public function testDoesNotLogUserOutIfUserIdAndSessionTokenMismatch()
	{
		$userId = 123;
		$sessionToken = 'token';

		$userSession = new WebServiceUserSession(999);
		$userSession->PublicId = '999';

		$this->userSessionRepository->expects($this->once())
				->method('LoadBySessionToken')
				->with($this->equalTo($sessionToken))
				->will($this->returnValue($userSession));

		$this->webAuth->Logout($userId, $sessionToken);

		$this->assertFalse($this->fakeAuth->_LogoutCalled);
	}

}

?>