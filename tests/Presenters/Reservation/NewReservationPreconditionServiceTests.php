<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');

class NewReservationPreconditionServiceTests extends TestBase
{
	public function testBouncesWhenNoScheduleIdProvided()
	{
		$errorMessage = ErrorMessages::MISSING_SCHEDULE;

		$page = $this->getMock('INewReservationPage');

		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue(null));

		$page->expects($this->once())
			->method('RedirectToError')
			->with($this->equalTo($errorMessage));

		$preconditionService = new NewReservationPreconditionService();
		$preconditionService->CheckAll($page, $this->fakeUser);
	}
}
?>