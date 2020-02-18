<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/UserSessionRepository.php');

class UserSessionRepositoryTests extends TestBase
{
	/**
	 * @var UserSessionRepository
	 */
	private $repo;

	public function setUp(): void
	{
		parent::setup();

		$this->repo = new UserSessionRepository();
	}

	public function testLoadsByUserId()
	{
		$userId = 123;
		$token = 'my special token';

		$expectedSession = new WebServiceUserSession($userId);
		$expectedSession->SessionToken = $token;

		$serializedSession = serialize($expectedSession);

		$rows = array(ColumnNames::USER_ID => $userId, ColumnNames::SESSION_TOKEN => $token, ColumnNames::USER_SESSION => $serializedSession);

		$this->db->SetRows(array($rows));

		$command = new GetUserSessionByUserIdCommand($userId);

		$actualSession = $this->repo->LoadByUserId($userId);

		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertEquals($expectedSession, $actualSession);
	}

	public function testAddsSession()
	{
		$userId = 123;
		$token = 'my special token';

		$expectedSession = new WebServiceUserSession($userId);
		$expectedSession->SessionToken = $token;
		$expectedSession->UserId = $userId;

		$serializedSession = serialize($expectedSession);

		$this->repo->Add($expectedSession);

		$command = new AddUserSessionCommand($userId, $token, Date::Now(), $serializedSession);
		$this->assertEquals($command, $this->db->_LastCommand);
	}

	public function testUpdatesSession()
	{
		$userId = 123;
		$token = 'my special token';

		$expectedSession = new WebServiceUserSession($userId);
		$expectedSession->SessionToken = $token;
		$expectedSession->UserId = $userId;

		$serializedSession = serialize($expectedSession);

		$this->repo->Update($expectedSession);

		$command = new UpdateUserSessionCommand($userId, $token, Date::Now(), $serializedSession);
		$this->assertEquals($command, $this->db->_LastCommand);
	}

	public function testLoadsBySessionToken()
	{
		$userId = 123;
		$token = 'my special token';

		$expectedSession = new WebServiceUserSession($userId);
		$expectedSession->SessionToken = $token;

		$serializedSession = serialize($expectedSession);

		$rows = array(ColumnNames::USER_ID => $userId, ColumnNames::SESSION_TOKEN => $token, ColumnNames::USER_SESSION => $serializedSession);

		$this->db->SetRows(array($rows));

		$command = new GetUserSessionBySessionTokenCommand($token);

		$actualSession = $this->repo->LoadBySessionToken($token);

		$this->assertEquals($command, $this->db->_LastCommand);
		$this->assertEquals($expectedSession, $actualSession);
	}

	public function testDeletesBySessionToken()
	{
		$userId = 123;
		$token = 'my special token';

		$expectedSession = new WebServiceUserSession($userId);
		$expectedSession->SessionToken = $token;
		$expectedSession->UserId = $userId;

		$this->repo->Delete($expectedSession);

		$command = new DeleteUserSessionCommand($token);
		$this->assertEquals($command, $this->db->_LastCommand);
	}
}

?>