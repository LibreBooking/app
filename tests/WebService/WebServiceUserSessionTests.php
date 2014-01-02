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

require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceUserSession.php');

class WebServiceUserSessionTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testExtendsSession()
	{
		$session = new WebServiceUserSession(123);
		$session->SessionExpiration = '2012-05-01';
		$session->ExtendSession();

		$this->assertEquals(WebServiceExpiration::Create(), $session->SessionExpiration);
	}

	public function testIsExpired()
	{
		$session = new WebServiceUserSession(123);
		$session->SessionExpiration = Date::Now()->AddMinutes(-1)->ToUtc()->ToIso();

		$this->assertTrue($session->IsExpired());
	}

	public function testIsNotExpired()
	{
		$session = new WebServiceUserSession(123);
		$session->SessionExpiration = Date::Now()->AddMinutes(1)->ToUtc()->ToIso();

		$this->assertFalse($session->IsExpired());
	}
}
?>